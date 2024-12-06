<?php
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $accessLevel = $_POST['accessLevel'];

    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "INSERT INTO users (matric, name, password, accessLevel) VALUES ('$matric', '$name', '$password', '$accessLevel')";
    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Registration Page</title>
    <script>
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showMessage('<?php echo $message; ?>')">
    <header>
        <h1>Registration Page</h1>
    </header>
    <div class="container">
        <form method="POST" action="registration.php">
            <label>Matric:</label>
            <input type="text" name="matric" required><br>
            <label>Name:</label>
            <input type="text" name="name" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <label>Role:</label>
            <select name="accessLevel" required>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select><br>
            <button type="submit">Register</button>
        </form>
        <p style="text-align: center; margin-top: 15px;">
            Already have an account? <a href="login.php" style="color: #007BFF; text-decoration: none;">Login here</a>
        </p>
    </div>
</body>
</html>