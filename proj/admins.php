<?php
include 'db.php';

// Handle admin deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM admins WHERE id = $id");
    header("Location: admins.php");
    exit();
}

// Handle add/edit admin
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $email = $conn->real_escape_string($_POST["email"]);
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    if ($id > 0) {
        // Update existing admin
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("UPDATE admins SET email='$email', password='$hashedPassword' WHERE id=$id");
        } else {
            $conn->query("UPDATE admins SET email='$email' WHERE id=$id");
        }
    } else {
        // Check if email already exists before insert
        $check = $conn->query("SELECT id FROM admins WHERE email='$email' LIMIT 1");
        if ($check->num_rows > 0) {
            // Email already exists - show alert and stop
            echo "<script>
                    alert('Error: Email already exists. Please use a different email.');
                    window.history.back();
                  </script>";
            exit();
        } else {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO admins (email, password) VALUES ('$email', '$hashedPassword')");
            }
        }
    }

    header("Location: admins.php");
    exit();
}

// Get admins
$result = $conn->query("SELECT * FROM admins ORDER BY id DESC");
$editAdmin = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $editAdmin = $conn->query("SELECT * FROM admins WHERE id = $editId")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 32px;
            margin-top: 20px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #607d8b;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            margin: 80px auto 20px auto;
            color: #333;
        }

        form input[type="email"],
        form input[type="password"] {
            width: 380px;
            padding-right: 20px;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form input[type="submit"] {
            background: #ba3c66;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }

        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.85);
            margin: 30px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background: #ba3c66;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #2196F3;
            font-weight: bold;
        }

        .actions a.delete {
            color: red;
        }
    </style>
</head>
<body>

<h2>👥 Manage Admins</h2>
<div style="text-align:center;">
    <a href="maindashboard.php" class="back-btn">⬅ Back</a>
</div>

<!-- Add/Edit Admin Form -->
<div class="container">
    <form method="post" action="admins.php">
        <h3 style="text-align:center; color:#ba3c66;"><?= $editAdmin ? "✏️ Edit Admin ID " . $editAdmin['id'] : "➕ Add New Admin" ?></h3>
        <input type="hidden" name="id" value="<?= $editAdmin['id'] ?? '' ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= $editAdmin['email'] ?? '' ?>" required>

        <label><?= $editAdmin ? "Change Password (optional):" : "Password:" ?></label>
        <input type="password" name="password" <?= $editAdmin ? "" : "required" ?>>

        <input type="submit" value="<?= $editAdmin ? "Update Admin" : "Add Admin" ?>">
    </form>
</div>

<!-- Admins Table -->
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td class="actions">
                <a href="admins.php?edit=<?= $row['id'] ?>">✏️ Edit</a>
                <a href="admins.php?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this admin?')">🗑️ Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
