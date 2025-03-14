<?php
session_start(); // Start the session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = trim($_POST['Name']);
    $Roll_no = trim($_POST['Roll_No']);

    // Create a connection
    $conn = new mysqli('localhost', 'root', '', 'e-library');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM signup WHERE Name = ? AND Roll_no = ?");
    $stmt->bind_param("ss", $Name, $Roll_no);  // Use both Name and Roll_no for better validation
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    // Check if a user was found
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        
        // Store the user ID and User name in the session
        $_SESSION['Id'] = $data['Id'];  
        $_SESSION['Name'] = $data['Name'];  

        // Redirect to the main page
        header("Location: http://localhost/IT%20Workshop/Front-End/main/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid Name or Roll No";
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="Css/login.css">
    <title>E-Library Sign-in | Official site</title>
</head>
<body>

<?php
// Display error messages from the session
if (isset($_SESSION['error'])) {
    echo "<h2 class='text-red-500'>" . $_SESSION['error'] . "</h2>";
    unset($_SESSION['error']); // Unset the session variable after displaying the error
}
?>

<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            E-Library    
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" action="" method="post">
                    <div>
                        <label for="Name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                        <input type="text" id="Name" name="Name" placeholder="John" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div>
                        <label for="Roll_No" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Roll No</label>
                        <input type="number" id="Roll_No" name="Roll_No" placeholder="12105" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>
                        <a href="#" class="text-sm text-white font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="SignUp.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>


</body>
</html>
