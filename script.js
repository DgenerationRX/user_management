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
    });
</script>
