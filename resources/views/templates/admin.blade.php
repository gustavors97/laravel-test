@extends('templates/site')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}" media="all">
@endsection

@section('content')

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <sidebar current_link="{{ $link }}"></sidebar>

        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <user-dropdown />
                    </ul>
                </div>
            </nav>

            <div class="container-fluid pl-5">
                <h1 class="mb-4 item-title">{{ $title ?? 'Admin' }}</h1>

                <div class="row datatable">
                    @yield('admin_content')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection