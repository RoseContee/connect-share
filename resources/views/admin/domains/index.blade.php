@extends('admin.layouts')

@php
$title = $type.' Domains';
$request_page = $type == 'Request';
@endphp

@section('title', $title)

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('after-styles')
    <style>
        .table tbody td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Domains</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                @include('partials.messages')

                <div class="card">
                    @if ($type == 'Allowed')
                        <div class="card-header">
                            <a href="{{ route('admin.domains.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> New Domain
                            </a>
                        </div>
                    @endif
                    <div class="card-body">
                        <table id="domains" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width: 20px;">No</th>
                                <th>Domain</th>
                                @if (!$request_page)
                                    <th style="width: 40px;">Users</th>
                                    <th style="width: 150px;">Banner</th>
                                    <th>Widgets</th>
                                    <th style="width: 60px;">Status</th>
                                @endif
                                <th>Requested</th>
                                <th style="width: 26px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($domains as $index => $domain)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $domain['domain'] }}</td>
                                    @if (!$request_page)
                                        <td>
                                            @if (count($domain['users']))
                                                {{ count($domain['users']) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$domain['hide_banner'])
                                                <img src="{{ getBannerImage($domain['banner_image'], $setting['banner_image'] ?? '') }}"
                                                     alt="Banner Image" style="width: 150px; height: 50px;" />
                                            @endif
                                        </td>
                                        <td>
                                            @php $domain_widgets = explode(',', $domain['widgets']); @endphp
                                            @foreach ($domain_widgets as $w)
                                                @continue(!($widget = ($widgets[$w] ?? '')))
                                                <div class="btn btn-sm btn-default">{{ $widget }}</div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($type == 'Installed')
                                                @if ($domain['status'] == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Blocked</span>
                                                @endif
                                            @elseif (in_array($type, ['Allowed', 'Blocked']))
                                                @if ($domain['installed'])
                                                    <span class="badge badge-success">Installed</span>
                                                @else
                                                    <span class="badge badge-warning">Not Installed</span>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        @if ($domain['requested_email'])
                                            <a href="mailto:{{ $domain['requested_email'] }}">
                                                {{ $domain['requested_email'] }}
                                            </a>
                                        @else
                                            By Admin
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.domains.edit', $domain['id']) }}"
                                           class="btn btn-primary btn-sm px-1 py-0">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Domain</th>
                                @if (!$request_page)
                                    <th>Users</th>
                                    <th>Banner</th>
                                    <th>Widgets</th>
                                    <th>Status</th>
                                @endif
                                <th>Requested</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        $(() => {
            $('#domains').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    {
                        targets: [0, @if (!$request_page)3, 7 @else 2 @endif],
                        searchable: false
                    },
                    {
                        targets: [@if (!$request_page) 3, 7 @else 2 @endif],
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endpush
