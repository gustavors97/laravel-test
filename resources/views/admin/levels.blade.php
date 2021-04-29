@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <levels-list :paginate="10" />

@endsection

@section('scripts')

@endsection