@extends('layouts.app')

@section('title', 'View Data')

@push('styles')
    @vite([
        'resources/css/viewData.css'
    ])
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
@endpush

@section('content')
    @include('viewData.content')
@endsection

@push('scripts')
    @vite([
        // 'node_modules/jquery/dist/jquery.min.js', 
        // 'node_modules/datatables.net/js/dataTables.min.js', 
        // 'node_modules/datatables.net-responsive/js/dataTables.responsive.min.js', 
        // 'resources/vendor/datatables/2.2.2/js/dataTables.tailwindcss.js', 
        'resources/js/viewData.js',
        // 'resources/vendor/datatables/2.2.2/js/dataTables.tailwindcss.js'
        ])
    {{-- @vite('node_modules/datatables.net/js/dataTables.min.js') --}}
    {{-- @vite(['resources/vendor/datatables/2.2.2/js/dataTables.tailwindcss.js']) --}}
    {{-- <script src="assets/jquery.min.js"></script> --}}
    {{-- <script src="assets/dataTables.min.js"></script>
    <script src="https://preline.co/assets/libs/preline/preline.js"></script> --}}
    {{-- <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/datatables.net/js/dataTables.min.js"></script> --}}
    {{-- @vite(['resources/js/viewData.js']) --}}
@endpush
