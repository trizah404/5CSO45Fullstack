<?php
require 'db.php';
$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Students</title></head>
<body>
  <h1>Students</h1>
  <p><a href="create.php">Add Student</a></p>
  <table border="1" cellpadding="8">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Actions</th></tr>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= $s['id'] ?></td>
        <td><?= htmlspecialchars($s['name']) ?></td>
        <td><?= htmlspecialchars($s['email']) ?></td>
        <td><?= htmlspecialchars($s['course']) ?></td>
        <td>
          <a href="edit.php?id=<?= $s['id'] ?>">Edit</a>
          <form action="delete.php" method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= $s['id'] ?>">
            <button type="submit" onclick="return confirm('Delete this student?')">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html> 