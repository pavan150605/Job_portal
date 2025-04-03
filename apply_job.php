<?php
session_start(); // Start the session

// Include database connection
$conn = new mysqli('localhost', 'root', '', 'job_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the job ID is provided
if (isset($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']); // Get the job ID from the URL
} else {
    die("Job ID not specified."); // This message will show if job_id is not in the URL
}

// Fetch job details for display
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

// Check if the job exists
if (!$job) {
    die("Job not found.");
}

// Handle form submission for applying to a job
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Get the user's email

    // Get the company name and job title from the fetched job details
    $company_name = $job['company']; // Assuming 'company' is a column in the jobs table
    $job_title = $job['title']; // Assuming 'title' is a column in the jobs table

    // Now insert the application into the applications table
    $stmt = $conn->prepare("INSERT INTO applications (user_email, company_name, job_title) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $company_name, $job_title);
    
    if ($stmt->execute()) {
        echo "<p>Application submitted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <title>Apply for Job</title>
</head>
<body>
    <header>
        <h1>Apply for Job: <?php echo htmlspecialchars($job['title']); ?></h1>
    </header>
    <main>
        <h2>Job Details</h2>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>

        <h2>Application Form</h2>
        <form action="apply_job.php?job_id=<?php echo $job_id; ?>" method="POST">
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Submit Application</button>
        </form>
    </main>
    <footer>
        <p><a href="index.php">Home</a></p> <!-- Link to Home page -->
        <p>&copy; 2023 Job Portal. All rights reserved.</p>
    </footer>
</body>
</html>