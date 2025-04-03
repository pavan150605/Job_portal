<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <title>Job Portal</title>

</head>
<body>
    <header>
        <h1>Welcome to the Job Portal</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="post_job.php">Post a Job</a></li> <!-- Link to post a job -->
                    <li><a href="view_jobs.php">View Jobs</a></li> <!-- Link to view jobs -->
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Welcome to the Job Portal</h2>
        <p>Use the navigation above to post a job or view available jobs.</p>
    </main>
    <footer>
        <p>&copy; 2023 Job Portal. All rights reserved.</p>
    </footer>
</body>
</html>