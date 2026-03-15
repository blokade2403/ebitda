    <head>
        <meta charset="utf-8" />
        <title>Ebitda - RSUD Cilincing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!--Swiper slider css-->
        <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css"
            href="{{ asset('libraries\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('libraries\assets\pages\data-table\css\buttons.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            .table td,
            .table th {
                vertical-align: middle;
            }

            .table td {
                font-size: 14px;
            }

            .badge {
                font-size: 12px;
                padding: 6px 10px;
            }

            .table-finance thead th {
                position: sticky;
                top: 0;
                background: #198754;
                color: white;
                z-index: 2;
            }

            .table-finance tbody tr:hover {
                background: #f8f9fa;
            }

            .table-finance td {
                font-weight: 500;
            }

            .table-finance tbody tr.table-warning {
                background: #fff3cd;
            }

            .table-finance tbody tr.table-success {
                background: #d1e7dd;
            }
        </style>




    </head>
