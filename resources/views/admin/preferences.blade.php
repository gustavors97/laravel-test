@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <h1 class="d-flex justify-content-center">{{ $title ?? 'Admin' }}</h1>

@endsection

@section('scripts')

@endsection