<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'Lab_5b');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name='$name', accessLevel='$accessLevel' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        // Redirect to display.php with a success message
        header('Location: display.php?message=updated');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id='$id'");
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update User</title>
</head>
<body>
    <form method="POST" action="update_user.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        <label>Access Level:</label>
        <select name="accessLevel" required>
            <option value="student" <?php if ($user['accessLevel'] === 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($user['accessLevel'] === 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>