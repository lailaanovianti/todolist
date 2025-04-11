<?php
include 'db.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "SELECT * FROM task WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_task"])) {
    $task_id = $_POST["task_id"];
    $task_name = $_POST["task_name"];
    $priority = $_POST["priority"];
    $reminder_date = $_POST["reminder_date"];

    $sql = "UPDATE task SET task_name = ?, priority = ?, reminder_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $task_name, $priority, $reminder_date, $task_id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
    .container {
    width: 100%;
    min-height: 100vh;
    background: hsl(331, 65.30%, 85.30%);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
    .edit-container {
        width: 400px;
        background: #e76f8f;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin: 50px auto;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        color: white;
    }
    .edit-container input, .edit-container select {
        padding: 10px;
        margin-bottom: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        outline: none;
    }
    .inputan {
        width: 95%;
    }
    .save-btn {
        background: #ffcccb;
        color: #d63031;
        padding: 12px 18px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
        width: 100%;
    }
    .cancel-btn {
        display: block;
        color: white;
        text-decoration: none;
        margin-top: 10px;
    }
</style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Task</h2>
        <form method="POST">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            <input type="text" name="task_name" value="<?= htmlspecialchars($task['task_name']) ?>" class="inputan" required>
            <select name="priority" style="width: 100%;">
                <option value="Low" <?= $task['priority'] == 'Low' ? 'selected' : '' ?>>Low</option>
                <option value="Medium" <?= $task['priority'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="High" <?= $task['priority'] == 'High' ? 'selected' : '' ?>>High</option>
            </select>
            <input type="date" name="reminder_date" value="<?= $task['reminder_date'] ?>" class="inputan">
            <button type="submit" name="update_task" class="save-btn">Save Changes</button>
            <a href="index.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
