<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin-Sign-Up</title>
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

    // Retrieving form data
    $Name = $_POST['Name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

        // Insert data into the database
        $sql = "INSERT INTO admin_sigup (Name, email, password, cpassword) 
                VALUES ('$name', '$email', '$password', '$cpassword')";

        if ($conn->query($sql) === TRUE) {
            header("Location:http://localhost/IT%20Workshop/Back-End/Admin/Main.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
      

    $conn->close();
}
?>
<section class=" bg-cover" style="background-image: url(http://localhost/IT%20Workshop/Back-End/Admin/image/laptop-5722338_1280.png )">
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Create an account
              </h1>
              <form class="space-y-4 md:space-y-6" action="" method="POST"enctype="multipart/form-data">
              <div>
                      <label for="FullName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                      <input type="text" name="Name" id="Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" required="">
                  </div>
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div>
                      <label for="cpassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                      <input type="confirm-password" name="cpassword" id="cpassword" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required=""
                         onkeyup="validate_password()">
                         <span id="wrong_pass_alert"></span>

                  </div>
                  <div class="flex items-start">
                      <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                      </div>
                      <div class="ml-3 text-sm">
                        <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                      </div>
                  </div>
                  <button type="submit " class="w-full text-white bg-sky-700 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"onclick="wrong_pass_alert()">Create an account</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Already have an account? <a href="login.php" class="font-medium text-sky-600 hover:underline dark:text-primary-500">Login here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>








<script>
   function validate_password() {
 
 var pass = document.getElementById('password').value;
 var confirm_pass = document.getElementById('cpassword').value;
 if (pass != confirm_pass) {
     document.getElementById('wrong_pass_alert').style.color = 'red';
     document.getElementById('wrong_pass_alert').innerHTML
       = '☒ Use same password';
     document.getElementById('submit').disabled = true;
     document.getElementById('submit').style.opacity = (0.4);
 } else {
     document.getElementById('wrong_pass_alert').style.color = 'green';
     document.getElementById('wrong_pass_alert').innerHTML =
         '🗹 Password Matched';
     document.getElementById('submit').disabled = false;
     document.getElementById('submit').style.opacity = (1);
 }
}

function wrong_pass_alert() {
 if (document.getElementById('password').value != "" &&
     document.getElementById('cpassword').value != "") {
     alert("Your response is submitted");
 } else {
     alert("Please fill all the fields");
 }
}
</script>
</body>
</html>