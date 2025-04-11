<?php
session_start();  // Memulai sesi
include 'db.php';  // Menyertakan koneksi database

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Ambil ID pengguna yang sedang login

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {
    $task_name = $_POST["task_name"];
    $priority = $_POST["priority"];
    $reminder_date = $_POST["reminder_date"];

    if (!empty($task_name)) {
        $sql = "INSERT INTO task (task_name, priority, reminder_date, status, user_id) VALUES (?, ?, ?, FALSE, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $task_name, $priority, $reminder_date, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $task_id = $_POST["task_id"];
    $status = $_POST["status"] ? 0 : 1;

    $sql = "UPDATE task SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $task_id);
    $stmt->execute();
    $stmt->close();
}

// Mengambil tugas berdasarkan user_id
$sql = "SELECT * FROM task WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="todo-app">
            <h2>To-Do List</h2>
            <form method="POST">
                <div class="row">
                    <input type="text" name="task_name" placeholder="Add Task" required>
                    <select name="priority">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                    <input type="date" name="reminder_date">
                    <button type="submit" name="add_task">Add</button>
                </div>
            </form>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="task-item <?= strtolower($row['priority']) ?> <?= $row['status'] ? 'completed' : '' ?>">
                        <div class="task-header">
                        <form action="update_status2.php" method="POST" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="status" value="<?= $row['status']; ?>">
                        <input type="checkbox" onchange="this.form.submit()" <?= $row['status'] == 1 ? 'checked' : ''; ?>>
                        <span class="task-title"> <?= htmlspecialchars($row['task_name']) ?> </span>
                        </form>
                        </div>
                        <div class="task-details">
                            <div class="task-priority">Priority: <?= ucfirst($row['priority']) ?></div>
                            <div class="reminder"> <?= $row['reminder_date'] ? '🔔 ' . $row['reminder_date'] : '' ?> </div>
                        </div>
                        <div class="task-actions">
                            <a href="subtask.php?task_id=<?= $row['id'] ?>" class="add-subtask-btn">Subtask</a>
                            <a href="edit_task.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete_task.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <a href="dashboard.php" class="back-link">← Back</a>
        </div>
</body>
</html>
