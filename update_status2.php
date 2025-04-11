<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST["task_id"];
    $status = $_POST["status"] == 1 ? 0 : 1;

    $stmt = $conn->prepare("UPDATE task SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $task_id);
    $stmt->execute();
    $stmt->close();
}
header("Location: index.php"); // atau index.php tergantung arah balik
exit();
