@extends('user.home.layouts')

@php
$user = auth()->user();
@endphp

@section('title', 'Company Documents')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('home-content')
    <div class="card">
        <div class="card-header">
            @if ($user['is_admin'])
                <a href="{{ route('documents.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Document
                </a>
            @else
                <h3 class="card-title">Company Documents</h3>
            @endif
        </div>
        <div class="card-body">
            <table id="documents" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th style="width: 20px;">No</th>
                    <th>Title</th>
                    <th>Description</th>
                    @if ($user['is_admin'])
                        <th style="width: 52px;"></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($documents as $index => $document)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>
                            <a href="{{ $document['link'] }}" target="_blank">
                                {{ $document['title'] }}
                            </a>
                        </td>
                        <td>{{ $document['description'] }}</td>
                        @if ($user['is_admin'])
                            <td>
                                <a href="{{ route('documents.edit', $document['id']) }}"
                                   class="btn btn-primary btn-sm px-1 py-0">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm px-1 py-0"
                                        onclick="deleteDocument({{ $document['id'] }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    @if ($user['is_admin'])
                        <th></th>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @if ($user['is_admin'])
    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Document</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this document?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        @if ($user['is_admin'])
        const $deleteModal = $('#delete-modal');
        @endif

        $(function () {
            $('#documents').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    { targets: [0 @if ($user['is_admin']), 3 @endif], searchable: false },
                    @if ($user['is_admin'])
                    { targets: [3], orderable: false },
                    @endif
                ]
            });

            @if ($user['is_admin'])
            $deleteModal.on('hidden.bs.modal', function() {
                $deleteModal.attr('action', '');
            });
            @endif
        });

        @if ($user['is_admin'])
        function deleteDocument(id) {
            $deleteModal.modal('show').find('form').attr('action', '{{ route('documents.index') }}/' + id);
        }
        @endif
    </script>
@endpush
