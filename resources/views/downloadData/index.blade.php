@extends('layouts.app')

@section('title', 'View Data')

@push('styles')
    @vite(['resources/css/downloadData.css'])
@endpush

@section('content')
    @include('downloadData.content')
@endsection

@push('scripts')
    @vite(['resources/js/downloadData.js'])
@endpush
