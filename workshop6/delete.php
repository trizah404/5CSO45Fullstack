<?php
require 'db.php';
$stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
$stmt->execute([$_POST['id']]);
header("Location: index.php?msg=deleted");
exit;