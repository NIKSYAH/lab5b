<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['accessLevel'] = $user['accessLevel'];
            header('Location: display.php');
            exit;
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "No user found with this matric!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label>Matric:</label>
        <input type="text" name="matric" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>