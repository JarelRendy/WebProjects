<?php
$conn = new mysqli("localhost", "root", "", "leray");
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin - Messages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
  <h2>Contact Messages</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Received At</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row["id"] ?></td>
          <td><?= $row["name"] ?></td>
          <td><?= $row["email"] ?></td>
          <td><?= $row["message"] ?></td>
          <td><?= $row["created_at"] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
