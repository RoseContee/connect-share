@php
$user = request()->user();
$total_usage = $user['drive_usage'] + $user['gmail_usage'] + $user['photos_usage'];
@endphp

<div class="storage-usage-container">
    <p class="mb-1 d-none d-sm-block">
        Storage space usage for <b>{{ $user['given_name'].' '.$user['family_name'] }}</b>
    </p>
    <div class="usage-info">
        <div class="d-flex align-items-center pr-2 pr-sm-0">
            <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="">
        </div>
        <div>
            <p class="mb-1">Total used</p>
            <h3 id="total-usage" class="mb-0">{{ byte_formate($total_usage) }}</h3>
        </div>
        <div class="d-none d-sm-block">
            <div class="h-100 border-top border-left"></div>
        </div>
        <div class="d-none d-sm-block">
            <img src="{{ asset('assets/img/icons/google-drive.png') }}" alt="">
            <p class="small mb-0">Drive</p>
            <h5 id="drive-usage" class="mb-0">{{ byte_formate($user['drive_usage']) }}</h5>
        </div>
        <div class="d-none d-sm-block">
            <img src="{{ asset('assets/img/icons/gmail.png') }}" alt="">
            <p class="small mb-0">Gmail</p>
            <h5 id="gmail-usage" class="mb-0">{{ byte_formate($user['gmail_usage']) }}</h5>
        </div>
        <div class="d-none d-sm-block">
            <img src="{{ asset('assets/img/icons/photos.png') }}" alt="">
            <p class="small mb-0">Photos</p>
            <h5 id="photos-usage" class="mb-0">{{ byte_formate($user['photos_usage']) }}</h5>
        </div>
        <div class="d-none d-sm-block blank-space"></div>
    </div>
</div>

@push ('after-scripts')
    <script>
        $.ajax({
            method: 'GET',
            url: '{{ route('storage-usage') }}',
            success(data) {
                $('#total-usage').text(data.total_usage);
                $('#drive-usage').text(data.drive_usage);
                $('#gmail-usage').text(data.gmail_usage);
                $('#photos-usage').text(data.photos_usage);
            },
            error() {
            }
        });
    </script>
@endpush
