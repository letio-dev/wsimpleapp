@extends('layouts.auth')

@section('title', 'Login')

@push('styles')
    @vite(['resources/css/auth/login.css'])
@endpush

@section('content')
    @include('auth.login.content')
@endsection

@push('scripts')
    @vite(['resources/js/auth/login.js'])
@endpush
