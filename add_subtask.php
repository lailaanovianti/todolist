<?php
include 'db.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : null;
    $subtask_name = isset($_POST['subtask_title']) ? $_POST['subtask_title'] : null;


    if (!empty($task_id) && !empty($subtask_name)) {
        $stmt = $conn->prepare("INSERT INTO subtask (task_id, subtask_name) VALUES (?, ?)");
        $stmt->bind_param("is", $task_id, $subtask_name);

        if ($stmt->execute()) {
            header("Location: subtask.php?task_id=$task_id");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Subtask tidak boleh kosong.";
    }
} else {
    echo "Invalid request.";
}
?>
