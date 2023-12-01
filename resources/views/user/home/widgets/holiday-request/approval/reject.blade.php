@extends('user.home.layouts')

@section('title', 'Reject holiday request')

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reject holiday request</h3>
                </div>
                <form action="{{ route('widget.holiday-approvals.reject', $request['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user">User</label>
                            <div class="form-control h-auto">
                                <a href="mailto:{{ $request['user']['email'] }}">
                                    {{ $request['user']['given_name'].' '.$request['user']['family_name'] }}
                                </a>
                            </div>
                        </div>
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
                            <label for="note">Note</label>
                            <div class="form-control h-auto">{!! $r['note'] ?: '&nbsp;' !!}</div>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason <span class="required">*</span></label>
                            <textarea id="reason" name="reason" rows="5" required
                               class="form-control @error('reason') is-invalid @enderror"
                               placeholder="Reason...">{{ old('reason', $r['reason']) }}</textarea>
                            @error('reason')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('widget.holiday-approvals') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
