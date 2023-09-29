@extends('admin.layouts')

@section('title', 'Shortcuts')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Shortcuts</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shortcuts</li>
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
                    <div class="card-header">
                        <a href="{{ route('admin.shortcuts.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> New Shortcut
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="shortcuts" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width: 20px;">No</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th style="width: 52px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($shortcuts as $index => $shortcut)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>
                                        <a href="{{ $shortcut['link'] }}" target="_blank">
                                            <img src="{{ asset($shortcut['icon']) }}" alt="{{ $shortcut['title'] }}"
                                                 class="icon-32 mr-2">
                                            {{ $shortcut['title'] }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($shortcut['active'])
                                            <span class="badge badge-success">Enabled</span>
                                        @else
                                            <span class="badge badge-danger">Disabled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.shortcuts.edit', $shortcut['id']) }}"
                                           class="btn btn-primary btn-sm px-1 py-0">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm px-1 py-0"
                                                onclick="deleteShortcut({{ $shortcut['id'] }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Status</th>
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

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Shortcut</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this shortcut?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        const deleteModal = $('#delete-modal');

        $(() => {
            $('#shortcuts').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    { targets: [0, 3], searchable: false },
                    { targets: [3], orderable: false },
                ]
            });

            deleteModal.on('hidden.bs.modal', function() {
                deleteModal.attr('action', '');
            });
        });

        function deleteShortcut(id) {
            deleteModal.modal('show').find('form').attr('action', '{{ route('admin.shortcuts.index') }}/' + id);
        }
    </script>
@endpush
