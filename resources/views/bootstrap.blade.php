<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>vanillajs-datatable - Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    @vite(['resources/js/app.js'])
</head>

<body>
    <h1>Hello, world!</h1>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Users
            </div>
            <div class="card-body">
                <table class="datatable" id="datatable">

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
                        return `<div class="flex gap-4">
                        <button class="btn btn-primary" onclick="showDetails(${row.id})">Show</button>
                        <button class="btn btn-warning" onclick="editRecord(${row.id})">Edit</button></div>
                    `;
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

                baseTheme: "bootstrap", // "daisyui", "bootstrap", "tailwind"

                loading: {
                    show: false,
                    elementId: 'custom-loading-spinner',
                    delay: 1000,
                },

                selection: {
                    enabled: false,
                    mode: "single", // 'single'|'multiple'
                    rowClass: "row-selected",
                    backgroundClass: "bg-blue-100",
                },

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
