<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $kelas = $_POST['kelas'];
        $nilai = $_POST['nilai'];
        add_user($nim, $name, $kelas, $nilai);
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $kelas = $_POST['kelas'];
        $nilai = $_POST['nilai'];
        update_user($id, $nim, $name, $kelas, $nilai);
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        delete_user($id);
    }
}

$users = get_users();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management 2024</title>
    <style>
        body {
            background-image: url('wave.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-attachment: fixed;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #35424a;
            color: #ffffff;
            padding-top: 1px;
            padding-bottom: 10px;
            min-height: 50px;
            border-bottom: #e8491d 3px solid;
            margin-bottom: 0;
            margin-top: 0;
        }
        header h1 {
            color: #FFF8DC;
            text-align: center;
            text-decoration-line: underline;
            margin-top: 1;
            margin-bottom: 0;
        }
        .main h1 {
            text-align: center;
            padding: 20px 0;
        }
        form {
            background: #ffffff;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #dddddd;
        }
        .form-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .form-group label {
            flex: 1;
            margin-right: 10px;
            text-align: left;
            width: 30%;
        }
        .form-group input[type="text"],
        .form-group input[type="number"] {
            flex: 2;
            padding: 5px;
        }
        .form-group select {
            flex: 2;
            padding: 5px;
            appearance: none;
            background-color: white;
            border-radius: 3px;
            font-size: 16px;
        }
        .form-group select:focus {
            outline: none;
            border-color: #000000;
            box-shadow: 0 0 1px rgba(0, 123, 255, 0.5);
        }
        form button {
            width: 100%;
            padding: 10px;
            background-color: #35424a;
            color: #ffffff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #e8491d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        table tr:nth-child(even) {
            background-color: white;
        }
        table th:nth-child(3),
        table td:nth-child(3) {
            width: 20%;
        }
        table th:nth-child(5),
        table td:nth-child(5),
        table th:nth-child(6),
        table td:nth-child(6) {
            text-align: center;
            width: 12%;
        }
        table th:nth-child(1),
        table td:nth-child(1) {
            text-align: center;
            width: 5%;
        }
        table th:nth-child(2),
        table td:nth-child(2) {
            width: 15%;
        }
        table th:nth-child(4),
        table td:nth-child(4) {
            text-align: center;
            width: 12%;
        }
        table th:nth-child(7),
        table td:nth-child(7) {
            text-align: center;
            width: 13%;
        }
        table tr:hover {
            background-color: #ddd;
        }
        .action-buttons {
            display: table-cell;
            padding: 5px 10px;
        }
        .action-buttons button {
            padding: 10px;
            background-color: #35424a;
            color: #ffffff;
            border: 6px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
            margin-top: 0px;
            transition: background-color 0.3s ease;
        }
        .action-buttons button:hover {
            background-color: #ff0000;
        }
        .action-buttons form {
            display: inline-block;
            margin: 0;
        }
        .delete-button {
            padding: 10px;
            background-color: #ffa500;
            color: #ffa500;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
            margin-top: 0px;
            transition: background-color 0.3s ease;
        }
        .delete-form {
            margin: 0;
            padding: 0;
        }
        .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 1;
        }
        .update-form {
            display: none;
            background: #ffffff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            z-index: 2;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }
        .form-group {
            width: 100%;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .update-form label[for="update-kelas"] {
            text-align: right;
            width: 30%;
            margin-right: 13px;
            margin-bottom: 10px;
        }
        .update-form input[type="text"],
        .update-form input[type="number"],
        .update-form select {
            flex: 2;
            padding: 5px;
            font-size: 17px;
        }
        .update-form select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 1px rgba(0, 123, 255, 0.5);
        }
        .delete-all-button {
            position: absolute;
            top: 1px;
            right: 200px;
            padding: 10px 20px;
            background-color: #cc0000;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 16px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }
        .delete-all-button:hover {
            background-color: #cc0000;
        }
        .delete-confirmation {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
        }
        .confirmation-box {
            text-align: center;
        }
        .confirmation-box p {
            margin-bottom: 20px;
        }
        .confirmation-box button {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #e8491d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .confirmation-box button:hover {
            background-color: #ff6347;
        }
        #view-users-button {
            padding: 15px 8px;
            background-color: #35424a;
            color: #ffffff;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        #view-users-button:hover {
            background-color: #e8491d;
        }
        #search-input {
            max-width: 150px;
            width: 100%;
            height: 22px;
            margin-bottom: 4px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .back-button {
            position: absolute;
            padding: 10px 20px;
            display: inline-block;
            background-color: #088567;
            color: #ffffff;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0d573e;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(248, 249, 250, 0.); 
            color: #333; 
            text-align: center;
            font-size: 12px; 
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
        <a href="home.php" class="back-button">Home</a>
            <h1>Student Management 2024</h1>
            <button id="delete-all-button" class="delete-all-button">Delete All Users</button>
            <img src="dot.gif" alt="Animated GIF" style="position: absolute; top: -3px; right: 50px; width: 70px; transform: scaleX(1.1);">
            <img src="grey.gif" alt="Animated GIF" style="position: absolute; top: -10px; left: 50px; width: 85px; transform: scaleX(1.3);">
        </div>
    </header>
    <div class="container main">
        <h2>Add User Form</h2>
        <form id="add-user-form" method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="nim">Student ID Number :</label>
                <input type="number" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="name">Full Name :</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
    <label for="kelas">Class :</label>
    <select id="kelas" name="kelas" required>
    <option value="" disabled selected>(Select Class)</option>
        <option value="Computer Systems A">Computer Systems A</option>
        <option value="Computer Systems B">Computer Systems B</option>
        <option value="Computer System C">Computer Systems C</option>
        <option value="Information Systems A">Information Systems A</option>
        <option value="Information Systems B">Information Systems B</option>
        <option value="Information Systems C">Information Systems C</option>
    </select>
</div>

            <div class="form-group">
                <label for="nilai">Score :</label>
                <input type="number" id="nilai" name="nilai" min="0" max="100" required>
            </div>
            <button type="submit">Add User</button>
        </form>

        <h2>All Users Data</h2>
        <button id="view-users-button">View All Users</button>
        
        <div id="users-table" style="display: none;">
        <input type="text" id="search-input" placeholder="Search...">

            <table>
                <tr>
                    <th>No.</th>
                    <th>Student ID Number</th>
                    <th>Full Name</th>
                    <th>Class</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= isset($user['id']) ? $user['id'] : '' ?></td>
                        <td><?= isset($user['nim']) ? $user['nim'] : '' ?></td>
                        <td><?= isset($user['name']) ? $user['name'] : '' ?></td>
                        <td><?= isset($user['kelas']) ? $user['kelas'] : '' ?></td>
                        <td><?= isset($user['nilai']) ? $user['nilai'] : '' ?></td>
                        <td><?= isset($user['grade']) ? $user['grade'] : '' ?></td>
                        <td class="action-buttons">
                            <button class="show-update-form action-button" 
                                    data-id="<?= isset($user['id']) ? $user['id'] : '' ?>"
                                    data-nim="<?= isset($user['nim']) ? $user['nim'] : '' ?>"
                                    data-name="<?= isset($user['name']) ? $user['name'] : '' ?>"
                                    data-kelas="<?= isset($user['kelas']) ? $user['kelas'] : '' ?>"
                                    data-nilai="<?= isset($user['nilai']) ? $user['nilai'] : '' ?>"
                                    >Update</button>
                            <form class="delete-form" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= isset($user['id']) ? $user['id'] : '' ?>">
                                <button type="button" class="delete-button delete-button" 
                                     data-id="<?= isset($user['id']) ? $user['id'] : '' ?>" 
                                     data-name="<?= isset($user['name']) ? $user['name'] : '' ?>"
                                     >Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="delete-confirmation" class="delete-confirmation">
    <div class="confirmation-box">
        <p>Are you sure you want to delete?</p>
        <button id="confirm-delete">Yes</button>
        <button id="cancel-delete">Cancel</button>
    </div>
</div>

        <div class="update-form-container">
            <form class="update-form" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="update-id">
                <div class="form-group">
                    <label for="update-nim">ID:</label>
                    <input type="number" id="update-nim" name="nim" required>
                </div>
                <div class="form-group">
                    <label for="update-name">Name:</label>
                    <input type="text" id="update-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="update-kelas">Class:</label>
<div class="form-group">
    <select id="update-kelas" name="kelas" required>
    <option value="" disabled selected>(Select Class)</option>
        <option value="Computer Systems A">Computer Systems A</option>
        <option value="Computer Systems B">Computer Systems B</option>
        <option value="Computer Systems C">Computer Systems C</option>
        <option value="Information Systems A">Information Systems A</option>
        <option value="Information Systems B">Information Systems B</option>
        <option value="Information Systems C">Information Systems C</option>
    </select>
</div>
                </div>
                <div class="form-group">
                    <label for="update-nilai">Score:</label>
                    <input type="number" id="update-nilai" name="nilai" min="0" max="100" required>
                </div>
                <button type="submit" class="update-button">Submit</button>
                <button type="button" class="cancel-update">Cancel</button>
            </form>
        </div>
    </div>
    <div id="delete-all-confirmation" class="delete-confirmation">
    <div class="confirmation-box">
        <p>Are you sure you want to delete All Users?</p>
        <button id="confirm-delete-all">Yes</button>
        <button id="cancel-delete-all">Cancel</button>
    </div>
</div>
<footer style="text-align: center; background: #35424a; color: #ffffff; padding: 10px;">
    Copyright &copy; 2024 Jason Louis Antolin. All Rights Reserved.
</footer>

    <script>
        function deleteAllUsers() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_all_users.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload();
                    }
                };
                xhr.send();
            }
        document.addEventListener('DOMContentLoaded', (event) => {
});    
document.addEventListener('DOMContentLoaded', (event) => {
    const searchInput = document.getElementById('search-input');
    
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#users-table table tr');
        
        rows.forEach((row, index) => {
            if (index === 0) {
                row.style.display = '';
                return;
            }
            
            const columns = row.querySelectorAll('td');
            let found = false;
            
            columns.forEach(column => {
                const text = column.textContent.toLowerCase();
                if (text.includes(filter)) {
                    found = true;
                }
            });
            
            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
            const updateButtons = document.querySelectorAll('.show-update-form');

            updateButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const updateForm = document.querySelector('.update-form');
                    const blurBackground = document.createElement('div');
                    blurBackground.classList.add('blur-background');
                    document.body.appendChild(blurBackground);

                    const userId = this.getAttribute('data-id');
                    const userNim = this.getAttribute('data-nim');
                    const userName = this.getAttribute('data-name');
                    const userKelas = this.getAttribute('data-kelas');
                    const userNilai = this.getAttribute('data-nilai');

                    document.getElementById('update-id').value = userId;
                    document.getElementById('update-nim').value = userNim;
                    document.getElementById('update-name').value = userName;
                    document.getElementById('update-kelas').value = userKelas;
                    document.getElementById('update-nilai').value = userNilai;

                    updateForm.style.display = 'block';
                });
            });

            document.querySelector('.cancel-update').addEventListener('click', function(e) {
                e.preventDefault();
                const updateForm = document.querySelector('.update-form');
                const blurBackground = document.querySelector('.blur-background');
                document.body.removeChild(blurBackground);
                updateForm.style.display = 'none';
            });

            const viewUsersButton = document.getElementById('view-users-button');
            const usersTable = document.getElementById('users-table');

            if (localStorage.getItem('usersTableVisible') === 'true') {
                usersTable.style.display = 'block';
                viewUsersButton.textContent = 'Hide Users';
            }

            viewUsersButton.addEventListener('click', function() {
                if (usersTable.style.display === 'none') {
                    usersTable.style.display = 'block';
                    viewUsersButton.textContent = 'Hide Users';
                    localStorage.setItem('usersTableVisible', 'true');
                } else {
                    usersTable.style.display = 'none';
                    viewUsersButton.textContent = 'View All Users';
                    localStorage.setItem('usersTableVisible', 'false');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    const deleteButtons = document.querySelectorAll('.delete-button');
    const deleteConfirmation = document.getElementById('delete-confirmation');
    const confirmDeleteButton = document.getElementById('confirm-delete');
    let formToDelete = null;

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const confirmation = confirm("Are you sure you want to delete?");
            if (!confirmation) {
                event.preventDefault();
            }
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            const message = `Are you sure you want to delete user ${userName}?`;

            deleteConfirmation.querySelector('p').textContent = message;
            formToDelete = this.closest('form');
            showDeleteConfirmation();
        });
    });

    confirmDeleteButton.addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
            formToDelete = null;
        }
        hideDeleteConfirmation();
    });

    document.getElementById('cancel-delete').addEventListener('click', function() {
        hideDeleteConfirmation();
        formToDelete = null;
    });

    // Event listener for deleting all users
    document.getElementById('delete-all-button').addEventListener('click', function() {
        showDeleteAllConfirmation();
        showBlurBackground();
    });

    document.getElementById('cancel-delete-all').addEventListener('click', function() {
        hideDeleteAllConfirmation();
        hideBlurBackground();
    });

    document.getElementById('confirm-delete-all').addEventListener('click', function() {
        deleteAllUsers();
        hideBlurBackground();
    });

    function showDeleteConfirmation() {
        const deleteConfirmation = document.getElementById('delete-confirmation');
        deleteConfirmation.style.display = 'block';
    }

    function hideDeleteConfirmation() {
        const deleteConfirmation = document.getElementById('delete-confirmation');
        deleteConfirmation.style.display = 'none';
    }

    function showDeleteAllConfirmation() {
        const deleteAllConfirmation = document.getElementById('delete-all-confirmation');
        deleteAllConfirmation.style.display = 'block';
    }

    function hideDeleteAllConfirmation() {
        const deleteAllConfirmation = document.getElementById('delete-all-confirmation');
        deleteAllConfirmation.style.display = 'none';
    }

    function showBlurBackground() {
        const blurBackground = document.createElement('div');
        blurBackground.classList.add('blur-background');
        document.body.appendChild(blurBackground);
    }

    function hideBlurBackground() {
        const blurBackground = document.querySelector('.blur-background');
        if (blurBackground) {
            document.body.removeChild(blurBackground);
        }
    }

    function deleteAllUsers() {
        // Function implementation for deleting all users goes here
    }

    function showDeleteConfirmation() {
        deleteConfirmation.style.display = 'block';
        showBlurBackground();
    }

    function hideDeleteConfirmation() {
        deleteConfirmation.style.display = 'none';
        hideBlurBackground();
    }

    function showBlurBackground() {
        const blurBackground = document.createElement('div');
        blurBackground.classList.add('blur-background');
        document.body.appendChild(blurBackground);
    }

    function hideBlurBackground() {
        const blurBackground = document.querySelector('.blur-background');
        if (blurBackground) {
            document.body.removeChild(blurBackground);
        }
    }
});
    </script>
</body>
</html>