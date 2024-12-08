<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lab_5b"; // 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $role = $_POST['role'];

    // Insert data into the database
    $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $matric, $name, $password, $role);
        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
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
    <title>Registration Page</title>
    <style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    width: 100%;
    max-width: 400px;
}

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message {
            text-align: center;
            font-size: 14px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($message)) : ?>
            <p class="message <?= strpos($message, 'Error') !== false ? 'error' : '' ?>"><?= $message ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Please select</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
