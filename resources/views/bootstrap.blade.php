<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>vanillajs-datatable - Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissible fade" id="alert" role="alert"
                        style="display: none;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> <span id="alertMessage">Operation completed successfully!</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Card Header -->
                    <div class="card-header  border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0 text-primary">
                                    <i class="bi bi-people-fill me-2"></i>User Management
                                </h4>
                                <small class="text-muted">Manage your users efficiently</small>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#userModal" onclick="openCreateModal()">
                                    <i class="bi bi-plus-circle me-1"></i>Create User
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="card-body border-bottom">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Filter by Name</label>
                                <input type="text" class="form-control form-control-sm" id="nameFilter"
                                    placeholder="Enter name...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Filter by Email</label>
                                <input type="text" class="form-control form-control-sm" id="emailFilter"
                                    placeholder="Enter email...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Filter by Date</label>
                                <input type="date" class="form-control form-control-sm" id="created_atFilter">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-primary btn-sm me-2" id="applyFilters">
                                    <i class="bi bi-funnel me-1"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilters">
                                    <i class="bi bi-x-circle me-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="datatable" id="datatable">

                        </table>
                    </div>
                </div>
            </div>

            <!-- User Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userModalLabel">Create User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="userForm">
                                <input type="hidden" id="userId" name="id">
                                <div class="mb-3">
                                    <label for="userName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="userName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password"
                                        required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveUser()">Save User</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title text-danger" id="deleteModalLabel">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <div class="mb-3">
                                <i class="bi bi-trash text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="mb-3">Are you sure you want to delete this user?</h6>
                            <p class="text-muted mb-0">
                                User: <strong id="deleteUserName"></strong><br>
                                This action cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                                <i class="bi bi-trash me-1"></i>Delete User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const columns = [{
                            name: 'id',
                            label: 'ID',
                            render: (value, row) => `#${value}`,
                        },
                        {
                            name: 'name',
                            label: 'Name',
                            group: 'personal', // Reference to group key , it should be same as group key
                            // tooltip: "The name of the user",
                            // highlightable: {
                            //     color: 'bg-red-300 text-black',
                            //     tag: 'span'
                            // },
                            // align: 'left',
                            // width: '800px',
                            // class: 'text-right text-green-500 font-bold bg-red-500',
                            visible: true,
                            highlightable: true,
                            render: (value) => `<strong>${value}</strong>`,
                        },
                        {
                            name: 'email',
                            label: 'Email',
                            group: 'personal', // Reference to group key
                        },
                        {
                            name: 'created_at',
                            label: 'Created At',
                            group: 'created_at', // Reference to group key
                            render: (val) => new Date(val).toLocaleDateString()
                        }, {
                            name: 'actions',
                            label: 'Actions',
                            render: (value, row) => {
                                // Create the "Show", "Edit", "Delete" buttons
                                return `<div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="showDetails(${row.id})" title="View Details">
                            <i class="bi bi-eye"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="editUser(${row.id})" title="Edit User">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(${row.id}, '${row.name}')" title="Delete User">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>`;
                            }
                        },
                        // Add more...
                    ];
                    window.table = new DataTable({
                        tableId: 'datatable',
                        url: '/users/datatable',
                        dataSrc: 'users',
                        columns: columns,

                        sortable: true, // instead of enableSort
                        sortableColumns: ['id', 'name'],

                        baseTheme: "bootstrap", // "daisyui", "bootstrap", "tailwind"

                    });

                    // Apply filters
                    document.getElementById("applyFilters").addEventListener("click", () => {
                        const name = document.getElementById("nameFilter").value;
                        const email = document.getElementById("emailFilter").value;
                        const created_at = document.getElementById("created_atFilter").value;
                        // Apply single-value filters
                        table.setFilter("name", name, true);
                        table.setFilter("email", email, true);
                        table.setFilter("created_at", created_at, true);

                        // Fetch filtered data from the server
                        table.fetchData();
                    });

                    // Clear filters
                    document.getElementById("clearFilters").addEventListener("click", () => {
                        document.getElementById("nameFilter").value = "";
                        document.getElementById("emailFilter").value = "";
                        document.getElementById("created_atFilter").value = "";

                        // Clear all filters
                        table.clearFilters();
                        table.fetchData();
                    });


                });

                function showDetails(id) {
                    // Implement the logic for showing details of the record
                    console.log(`Show details for record with ID: ${id}`);
                    // You can open a modal or redirect to a detailed page
                }

                function openCreateModal() {
                    document.getElementById('userModalLabel').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Create User';
                    document.getElementById('userForm').reset();
                    document.getElementById('userId').value = '';
                    document.getElementById('userPassword').required = true;

                    // Hide alert
                    hideAlert();
                }

                function editUser(id) {
                    // Fetch user data and populate the modal
                    fetch(`/users/${id}`)
                        .then(response => response.json())
                        .then(user => {
                            document.getElementById('userModalLabel').innerHTML =
                                '<i class="bi bi-pencil-square me-2"></i>Edit User';
                            document.getElementById('userId').value = user.id;
                            document.getElementById('userName').value = user.name;
                            document.getElementById('userEmail').value = user.email;
                            document.getElementById('userPassword').value = '';
                            document.getElementById('userPassword').required = false;

                            // Hide alert
                            hideAlert();

                            // Show the modal
                            const modal = new bootstrap.Modal(document.getElementById('userModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching user:', error);
                            showAlert('Error fetching user data', 'danger');
                        });
                }

                function saveUser() {
                    const form = document.getElementById('userForm');
                    const formData = new FormData(form);
                    const userId = document.getElementById('userId').value;

                    const url = userId ? `/users/${userId}` : '/users';
                    const method = userId ? 'PUT' : 'POST';

                    // Convert FormData to JSON
                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });

                    // Remove empty password for updates
                    if (userId && !data.password) {
                        delete data.password;
                    }

                    fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
                                modal.hide();

                                // Show success alert
                                showAlert(result.message || 'User saved successfully!', 'success');

                                // Refresh table
                                const table = window.table;
                                table.fetchData();

                            } else {
                                showAlert(result.message || 'Error saving user', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving user:', error);
                            showAlert('Error saving user', 'danger');
                        });
                }

                // Delete confirmation functions
                let userToDelete = null;

                function confirmDelete(id, userName) {
                    userToDelete = id;
                    document.getElementById('deleteUserName').textContent = userName;

                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    modal.show();
                }

                // Set up delete confirmation button
                document.addEventListener('DOMContentLoaded', () => {
                    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
                        if (userToDelete) {
                            deleteUser(userToDelete);
                        }
                    });
                });

                function deleteUser(id) {
                    fetch(`/users/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                        })
                        .then(response => response.json())
                        .then(result => {
                            // Close delete modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                            modal.hide();

                            if (result.success) {
                                showAlert(result.message || 'User deleted successfully!', 'success');

                                // Refresh table
                                const table = window.table;
                                table.fetchData();
                            } else {
                                showAlert(result.message || 'Error deleting user', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting user:', error);
                            showAlert('Error deleting user', 'danger');
                        });
                }

                // Alert helper functions
                function showAlert(message, type = 'success') {
                    const alert = document.getElementById('alert');
                    const alertMessage = document.getElementById('alertMessage');

                    alertMessage.textContent = message;
                    alert.className = `alert alert-${type} alert-dismissible fade show`;
                    alert.style.display = 'block';

                    // Auto hide after 5 seconds
                    setTimeout(() => {
                        hideAlert();
                    }, 5000);
                }

                function hideAlert() {
                    const alert = document.getElementById('alert');
                    alert.style.display = 'none';
                }
            </script>



</body>

</html>
