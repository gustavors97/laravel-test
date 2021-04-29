@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <numbers-preferences-list :paginate="10" />

@endsection

@section('scripts')

@endsection