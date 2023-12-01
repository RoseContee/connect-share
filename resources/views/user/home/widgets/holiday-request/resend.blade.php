@extends('user.home.layouts')

@section('title', 'Resend holiday request')

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resend holiday request</h3>
                </div>
                <form action="{{ route('widget.holiday-requests.resend', $request['id']) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <div class="form-control h-auto">{{ $request['title'] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <div class="form-control h-auto">{{ $request['type'] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="period">Period</label>
                            <div class="form-control h-auto">
                                @php
                                    $period = explode(' - ', $request['period']);
                                    $start_date = date('m/d/Y', strtotime($period[0]));
                                    $end_date = date('m/d/Y', strtotime($period[1]));
                                @endphp
                                {{ $start_date.' - '.$end_date }}
                            </div>
                        </div>
                        @php $r = $request['latestReply'] ?? $request @endphp
                        <div class="form-group">
                            <label for="reason">Rejected Reason</label>
                            <div class="form-control h-auto">{!! $r['reason'] ?: '&nbsp;' !!}</div>
                        </div>
                        <div class="form-group">
                            <label for="note">Note <span class="required">*</span></label>
                            <textarea id="note" name="note" rows="5" required
                               class="form-control @error('note') is-invalid @enderror"
                               placeholder="Note...">{{ old('note', $r['note']) }}</textarea>
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
