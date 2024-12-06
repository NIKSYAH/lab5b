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

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Display Users</title>
    <script>
        // Display popup message if the "message" parameter is present
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('message') && urlParams.get('message') === 'updated') {
                alert('User updated successfully!');
            }
        };
    </script>
</head>
<body>
<header>
        <h1>User Detail Page</h1>
    </header>
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['matric']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['accessLevel']; ?></td>
                    <td>
                        <a href="update_user.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>