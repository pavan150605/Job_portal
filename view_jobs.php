<?php
session_start(); // Start the session

// Include database connection
$conn = new mysqli('localhost', 'root', '', 'job_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <title>View Jobs</title>
</head>
<body>
    <header>
        <h1>Job Listings</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li> <!-- Link to navigate to home page -->
            </ul>
        </nav>
    </header>
    <main>
        <h2>Available Jobs</h2>
        
        <?php
        // Fetch jobs from the database
        $sql = "SELECT * FROM jobs ORDER BY posted_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='job-listing'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company']) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p><em>Posted on: " . htmlspecialchars($row['posted_at']) . "</em></p>";
                // Ensure job ID is passed in the "Apply Now" link
                echo "<a href='apply_job.php?job_id=" . $row['id'] . "'>Apply Now</a>"; 
                echo "</div>";
            }
        } else {
            echo "<p>No job listings available.</p>";
        }

        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; 2023 Job Portal. All rights reserved.</p>
    </footer>
</body>
</html>