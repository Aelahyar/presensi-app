<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi-App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset( 'assets/css/app.css' ) }}">

    {{-- DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables/css/buttons.dataTables.min.css') }}">


</head>
<body>

    <div class="main-container">
        {{-- Awal Header --}}
        @yield('header')

        {{-- Content --}}
        @yield('content')
    </div>

        @yield('nav')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Script DataTables --}}
    <!-- jQuery -->
    <!-- DataTables FixedHeader JS -->
    <script src="{{ asset('assets/js/dataTables.fixedHeader.min.js') }}"></script>

    {{--  --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>

    <!-- DataTables Core -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/vfs_fonts.js') }}"></script>

    <script>
        $(document).ready(function () {
            const style = document.createElement('style');
            style.innerHTML = `
                th, td {
                    white-space: nowrap;
                    text-align: center;
                }

                th {
                    background-color: #435ebe;
                    color: white;
                }

                table.dataTable {
                    border-collapse: collapse;
                    border-spacing: 0;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                }`;
            document.head.appendChild(style);

            $('#table1').DataTable({
                dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>tip',
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Salin'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel'
                    },
                    {
                        extend: 'print',
                        text: 'Cetak'
                    }
                ],
                paging: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: '60vh',
                fixedHeader: true,
                columnDefs: [{
                    targets: '_all',
                    className: 'nowrap'
                }]
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
