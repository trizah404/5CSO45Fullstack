<?php
require 'db.php';
$stmt = $pdo->prepare("UPDATE students SET name=?, email=?, course=? WHERE id=?");
$stmt->execute([$_POST['name'], $_POST['email'], $_POST['course'], $_POST['id']]);
header("Location: index.php?msg=updated");
exit; 