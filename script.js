function addTask() {
    let taskInput = document.getElementById("input-box").value;
    let priority = document.getElementById("priority").value;
    let reminderDate = document.getElementById("reminder-date").value;

    if (taskInput === "") {
        alert("Tolong isi tugas!");
        return;
    }

    let taskContainer = document.createElement("li");
    taskContainer.classList.add("task-item", priority.toLowerCase());

    taskContainer.innerHTML = `
        <span class="task-title"><b>${taskInput} - ${priority}</b></span><br>
        <span class="reminder">Reminder: ${reminderDate}</span><br>
        <ul class="subtask-list"></ul>
        <div class="task-buttons">
            <button class="edit-btn">Edit</button>
            <button class="delete-btn" onclick="deleteTask(this)">Delete</button>
            <button class="add-subtask-btn" onclick="addSubtask(this)">Add Subtask</button>
        </div>
    `;

    let editBtn = taskContainer.querySelector(".edit-btn");
    editBtn.addEventListener("click", function() {
        editTask(this);
    });

    document.getElementById("list-container").appendChild(taskContainer);
    document.getElementById("input-box").value = "";
}

function editTask(button) {
    let taskContainer = button.closest(".task-item");
    let taskTitle = taskContainer.querySelector(".task-title");
    let reminder = taskContainer.querySelector(".reminder");

    if (!taskTitle || !reminder) {
        alert("Error: Elemen tugas tidak ditemukan!");
        return;
    }

    let oldTaskText = taskTitle.innerText.split(" - ")[0];
    let oldPriority = taskTitle.innerText.split(" - ")[1];
    let oldReminder = reminder.innerText.replace("Reminder: ", "");

    let newTaskText = prompt("Edit tugas:", oldTaskText);
    let newPriority = prompt("Edit prioritas (High, Medium, Low):", oldPriority);
    let newReminder = prompt("Edit reminder:", oldReminder);

    if (newTaskText && newPriority && newReminder) {
        taskTitle.innerHTML = `<b>${newTaskText} - ${newPriority}</b>`;
        reminder.innerText = `Reminder: ${newReminder}`;

        taskContainer.classList.remove(oldPriority.toLowerCase());
        taskContainer.classList.add(newPriority.toLowerCase());
    }
}

function deleteTask(button) {
    button.closest(".task-item").remove();
}

