<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>vanillajs-datatable - Alpine demo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body>
    <div x-data="userTable()" x-init="init()" class="max-w-7xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b text-lg font-semibold text-gray-800">
                Users
            </div>
            <div class="p-6 overflow-x-auto">
                <table id="datatable"></table>
            </div>
        </div>
    </div>

    <script>
        function userTable() {
            return {
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
                                return `
                                <button class="btn btn-sm btn-primary" @click="showDetails(${row.id})">Show</button>
                                <button class="btn btn-sm btn-warning" @click="editRecord(${row.id})">Edit</button>
                            `;
                            }
                        }
                    ];

                    new DataTable({
                        tableId: 'datatable',
                        url: '/users/datatable',
                        dataSrc: 'users',
                        columns: columns,
                        sortable: true,
                        sortableColumns: ['id', 'name'],
                        baseTheme: "tailwind",
                    });
                },
                showDetails(id) {
                    console.log(`Show details for record with ID: ${id}`);
                },
                editRecord(id) {
                    console.log(`Edit record with ID: ${id}`);
                }
            }
        }
    </script>




</body>

</html>
