<!-- DataTables CSS -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css"> -->

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Users DataTable</h2>
        <table id="userTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- Bootstrap JS -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '<?php echo base_url() . "index.php/program_bintang/program_bintang/test_datatable" ?>', // This is the PHP file that fetches data from the database
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "created_at"
                    },
                ],
                "responsive": true,
            });
        });
    </script>
</body>

</html>