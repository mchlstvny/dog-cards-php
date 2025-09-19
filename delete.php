<?php
require 'dbconnect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Dog ID missing or invalid.");
}

$id = (int) $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM dogs WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    echo "Delete failed: " . $e->getMessage();
}

?>