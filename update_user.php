<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $role, $matric);
    $stmt->execute();
    $stmt->close();

    header("Location: display_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 10px 15px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }
        .btn-submit {
            background-color: #5cb85c;
            border: none;
        }
        .btn-cancel {
            background-color: #d9534f;
            border: none;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Update User</h1>
        <form action="" method="POST">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" value="<?= htmlspecialchars($user['matric']) ?>" readonly>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="<?= htmlspecialchars($user['role']) ?>" required>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Update</button>
                <a href="display_users.php" >Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
