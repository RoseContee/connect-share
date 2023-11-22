@extends('user.home.layouts')

@php
$user = request()->user();
@endphp

@section('title', 'Holiday Approval')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('home-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Holiday Approval</h3>
        </div>
        <div class="card-body">
            <table id="approvals" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th style="width: 20px;">No</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Period</th>
                    <th>Note</th>
                    <th style="width: 52px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($requests as $index => $request)
                    @php $r = $request['latestReply'] ?? $request; @endphp
                    @continue($r['status'] != 'pending')
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>
                            @if ($request['user'])
                                <a href="mailto:{{ $request['user']['email'] }}">
                                    {{ $request['user']['given_name'].' '.$request['user']['family_name'] }}
                                </a>
                            @endif
                        </td>
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
                            <button class="btn btn-success btn-sm px-1 py-0"
                                    onclick="acceptRequest({{ $request['id'] }})" title="Accept">
                                <i class="fa fa-check"></i>
                            </button>
                            <a href="{{ route('widget.holiday-reject', $request['id']) }}"
                               class="btn btn-danger btn-sm px-1 py-0" title="Reject">
                                <i class="fa fa-ban"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Period</th>
                    <th>Note</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Accept Modal -->
    <div id="accept-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('widget.holiday-accept') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="request" name="request">
                    <div class="modal-header">
                        <h4 class="modal-title">Accept Request</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>You will approve this request.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve</button>
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
        const acceptModal = $('#accept-modal');

        $(() => {
            $('#approvals').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    { targets: [0, 5], searchable: false },
                    { targets: [5], orderable: false },
                ]
            });

            acceptModal.on('hidden.bs.modal', () => {
                acceptModal.find('#request').val('');
            });
        });

        const acceptRequest = id => {
            acceptModal.find('#request').val(id);
            acceptModal.modal('show');
        }
    </script>
@endpush
