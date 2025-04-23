@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    @vite(['resources/css/dashboard.css'])
@endpush

@section('content')
    @include('dashboard.content')
@endsection

@push('scripts')
    @vite(['resources/js/dashboard.js'])
@endpush
