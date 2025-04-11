<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM subtask WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $subtask = $result->fetch_assoc();
    } else {
        echo "Subtask tidak ditemukan.";
        exit();
    }
} else {
    echo "ID subtask tidak diberikan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_status = $_POST['status'];
    
    $updateQuery = "UPDATE subtask SET subtask_name = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $new_title, $new_status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Subtask berhasil diperbarui!'); window.location='index.php?id=$id';</script>";
    } else {
        echo "Gagal memperbarui subtask.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subtask</title>
    <style>
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
        .save-btn:hover {
            background: #ff9999;
        }
        .cancel-btn {
            display: block;
            color: white;
            text-decoration: none;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Subtask</h2>
        <form method="POST">
            <label for="title">Subtask:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($subtask['subtask_name']); ?>" required>

            <label for="status">Status:</label>
            <select name="status">
                <option value="pending" <?= $subtask['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?= $subtask['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
            </select>

            <button type="submit" class="save-btn">Save Changes</button>
            <a href="index.php" class="cancel-btn">Batal</a>
        </form>
    </div>
</body>
</html>