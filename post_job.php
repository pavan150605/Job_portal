<?php
session_start(); // Start the session

// Include database connection
$conn = new mysqli('localhost', 'root', '', 'job_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle form submission for posting a job
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get job details from the form
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO jobs (title, company, location, description, posted_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $title, $company, $location, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p>Job posted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <title>Post a Job</title>
</head>
<body>
    <header>
        <h1>Post a Job</h1>
    </header>
    <main>
        <form action="post_job.php" method="POST">
            <input type="text" name="title" placeholder="Job Title" required>
            <input type="text" name="company" placeholder="Company Name" required>
            <input type="text" name="location" placeholder="Location" required>
            <textarea name="description" placeholder="Job Description" required></textarea>
            <button type="submit">Post Job</button>
        </form>
        <p><a href="index.php">Home</a></p> <!-- Link to Home page -->
    </main>
    <footer>
        <p>&copy; 2023 Job Portal. All rights reserved.</p>
    </footer>
</body>
</html>