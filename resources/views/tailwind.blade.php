<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>vanillajs-datatable - Tailwind demo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-dashed border-gray-300 text-lg font-semibold text-gray-800">
                Users
            </div>
            <div class="p-6 overflow-x-auto">
                <table id="datatable">
                    <!-- DataTable content -->
                </table>
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
                        return `<button class="btn btn-sm btn-primary" onclick="showDetails(${row.id})">Show</button>
                                <button class="btn btn-sm btn-warning" onclick="editRecord(${row.id})">Edit</button>`;
                    }
                },
                // Add more...
            ];
            const table = new DataTable({
                tableId: 'datatable',
                url: '/users/datatable',
                dataSrc: 'users',
                columns: columns,

                // columnFiltering: true,
                // filterableColumns: ['name', 'email'],

                sortable: true,
                sortableColumns: ['id', 'name'],

                baseTheme: "tailwind", // "daisyui", "bootstrap", "tailwind"

            });


        });

        function showDetails(id) {
            // Implement the logic for showing details of the record
            console.log(`Show details for record with ID: ${id}`);
            // You can open a modal or redirect to a detailed page
        }
    </script>



</body>

</html>
