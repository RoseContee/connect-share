@push('after-styles')
    <style>
        #alerts.carousel .carousel-indicators {
            margin-bottom: 0;
            bottom: -30px;
        }

        #alerts.carousel .carousel-indicators li {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #007bff;
        }

        @media (min-width: 768px) {
            #alerts.carousel .carousel-inner .carousel-item.active,
            #alerts.carousel .carousel-inner .carousel-item.active + .carousel-item {
                display: block;
            }

            #alerts.carousel .carousel-inner .carousel-item {
                margin-right: 0;
            }
        }
    </style>
@endpush

<div class="alerts-container {{ $class ?? '' }}">
    <h5>Alerts <i class="fa fa-chevron-right"></i></h5>
    <div id="alerts" class="carousel" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($alerts as $index => $alert)
                <li data-target="#alerts" data-slide-to="{{ $index }}" @if (!$index) class="active" @endif></li>
            @endforeach
        </ol>
        <div class="carousel-inner row flex-nowrap">
            @forelse ($alerts as $alert)
                <div class="carousel-item col-md-6 @if ($loop->first) active @endif">
                    <div class="card m-0">
                        <div class="card-body d-flex align-items-center bg-gray-light p-2">
                            <div class="img-rounded bg-primary text-center px-2 py-1 mr-2">
                                <h6 class="text-nowrap m-0">{{ date('j M', strtotime($alert['date'])) }}</h6>
                                <p class="small m-0">{{ date('H:i', strtotime($alert['date'])) }}</p>
                            </div>
                            <p class="text-truncate m-0">{{ $alert['description'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="font-italic py-3">No alerts for company.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
