@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <customers-list :paginate="10"></customers-list>

@endsection

@section('scripts')

@endsection