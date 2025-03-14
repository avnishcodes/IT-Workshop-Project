<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['Id']) || !isset($_SESSION['Name'])) {
    echo "You need to log in to borrow a book.";
    exit;
}

// MySQL database configuration
$host = "localhost";  
$username = "root";  
$password = "";  
$database = "e-library";  

// Establish a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$Book_ID = $Title = $Author = $Publisher = $Genre = $Language = "";

// Check if a book ID is provided via GET request
if (isset($_GET['Book_ID'])) {
    $Book_ID = intval($_GET['Book_ID']); // Convert Book_ID to integer for safety

    // SQL query to fetch book details
    $sql = "SELECT * FROM books WHERE Book_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Book_ID);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $Title = $row['Title'];
        $Author = $row['Author'];
        $Publisher = $row['Publisher'];
        $Genre = $row['Genre'];
        $Language = $row['Language'];
    } else {
        // Redirect to the home page if the book is not found
        header('Location: http://localhost/IT%20Workshop/Front-End/main/index.php');
        exit;
    }
}

// Handle form submission for borrowing a book
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Book_ID = $_POST['Book_ID'];
    $User_ID = $_SESSION['Id'];
    $Name = $_SESSION['Name'];
    $Title = $_POST['Title'] ?? '';
    $Author = $_POST['Author'] ?? '';
    $Publisher = $_POST['Publisher'] ?? '';
    $Borrow_Date = date('Y-m-d');

    // Set return date to 6 months later
    $date = new \DateTime($Borrow_Date);
    $date->modify('+6 months');
    $Return_Date = $date->format('Y-m-d');

    // Check if the book exists and is available
    $stmt = $conn->prepare("SELECT Title, Author, Publisher FROM books WHERE Book_ID = ? AND Number_of_Copies > 0");
    $stmt->bind_param("i", $Book_ID);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    // Fetch book details if it exists and is available
    if ($stmt_result->num_rows > 0) {
        $book = $stmt_result->fetch_assoc();
        $Title = $book['Title'];
        $Author = $book['Author'];
        $Publisher = $book['Publisher'];

        // Insert a record into the borrow table
        $borrow_stmt = $conn->prepare("INSERT INTO borrow_records (User_ID, Name, Book_ID, Title, Author, Publisher, Borrow_Date, Return_Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $borrow_stmt->bind_param("isssssss", $User_ID, $Name, $Book_ID, $Title, $Author, $Publisher, $Borrow_Date, $Return_Date);

        // Execute the borrow statement and check for errors
        if ($borrow_stmt->execute()) {
            // Update the number of copies in the books table
            $update_stmt = $conn->prepare("UPDATE books SET Number_of_Copies = Number_of_Copies - 1 WHERE Book_ID = ?");
            $update_stmt->bind_param("i", $Book_ID);
            if (!$update_stmt->execute()) {
                echo "Error updating book copies: " . $update_stmt->error;
            }
        } else {
            echo "Error borrowing the book: " . $borrow_stmt->error; // Show error message if insert fails
        }
    } else {
        echo "<p>Book not available or out of stock.</p>";
    }

    // Close connections
    $stmt->close();
    $borrow_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow a Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, button {
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Borrow a Book</h2>

        <form action="" method="POST">
            <fieldset>
                <legend>Selected Book</legend>
                <p><strong>Book ID:</strong> <?php echo htmlspecialchars($Book_ID); ?></p>
                <input type="hidden" name="Book_ID" value="<?php echo htmlspecialchars($Book_ID); ?>">
                <p><strong>Borrower:</strong> <?php echo htmlspecialchars($Name); ?></p>
                <input type="hidden" name="Name" value="<?php echo htmlspecialchars($Name); ?>">

                <p><strong>Title:</strong> <?php echo htmlspecialchars($Title); ?></p>
                <input type="hidden" name="Title" value="<?php echo htmlspecialchars($Title); ?>">

                <p><strong>Author:</strong> <?php echo htmlspecialchars($Author); ?></p>
                <input type="hidden" name="Author" value="<?php echo htmlspecialchars($Author); ?>">
                
                <p><strong>Publisher:</strong> <?php echo htmlspecialchars($Publisher); ?></p>
                <input type="hidden" name="Publisher" value="<?php echo htmlspecialchars($Publisher); ?>">
            </fieldset>

            <label for="Return_Date">Return Date (set to 6 months from now):</label>
            <input type="date" id="Return_Date" name="Return_Date" value="<?php echo $Return_Date; ?>" readonly>
            <button type="submit">Borrow</button>
        </form>
    </div>
</body>
</html>
