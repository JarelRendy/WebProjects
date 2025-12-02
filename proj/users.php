<?php
include 'db.php';

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: users.php");
    exit();
}

// Handle form submission (Add or Edit)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $email = $conn->real_escape_string($_POST["email"]);
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    $full_name = $conn->real_escape_string($_POST["full_name"]);
    $department = $conn->real_escape_string($_POST["department"]);
    $birthday = $conn->real_escape_string($_POST["birthday"]);
    $age = intval($_POST["age"]);
    $profile_pic = null;
    $updatePic = false;

    if (!empty($_FILES['profile_pic']['tmp_name'])) {
        $profile_pic = file_get_contents($_FILES['profile_pic']['tmp_name']);
        $profile_pic = $conn->real_escape_string($profile_pic);
        $updatePic = true;
    }

    if ($id > 0) {
        $query = "UPDATE users SET email='$email', full_name='$full_name', department='$department', birthday='$birthday', age=$age";
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password='$hashed'";
        }
        if ($updatePic) {
            $query .= ", profile_pic='$profile_pic'";
        }
        $query .= " WHERE id=$id";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (email, password, full_name, department, birthday, age, profile_pic) VALUES ('$email', '$hashed', '$full_name', '$department', '$birthday', $age, ";
        $query .= $updatePic ? "'$profile_pic'" : "NULL";
        $query .= ")";
    }

    $conn->query($query);
    header("Location: users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");

// Fetch user to edit
$editUser = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    if ($editId >= 0) {
        $editUser = $conn->query("SELECT * FROM users WHERE id = $editId")->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
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
            padding: 30px;
            border-radius: 15px;
            max-width: 37%;
            margin: 50px auto;
            color: #333;
        }

        form input, form select {
            width: 95%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 13px;
        }

        form input[type="submit"] {
            background: #ba3c66;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        table {
            width: 100%;
            max-width: 90%;
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

<h2>👥 Manage Users</h2>
<a href="users.php" class="back-btn">⬅ Back</a>

<?php if (isset($_GET['edit'])): ?>
    <!-- Edit or Add Form -->
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <h3 style="text-align:center; color:#ba3c66;">
                <?= isset($editUser['id']) ? "✏️ Edit User #{$editUser['id']}" : "➕ Add New User" ?>
            </h3>
            <input type="hidden" name="id" value="<?= isset($editUser['id']) ? $editUser['id'] : 0 ?>">
            <label>Email:</label>
            <input type="email" name="email" value="<?= isset($editUser['email']) ? htmlspecialchars($editUser['email']) : '' ?>" required>
            <label>New Password (leave blank to keep current):</label>
            <input type="password" name="password">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?= isset($editUser['full_name']) ? htmlspecialchars($editUser['full_name']) : '' ?>">
            <label>Department:</label>
            <input type="text" name="department" value="<?= isset($editUser['department']) ? htmlspecialchars($editUser['department']) : '' ?>">
            <label>Birthday:</label>
            <input type="date" name="birthday" value="<?= isset($editUser['birthday']) ? $editUser['birthday'] : '' ?>">
            <label>Age:</label>
            <input type="number" name="age" value="<?= isset($editUser['age']) ? $editUser['age'] : '' ?>">
            <label>Profile Picture:</label>
            <input type="file" name="profile_pic">
            <input type="submit" value="<?= isset($editUser['id']) ? 'Update User' : 'Add User' ?>">
        </form>
    </div>
<?php else: ?>
    <!-- Users Table + Add Button -->
    <div style="text-align:center;">
        <a href="users.php?edit=0" style="background:#4CAF50; color:white; padding:10px 20px; border-radius:8px; text-decoration:none;">➕ Add New User</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Department</th>
            <th>Birthday</th>
            <th>Age</th>
            <th>Profile Picture</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= $row['birthday'] ?></td>
                <td><?= $row['age'] ?></td>
                <td>
            <?php if (!empty($row['profile_pic'])): ?>
                <a href="view_profile_pic.php?id=<?= $row['id'] ?>" target="_blank">🔍 View</a>
            <?php else: ?>
                N/A
            <?php endif; ?>

                <td class="actions">
                    <a href="users.php?edit=<?= $row['id'] ?>">✏️ Edit</a>
                    <a href="users.php?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this user?')">🗑️ Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

</body>
</html>
