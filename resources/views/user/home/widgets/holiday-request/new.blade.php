@extends('user.home.layouts')

@section('title', 'New holiday request')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New holiday request</h3>
                </div>
                <form action="{{ route('widget.holiday-requests.new') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title <span class="required">*</span></label>
                            <input type="text" id="title" name="title" required
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Enter Title">
                            @error('title')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Type <span class="required">*</span></label>
                            <select id="type" name="type" required
                                    class="form-control @error('type') is-invalid @enderror">
                                <option value="Paid Vacation" @selected(old('type') == 'Paid Vacation')>
                                    Paid Vacation
                                </option>
                                <option value="Unpaid Leave" @selected(old('type') == 'Unpaid Leave')>
                                    Unpaid Leave
                                </option>
                                <option value="Sick Leave" @selected(old('type') == 'Sick Leave')>
                                    Sick Leave
                                </option>
                                <option value="Other" @selected(old('type') == 'Other')>
                                    Other
                                </option>
                            </select>
                            @error('type')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="period">Period <span class="required">*</span></label>
                            <input type="text" id="period" name="period" autocomplete="off" required
                                   class="form-control @error('period') is-invalid @enderror"
                                   value="{{ old('period') }}"
                                   placeholder="Period">
                            @error('period')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                            @error('start_date')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                            @error('end_date')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea id="note" name="note" rows="5"
                               class="form-control @error('note') is-invalid @enderror"
                               placeholder="Note...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('widget.holiday-requests') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        $(() => {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            $('#period').daterangepicker({
                autoUpdateInput: false,
                minDate: yesterday,
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            }).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endpush
