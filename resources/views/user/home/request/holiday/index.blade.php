@extends('user.home.layouts')

@php
$user = auth()->user();
@endphp

@section('title', 'Holiday Requests')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('home-content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-header">
                    <a href="{{ route('new-holiday-request') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Request
                    </a>
                </div>
                <div class="card-body">
                    <table id="requests" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 20px;">No</th>
                            <th>Title</th>
                            <th>Period</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Manager</th>
                            <th style="width: 52px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($requests as $index => $request)
                            @php $r = $request['latestReply'] ?? $request; @endphp
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>
                                    {{ $request['title'] }}
                                    <p class="mb-0">({{ $request['type'] }})</p>
                                </td>
                                <td>
                                    @php $period = explode(' - ', $request['period']); @endphp
                                    {{ date('m/d/Y', strtotime($period[0])) }} - {{ date('m/d/Y', strtotime($period[1])) }}
                                </td>
                                <td>{{ $r['note'] }}</td>
                                <td>
                                    @if ($r['status'] === 'pending')
                                        <span class="badge badge-info">Pending</span>
                                    @elseif ($r['status'] === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                        @if ($r['reason'])
                                            <p class="mb-0">{{ $r['reason'] }}</p>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($request['manager'])
                                        <a href="mailto:{{ $request['manager']['email'] }}">
                                            {{ $request['manager']['given_name'].' '.$request['manager']['family_name'] }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($r['status'] === 'rejected')
                                        <a href="{{ route('resend-holiday-request', $request['id']) }}"
                                           class="btn btn-primary btn-sm px-1 py-0" title="Resend">
                                            <i class="fa fa-reply"></i>
                                        </a>
                                    @endif
                                    <button class="btn btn-danger btn-sm px-1 py-0"
                                            onclick="deleteRequest({{ $request['id'] }})" title="Delete">
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
                            <th>Period</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Manager</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('delete-holiday-request') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="request" name="request">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Request</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this request?</p>
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
    <script>
        const deleteModal = $('#delete-modal');

        $(function () {
            $('#requests').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    { targets: [0, 6], searchable: false },
                    { targets: [6], orderable: false },
                ]
            });

            deleteModal.on('hidden.bs.modal', function() {
                deleteModal.find('#request').val('');
            });
        });

        function deleteRequest(id) {
            deleteModal.modal('show').find('#request').val(id);
        }
    </script>
@endpush
