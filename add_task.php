<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST['task_name'];
    $priority = $_POST['priority'];
    $reminder_date = $_POST['reminder_date'];

    $sql = "INSERT INTO task (task_name, priority, reminder_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $task_name, $priority, $reminder_date);

    if ($stmt->execute()) {
        echo "Task added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {
    $task_name = $_POST["task_name"];
    $priority = $_POST["priority"];
    $reminder_date = $_POST["reminder_date"];

    if (!empty($task_name)) {
        $sql = "INSERT INTO task (task_name, priority, reminder_date, status) VALUES (?, ?, ?, FALSE)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $task_name, $priority, $reminder_date);
        $stmt->execute();
        $task_id = $stmt->insert_id;
        $stmt->close();

        if (!empty($_POST["subtasks"])) {
            foreach ($_POST["subtasks"] as $subtask_name) {
                if (!empty($subtask_name)) {
                    $sql = "INSERT INTO subtask (task_id, subtask_name, status) VALUES (?, ?, FALSE)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("is", $task_id, $subtask_name);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }
}

?>
