<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>vanillajs-datatable - Alpine demo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50">
    <div x-data="userTable()" x-init="init()" class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">
                <!-- Success Alert -->
                <div x-show="alert.show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    :class="alert.type === 'success' ? 'bg-green-50 border-l-4 border-green-400' :
                        'bg-red-50 border-l-4 border-red-400'"
                    class="p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg :class="alert.type === 'success' ? 'text-green-400' : 'text-red-400'" class="h-5 w-5"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p :class="alert.type === 'success' ? 'text-green-700' : 'text-red-700'" class="text-sm">
                                <span class="font-medium">Success!</span> <span x-text="alert.message"></span>
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="hideAlert()"
                                    :class="alert.type === 'success' ?
                                        'bg-green-50 text-green-500 hover:bg-green-100 focus:ring-green-600' :
                                        'bg-red-50 text-red-500 hover:bg-red-100 focus:ring-red-600'"
                                    class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Header -->
                <div class="px-6 py-6 border-b border-gray-200 bg-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                User Management
                            </h1>
                            <p class="mt-1 text-sm text-gray-500">Manage your users efficiently</p>
                        </div>
                        <button @click="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create User
                        </button>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Filter by Name</label>
                            <input type="text" x-model="filters.name" placeholder="Enter name..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Filter by Email</label>
                            <input type="text" x-model="filters.email" placeholder="Enter email..."
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Filter by Date</label>
                            <input type="date" x-model="filters.created_at"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="flex items-end space-x-2">
                            <button @click="applyFilters()"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                    </path>
                                </svg>
                                Apply
                            </button>
                            <button @click="clearFilters()"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="p-6">
                    <table id="datatable" class="min-w-full divide-y divide-gray-200">
                        <!-- DataTable content -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div x-show="modals.user" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 x-text="modals.userTitle" class="text-lg font-medium text-gray-900"></h3>
                    <button @click="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form @submit.prevent="saveUser()" class="space-y-4">
                    <input type="hidden" x-model="form.id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" x-model="form.name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" x-model="form.email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" x-model="form.password" :required="!form.id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </form>
                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="closeUserModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button @click="saveUser()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="modals.delete" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Are you sure you want to delete this user?<br>
                    <span class="font-medium text-gray-900" x-text="deleteUser.name"></span><br>
                    This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-3">
                    <button @click="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button @click="confirmDeleteUser()"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userTable() {
            return {
                // State
                table: null,
                filters: {
                    name: '',
                    email: '',
                    created_at: ''
                },
                modals: {
                    user: false,
                    delete: false,
                    userTitle: 'Create User'
                },
                form: {
                    id: '',
                    name: '',
                    email: '',
                    password: ''
                },
                deleteUser: {
                    id: null,
                    name: ''
                },
                alert: {
                    show: false,
                    type: 'success',
                    message: ''
                },

                init() {
                    const columns = [{
                            name: 'id',
                            label: 'ID',
                            render: (value, row) => `#${value}`,
                        },
                        {
                            name: 'name',
                            label: 'Name',
                            group: 'personal',
                            visible: true,
                            highlightable: true,
                            render: (value) => `<strong>${value}</strong>`,
                        },
                        {
                            name: 'email',
                            label: 'Email',
                            group: 'personal',
                        },
                        {
                            name: 'created_at',
                            label: 'Created At',
                            group: 'created_at',
                            render: (val) => new Date(val).toLocaleDateString()
                        },
                        {
                            name: 'actions',
                            label: 'Actions',
                            render: (value, row) => {
                                return `<div class="flex space-x-2">
                                    <button onclick="window.userTableInstance.showDetails(${row.id})" class="inline-flex items-center px-3 py-1 border border-blue-300 shadow-sm text-xs font-medium rounded text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </button>
                                    <button onclick="window.userTableInstance.editUser(${row.id})" class="inline-flex items-center px-3 py-1 border border-yellow-300 shadow-sm text-xs font-medium rounded text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button onclick="window.userTableInstance.confirmDelete(${row.id}, '${row.name}')" class="inline-flex items-center px-3 py-1 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>`;
                            }
                        }
                    ];

                    this.table = new DataTable({
                        tableId: 'datatable',
                        url: '/users/datatable',
                        dataSrc: 'users',
                        columns: columns,
                        sortable: true,
                        sortableColumns: ['id', 'name'],
                        baseTheme: "tailwind",
                    });

                    // Make instance globally available
                    window.userTableInstance = this;
                },

                // Filter methods
                applyFilters() {
                    this.table.setFilter("name", this.filters.name, true);
                    this.table.setFilter("email", this.filters.email, true);
                    this.table.setFilter("created_at", this.filters.created_at, true);
                    this.table.fetchData();
                },

                clearFilters() {
                    this.filters = {
                        name: '',
                        email: '',
                        created_at: ''
                    };
                    this.table.clearFilters();
                    this.table.fetchData();
                },

                // Modal methods
                openCreateModal() {
                    this.modals.userTitle = 'Create User';
                    this.form = {
                        id: '',
                        name: '',
                        email: '',
                        password: ''
                    };
                    this.modals.user = true;
                    this.hideAlert();
                },

                closeUserModal() {
                    this.modals.user = false;
                },

                editUser(id) {
                    fetch(`/users/${id}`)
                        .then(response => response.json())
                        .then(user => {
                            this.modals.userTitle = 'Edit User';
                            this.form = {
                                id: user.id,
                                name: user.name,
                                email: user.email,
                                password: ''
                            };
                            this.modals.user = true;
                            this.hideAlert();
                        })
                        .catch(error => {
                            console.error('Error fetching user:', error);
                            this.showAlert('Error fetching user data', 'danger');
                        });
                },

                saveUser() {
                    const url = this.form.id ? `/users/${this.form.id}` : '/users';
                    const method = this.form.id ? 'PUT' : 'POST';

                    const data = {
                        ...this.form
                    };
                    if (this.form.id && !data.password) {
                        delete data.password;
                    }

                    fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                this.closeUserModal();
                                this.showAlert(result.message || 'User saved successfully!', 'success');
                                this.table.fetchData();
                            } else {
                                this.showAlert(result.message || 'Error saving user', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving user:', error);
                            this.showAlert('Error saving user', 'danger');
                        });
                },

                confirmDelete(id, userName) {
                    this.deleteUser = {
                        id: id,
                        name: userName
                    };
                    this.modals.delete = true;
                },

                closeDeleteModal() {
                    this.modals.delete = false;
                },

                confirmDeleteUser() {
                    fetch(`/users/${this.deleteUser.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                        })
                        .then(response => response.json())
                        .then(result => {
                            this.closeDeleteModal();

                            if (result.success) {
                                this.showAlert(result.message || 'User deleted successfully!', 'success');
                                this.table.fetchData();
                            } else {
                                this.showAlert(result.message || 'Error deleting user', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting user:', error);
                            this.showAlert('Error deleting user', 'danger');
                        });
                },

                showDetails(id) {
                    console.log(`Show details for record with ID: ${id}`);
                },

                // Alert methods
                showAlert(message, type = 'success') {
                    this.alert = {
                        show: true,
                        type: type,
                        message: message
                    };
                    setTimeout(() => {
                        this.hideAlert();
                    }, 5000);
                },

                hideAlert() {
                    this.alert.show = false;
                }
            }
        }
    </script>




</body>

</html>
