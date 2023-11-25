@extends('user.home.layouts')

@section('title', 'Connect corporate news account')

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Connect corporate news account</h3>
                </div>
                <div class="card-body">
                    @if (!$corporateNews)
                        <p class="mb-0">
                            Please connect the calendar to show corporate news to all members.
                        </p>
                    @else
                        <p class="mb-0">
                            <b>{{ $corporateNews['email'] }}</b> has been connected.
                        </p>
                    @endif
                </div>
                <div class="card-footer">
                    @if (!$corporateNews)
                        <a href="{{ route('widget.corporate-news.auth.google') }}" class="btn btn-primary">
                            Connect
                        </a>
                    @else
                        <button type="button" class="btn btn-danger"
                                data-toggle="modal" data-target="#delete-modal">
                            Remove
                        </button>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @if ($corporateNews)
        <!-- Delete Modal -->
        <div id="delete-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('widget.corporate-news') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h4 class="modal-title">Remove Account</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to remove the calendar account?</p>
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
