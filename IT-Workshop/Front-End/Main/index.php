<?php
session_start();  // Start the session at the beginning

// Check if the session variable 'user_id' exists
if (isset($_SESSION['Id'])) {
    $Id = $_SESSION['Id'];
// Database connection
$host = 'localhost';
$db = 'e-library';
$user = 'root'; // Your MySQL username
$pass = '';     // Your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from the database
$result = $conn->query("SELECT * FROM books");

// Store books in an array
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
 // Prepare SQL query to fetch user data
 $query = "SELECT * FROM signup WHERE Id = ?";
 $stmt = $conn->prepare($query);
 $stmt->bind_param('i', $Id);  // Bind user_id to the query
 $stmt->execute();
 $result = $stmt->get_result();

 // Check if any user data is found
 if ($result->num_rows > 0) {
     $user = $result->fetch_assoc();  // Fetch user data into an associative array
 } else {
     echo "No user found with this ID.";
     exit;  // Stop further execution if no user is found
 }

 // Close the statement and connection
 $stmt->close();
 $conn->close();
} else {
 echo "User not logged in.";
 exit;  // Stop further execution if the session is not set
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>E-Library-</title>
</head>
<body>        
  <!--------------------Header ---------------------->
  
  <header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">E-Library</span>
            <div class="flex items-center lg:order-2">
            <a href="http://localhost/IT%20Workshop/Front-End/index.php" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log out</a>
            <!-- Modal toggle -->
             <!------------------------User Profile--------------------->
<!-- User Profile Toggle Button -->
 <!------------------------User Profile--------------------->
<div class="flex justify-center m-5">
  <button id="userProfileBtn" type="button" class=" hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium round-lg  text-sm px-5 py-2.5 text-center ">
    <img src="http://localhost/IT%20Workshop/Front-End/image/user.png" alt="User Icon" width="20" height="20">
  </button>
</div>

<!-- User Profile Modal -->
<div id="userProfileModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="relative p-6 bg-white rounded-lg shadow dark:bg-gray-800 max-w-lg w-full">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">User Profile</h3>
      <button id="closeUserProfile" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <p class="text-gray-500 dark:text-gray-400">Name: <span class="font-bold "><?= htmlspecialchars($user['Name']) ?></span></p>
    <p class="text-gray-500 dark:text-gray-400">Roll No: <span class="font-bold"><?= htmlspecialchars($user['Roll_no']) ?></span></p>
    <p class="text-gray-500 dark:text-gray-400">Registration No: <span class="font-bold"><?= htmlspecialchars($user['Registration_number']) ?></span></p>
    <p class="text-gray-500 dark:text-gray-400">Student Id: <span class="font-bold"><?= htmlspecialchars($user['Id']) ?></span></p>

    <button id="logoutButton" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
    <a href="http://localhost/IT%20Workshop/Front-End/login.php">Log Out</a></button>
  </div>
</div>

<!------------------------User Profile--------------------->


               <button id="menu-btn" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open main menu</span>
                    <!-- Open icon -->
                    <svg id="menu-open-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <!-- Close icon (hidden by default) -->
                    <svg id="menu-close-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                <li><a href="Front-End/main/Book/index.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Home</a></li>   
                <li><a href="#" class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white">Books</a></li>
                    <li><a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Donate</a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>


<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <!-- Heading & Filters -->
    <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
      <div>
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
              <a href="" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="me-2.5 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                </svg>
                Home
              </a>
            </li>
          
            <li aria-current="page">
              <div class="flex items-center">
                <svg class="h-5 w-5 text-gray-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                </svg>
                <span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ms-2">Books</span>
              </div>
            </li>
          </ol>
        </nav>
        <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Books</h2>
      </div>
      <div class="flex items-center space-x-4">
        <button data-modal-toggle="filterModal" data-modal-target="filterModal" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
          <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
          </svg>
          Filters
          <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
          </svg>
        </button>
        <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
          <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
          </svg>
          Sort
          <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
          </svg>
        </button>
        <div id="dropdownSort1" class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700" data-popper-placement="bottom">
          <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400" aria-labelledby="sortDropdownButton">
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Popular books</a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Newest </a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Increasing price </a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Decreasing price </a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> No. reviews </a>
            </li>
            <li>
              <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"> Discount % </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <h1 class="text-4xl font-bold text-center text-sky-800 dark:text-white mb-6">Library Book Collection</h1>

    <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
    <?php foreach ($books as $book): ?>
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="h-56 w-full">
                <a href="#">
                    <?php
                    // Assuming your image file names are stored in the database as 'Cover_Image' without the path.
                    $coverImage = 'http://localhost/IT%20Workshop/Back-End/Admin/Add%20books/cover/' . htmlspecialchars($book['Cover_Image']); // Adjust the path
                    ?>
                    <img class="mx-auto h-full" src="<?= $coverImage ?>" alt="<?= htmlspecialchars($book['Title']) ?>" onerror="this.onerror=null; this.src='path/to/default-image.jpg';"> <!-- Optional: Default image if not found -->
                </a>
            </div>
            <div class="pt-6">
                <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
                    <?= htmlspecialchars($book['Title']) ?>
                </a>
                <p class="text-gray-600" hidden>by <?= htmlspecialchars($book['Book_ID']) ?></p>
                <p class="text-gray-600">By: <?= htmlspecialchars($book['Author']) ?></p>
                <p class="text-gray-500">Genre: <?= htmlspecialchars($book['Genre']) ?></p>
                <p class="text-gray-500">Publisher: <?= htmlspecialchars($book['Publisher']) ?></p>
                <p class="text-gray-500">Publication Year: <?= htmlspecialchars($book['Publication_Year']) ?></p>
                <p class="text-gray-500">Language: <?= htmlspecialchars($book['Language']) ?></p>
                <p class="text-gray-500">Number of Copies: <?= htmlspecialchars($book['Number_of_Copies']) ?></p>

                <p class="text-gray-500 description">
                    <button class="open-modal text-blue-500 hover:underline" data-description="<?= htmlspecialchars($book['Description']) ?>">
                     Description
                </button>
                </p>

                <div class="mt-4 flex items-center justify-between gap-4">
                <form action="book/borrow.php" method="POST">
    <input type="hidden" name="Book_ID" value="<?= $book['Book_ID'] ?>">
    <input type="hidden" name="Name" value="<?= $signup['Name'] ?>">
    <button type="submit" onclick ="window.location" class="bg-sky-700 inline-flex items-center rounded-lg px-5 py-2.5">
        Borrow
    </button>
</form>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Structure -->
<div id="descriptionModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg dark:bg-gray-800">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Book Description</h2>
        <p id="modalDescription" class="mt-4 text-gray-600 dark:text-gray-400"></p>
        <button class="close-modal mt-6 bg-red-500 px-4 py-2 text-white rounded hover:bg-red-600">Close</button>
    </div>
</div>

<!--------------------Footer ---------------------->
<footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-900">
    <div class="mx-auto max-w-screen-xl text-center">
        <a href="#" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
            <svg class="mr-2 h-8" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG content -->
            </svg>
        </a>
        <p class="my-6 text-gray-500 dark:text-gray-400">Open-source library of over 400+ web components and interactive elements built for better web.</p>
        <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
            <li><a href="#" class="mr-4 hover:underline md:mr-6">About</a></li>
            <li><a href="#" class="mr-4 hover:underline md:mr-6">Donate</a></li>
            <li><a href="#" class="mr-4 hover:underline md:mr-6">Youtube Links</a></li>
            <li><a href="#" class="mr-4 hover:underline md:mr-6">Blog</a></li>
            <li><a href="#" class="mr-4 hover:underline md:mr-6">Contact</a></li>
        </ul>
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2021-2022 <a href="#" class="hover:underline">Flowbite™</a>. All Rights Reserved.</span>
    </div>
</footer>
<script>
    // Modal Open Functionality
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function () {
            const description = this.getAttribute('data-description');
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('descriptionModal').classList.remove('hidden');
        });
    });

    // Modal Close Functionality
    document.querySelector('.close-modal').addEventListener('click', function () {
        document.getElementById('descriptionModal').classList.add('hidden');
    });

    // Optional: Close modal on background click
    document.getElementById('descriptionModal').addEventListener('click', function (e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

<style>
    .hidden {
        display: none;
    }
</style>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu-2');
    const menuOpenIcon = document.getElementById('menu-open-icon');
    const menuCloseIcon = document.getElementById('menu-close-icon');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden'); // Toggle the visibility of the menu
        menuOpenIcon.classList.toggle('hidden'); // Toggle between the open and close icon
        menuCloseIcon.classList.toggle('hidden');
    });
</script>

  <!--------------------Header ---------------------->


 <!--------------------User Profile ---------------------->
 <script>
// Modal elements
const userProfileBtn = document.getElementById('userProfileBtn');
const userProfileModal = document.getElementById('userProfileModal');
const closeUserProfile = document.getElementById('closeUserProfile');

// Open the modal
userProfileBtn.addEventListener('click', () => {
  userProfileModal.classList.remove('hidden');
  userProfileModal.classList.add('flex');
});

// Close the modal
closeUserProfile.addEventListener('click', () => {
  userProfileModal.classList.add('hidden');
  userProfileModal.classList.remove('flex');
});

// Optional: Close modal when clicking outside the content
userProfileModal.addEventListener('click', (event) => {
  if (event.target === userProfileModal) {
    userProfileModal.classList.add('hidden');
    userProfileModal.classList.remove('flex');
  }
});


</script>
 <!--------------------User Profile ---------------------->


</body>
</html>
