<?php
session_start(); // Start the session

// Include database connection
$db_handle = pg_connect("host=dpg-cnb35cdjm4es738bno8g-a.oregon-postgres.render.com dbname=postgres_taskmate_1wam user=postgres_taskmate_1wam_user password=qcx6iSdIRTJbZ2L4n9nmLAJfb3XYMCQp");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            header("Location: index.php"); // Redirect to the homepage
            exit();
        } else {
            echo "<p>Invalid password.</p>";
        }
    } else {
        echo "<p>No user found with that email.</p>";
    }

    // Close the statement
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
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Create a new account</a></p> <!-- Link to registration -->
    </main>
    <footer>
        <p>&copy; 2023 Job Portal. All rights reserved.</p>
    </footer>
</body>
</html>
