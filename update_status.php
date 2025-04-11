<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subtask_id = $_POST["subtask_id"];
    $status = $_POST["status"] == 1 ? 0 : 1;

    $stmt = $conn->prepare("UPDATE subtask SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $subtask_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
