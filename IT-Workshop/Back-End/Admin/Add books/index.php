<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Books | E-Library</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-library";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data safely using isset()
    $Title = isset($_POST['Title']) ? $conn->real_escape_string($_POST['Title']) : '';
    $Author = isset($_POST['Author']) ? $conn->real_escape_string($_POST['Author']) : '';
    $Publisher = isset($_POST['Publisher']) ? $conn->real_escape_string($_POST['Publisher']) : '';
    $Publication_Year = isset($_POST['Publication_Year']) ? $_POST['Publication_Year'] : '';
    $Genre = isset($_POST['Genre']) ? $conn->real_escape_string($_POST['Genre']) : '';
    $Language = isset($_POST['Language']) ? $conn->real_escape_string($_POST['Language']) : '';
    $Number_of_Copies = isset($_POST['Number_of_Copies']) ? (int)$_POST['Number_of_Copies'] : 0;
    $Location = isset($_POST['Location']) ? $conn->real_escape_string($_POST['Location']) : '';
    $Description = isset($_POST['Description']) ? $conn->real_escape_string($_POST['Description']) : '';
    $Status = isset($_POST['Status']) ? $conn->real_escape_string($_POST['Status']) : '';
    $Cover_Image = $_FILES['Cover_Image']['name'];

    // Define the upload directory
    $target_dir = realpath(__DIR__ . "/cover/") . "/";

    // Check if the directory exists and is writable
    if (!$target_dir || !is_dir($target_dir)) {
        die("Error: Upload directory does not exist.");
    }
    if (!is_writable($target_dir)) {
        die("Error: Upload directory is not writable.");
    }

    // Upload the file
    if (is_uploaded_file($_FILES['Cover_Image']['tmp_name'])) {
        $target_file = $target_dir . basename($_FILES['Cover_Image']['name']);
        
        if (move_uploaded_file($_FILES['Cover_Image']['tmp_name'], $target_file)) {
            // Prepare the SQL query
            $sql = "INSERT INTO books (Title, Author, Publisher, Publication_Year, Genre, Language, 
                      Number_of_Copies, Location, Description, Status, Cover_Image) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            // Check if statement was prepared
            if ($stmt) {
                $stmt->bind_param("ssssssissss", $Title, $Author, $Publisher, $Publication_Year, 
                                  $Genre, $Language, $Number_of_Copies, $Location, $Description, 
                                  $Status, $Cover_Image);

                if ($stmt->execute()) {
                    header("Location: http://localhost/IT%20Workshop/Front-End/main/index.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file was uploaded.";
    }

    $conn->close();
}
?>

<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a New Book</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="Title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book Name</label>
                    <input type="text" name="Title" id="Title" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author</label>
                    <input type="text" name="Author" id="Author" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Publisher" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publisher</label>
                    <input type="text" name="Publisher" id="Publisher" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Publication_Year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publication Year</label>
                    <input type="text" name="Publication_Year" id="Publication_Year" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Genre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Genre</label>
                    <select name="Genre" id="Genre" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                        <option value="">Select Genre</option>
                        <option value="Literature">Literature</option>
                        <option value="Science & Technology">Science & Technology</option>
                        <option value="Historical">Historical</option>
                        <option value="Self-Help / Personal Development">Self-Help / Personal Development</option>
                    </select>
                </div>
                <div>
                    <label for="Language" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Language</label>
                    <input type="text" name="Language" id="Language" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Number_of_Copies" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Copies</label>
                    <input type="number" name="Number_of_Copies" id="Number_of_Copies" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="Location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                    <input type="text" name="Location" id="Location" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="Description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="Description" id="Description" rows="4" class="bg-gray-50 border rounded-lg block w-full p-2.5" required></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label for="Status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <input type="text" name="Status" id="Status" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="Cover_Image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover Image</label>
                    <input type="file" name="Cover_Image" id="Cover_Image" class="bg-gray-50 border rounded-lg block w-full p-2.5" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-700 text-white px-5 py-2.5 mt-6 rounded-lg">Add Book</button>
        </form>
    </div>
</section>
</body>
</html>
