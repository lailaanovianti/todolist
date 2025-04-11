<?php
include 'db.php'; 

if (!isset($_GET['task_id'])) {
    die("Task ID tidak ditemukan.");
}
$task_id = $_GET['task_id'];

$query = "SELECT task_name FROM task WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task_title = ($result->num_rows > 0) ? $result->fetch_assoc()['task_name'] : "Task Not Found";

$subtaskQuery = $conn->prepare("SELECT * FROM subtask WHERE task_id = ?");
$subtaskQuery->bind_param("i", $task_id);
$subtaskQuery->execute();
$subtasks = $subtaskQuery->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subtask</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffb6c1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 70px auto;
            background-color: #f8d7da;
            padding: 25px 25px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        input[type="text"] {
            padding: 8px;
            flex: 1;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            padding: 8px 14px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        .subtask-item {
            background-color: #ffc4c4;
            padding: 10px 12px;
            margin-bottom: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .left-side {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .subtask-name {
            font-size: 15px;
            color: #333;
            text-align: left;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-edit {
            background-color: purple;
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 13px;
        }
        .btn-delete {
            background-color: #e74c3c;
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 13px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6a1b9a;
            text-decoration: none;
            font-size: 14px;
        }
        input[type="checkbox"] {
            transform: scale(1.2);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Task: <?php echo htmlspecialchars($task_title); ?></h2>
        <form action="add_subtask.php" method="POST">
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
            <input type="text" name="subtask_title" placeholder="Enter subtask" required>
            <button type="submit">Add</button>
        </form>
        <ul>
            <?php while ($row = $subtasks->fetch_assoc()) { ?>
                <li>
                    <div class="subtask-item">
                        <div class="left-side">
                            <form action="update_status.php" method="POST" id="status-form-<?php echo $row['id']; ?>">
                                <input type="hidden" name="subtask_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="status" value="<?php echo $row['status'] == 1 ? 0 : 1; ?>">
                                <input type="checkbox" onchange="document.getElementById('status-form-<?php echo $row['id']; ?>').submit()" <?php echo $row['status'] == 1 ? 'checked' : ''; ?>>
                            </form>
                            <div class="subtask-name"><?php echo htmlspecialchars($row['subtask_name']); ?></div>
                        </div>
                        <div class="btn-group">
                            <a href="edit_subtask.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_subtask.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus subtask ini?')">Delete</a>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <a class="back-link" href="index.php">← Back</a>
    </div>
</body>
</html>
