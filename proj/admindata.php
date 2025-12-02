<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f6f8; }
        h1 { text-align: center; color: #333; }
        .btn-group { text-align: center; margin: 20px 0; }
        .btn {
            padding: 10px 20px; margin: 10px; font-size: 16px; 
            cursor: pointer; background: #4CAF50; color: white; border: none; 
            border-radius: 5px; text-decoration: none;
            display: inline-block;
        }
        .btn:hover { background: #45a049; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        a.action-link { color: #007BFF; text-decoration: none; margin: 0 5px; }
        a.action-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <div class="btn-group">
        <a href="?view=users" class="btn">Users</a>
        <a href="?view=admins" class="btn">Admins</a>
        <a href="add_user.php" class="btn" style="background:#2196F3;">Add New User</a>
        <a href="add_admin.php" class="btn" style="background:#2196F3;">Add New Admin</a>
        <a href="logout.php" class="btn" style="background:#f44336;">Logout</a>
    </div>

<?php
$view = $_GET['view'] ?? 'users';  // default to 'users'

// Users Table Display
if ($view == 'users') {
    echo "<h2>Users List</h2>";
    $result = $conn->query("SELECT * FROM users");  // use your actual table name here
    if ($result->num_rows > 0) {
        echo "<table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['email']}</td>
                <td>
                    <a class='action-link' href='edit_user.php?id={$row['id']}'>Edit</a> |
                    <a class='action-link' href='delete_user.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this user?');\">delete</a> |
                    <a class='action-link' href='reset_password.php?id={$row['id']}&type=user'>Reset Password</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }
} 

// Admins Table Display
elseif ($view == 'users') {
    echo "<h2>Admins List</h2>";
    $result = $conn->query("SELECT * FROM userss");
    if ($result->num_rows > 0) {
        echo "<table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Position</th><th>Phone</th><th>Actions</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$name}</td>
                <td>{$row['email']}</td>
                <td>{$row['position']}</td>
                <td>{$row['phone']}</td>
                <td>
                    <a class='action-link' href='edit_admin.php?id={$row['id']}'>Edit</a> |
                    <a class='action-link' href='delete_admin.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this admin?');\">Delete</a> |
                    <a class='action-link' href='reset_password.php?id={$row['id']}&type=admin'>Reset Password</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No admins found.</p>";
    }
}

// Edit History Table
elseif ($view == 'history') {
    echo "<h2>Edit History</h2>";
    $sql = "SELECT h.*, a.firstname, a.lastname 
            FROM edit_history h
            JOIN admins a ON h.admin_id = a.id
            ORDER BY h.timestamp DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
            <tr>
                <th>ID</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Target Type</th>
                <th>Target ID</th>
                <th>Timestamp</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            $adminName = htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$adminName}</td>
                <td>{$row['action']}</td>
                <td>{$row['target_type']}</td>
                <td>{$row['target_id']}</td>
                <td>{$row['timestamp']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No history found.</p>";
    }
}

// Invalid View
else {
    echo "<p>Invalid view selected.</p>";
}
?>

</body>
</html>
