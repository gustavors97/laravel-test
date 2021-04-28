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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('img/admin.svg') }}" class="rounded-circle shadow" width="50" height="50">
                            </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/logout">Sign out</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid pl-5">
                <h1 class="mb-4 item-title">{{ $title ?? 'Admin' }}</h1>

                <div class="row datatable">
                    <div class="col-12">
                        <button class="btn btn-add-table d-flex align-items-center ml-auto py-3 px-4 mr-3" data-toggle="modal" data-target="#newCustomerModal">
                            <i class="gg-math-plus mr-3"></i>
                            Add {{ $title ?? '' }}
                        </button>
                    </div>

                    @yield('admin_content')
                </div>

                <!-- Modal -->
                <div class="modal fade" id="newCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modal title</h5>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection