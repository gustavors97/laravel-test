@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <numbers-list :paginate="10" />

@endsection

@section('scripts')

@endsection