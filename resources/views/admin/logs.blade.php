@extends('templates/admin')

@section('title', $title)

@section('admin_content')

    <div class="table-responsive pt-4 pr-3">
        <table id="table-logs" class="table-sm table-hover table-striped table-bordered w-100">
            <thead>
                <tr>
                    <th scope="col" class="font-weight-bold text-truncate">#</th>
                    <th scope="col" class="font-weight-bold text-truncate">User ID</th>
                    <th scope="col" class="font-weight-bold text-truncate">Event</th>
                    <th scope="col" class="font-weight-bold text-truncate">Auditable type</th>
                    <th scope="col" class="font-weight-bold text-truncate">ID</th>
                    <!-- <th scope="col" class="font-weight-bold text-truncate">Old values</th>
                    <th scope="col" class="font-weight-bold text-truncate">New values</th> -->
                    <th scope="col" class="font-weight-bold text-truncate">URL</th>
                    <th scope="col" class="font-weight-bold text-truncate">IP</th>
                    <th scope="col" class="font-weight-bold text-truncate">User Agent</th>
                    <th scope="col" class="font-weight-bold text-truncate">Tags</th>
                    <th scope="col" class="font-weight-bold text-truncate">Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($audicts as $audict)
                <tr id="{{ $audict['id'] }}">
                    <th scope="row" class="text-truncate">{{ $audict['id'] }}</th>
                    <td class="text-truncate">{{ $audict['user_id'] }}</td>
                    <td class="text-truncate">{{ $audict['event'] }}</td>
                    <td class="text-truncate">{{ $audict['auditable_type'] }}</td>
                    <td class="text-truncate">{{ $audict['auditable_id'] }}</td>
                    <!-- <td class="text-truncate">{{ $audict['old_values'] }}</td>
                    <td class="text-truncate">{{ $audict['new_values'] }}</td> -->
                    <td class="text-truncate">{{ $audict['url'] }}</td>
                    <td class="text-truncate">{{ $audict['ip_address'] }}</td>
                    <td class="text-truncate">{{ $audict['user_agent'] }}</td>
                    <td class="text-truncate">{{ $audict['tags'] }}</td>
                    <td class="text-truncate">{{ $audict['created_at'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')

@endsection