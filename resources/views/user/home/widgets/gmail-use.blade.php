@extends('user.home.layouts')

@php
$user = request()->user();
@endphp

@section('title', 'Gmail Use')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('home-content')

    @include('partials.full-loading')

    <form action="{{ route('widget.gmail-use.update-ou') }}" method="POST"
          onsubmit="$('#ou-modal').modal('hide'); showFullLoading()">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h3 class="card-title">Gmail Use</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" id="open-ou-modal-button" style="display: none;"
                                class="btn btn-primary mt-2 mt-sm-0"
                                data-toggle="modal" data-target="#ou-modal">
                            Change Organisation Unit
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="members" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 10px;"></th>
                        <th style="width: 20px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organisational Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($members as $index => $member)
                        <tr>
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="member-{{ $index }}" name="members[]"
                                           value="{{ $member['primaryEmail'] }}">
                                    <label for="member-{{ $index }}"></label>
                                </div>
                            </td>
                            <td class="text-center">{{ ++$index }}</td>
                            <td>{{ $member['name']['fullName'] }}</td>
                            <td>{{ $member['primaryEmail'] }}</td>
                            <td>{{ $orgunits[$member['orgUnitPath']] ?? '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organisational Unit</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- OU Modal -->
        <div id="ou-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Organisational Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to change Organisational Unit of selected members?</p>
                        <div class="form-group">
                            <label for="organisational_unit">Organisational Unit</label>
                            <select id="organisational_unit" name="organisational_unit" class="form-control" required>
                                <option value="">Select Organisational Unit</option>
                                @foreach($orgunits as $path => $orgunit)
                                    <option value="{{ $path }}">{{ $orgunit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        $(() => {
            $('#members').DataTable({
                autoWidth: false,
                responsive: true,
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, 'All']],
                columnDefs: [
                    { targets: [0, 1], searchable: false },
                    { targets: [0], orderable: false },
                ],
                order: [[1, 'asc']],
            });

            $('input[name="members[]"]').on('change', function () {
                if ($('input[name="members[]"]:checked').length) {
                    $('#open-ou-modal-button').show();
                } else {
                    $('#open-ou-modal-button').hide();
                }
            });
        });
    </script>
@endpush
