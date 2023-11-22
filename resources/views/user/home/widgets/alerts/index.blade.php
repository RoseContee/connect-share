<div class="alerts-container {{ $class ?? '' }}">
    <h5>Alerts <i class="fa fa-chevron-right"></i></h5>
    <div id="alerts" class="carousel" data-ride="carousel">
        <ol class="carousel-indicators">
            @forelse ($alerts as $index => $alert)
                <li data-target="#alerts" data-slide-to="{{ $index }}" @if ($loop->first) class="active" @endif></li>
            @empty
            @endforelse
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
                    <p class="font-italic py-3 mb-2">No alerts for company.</p>
                </div>
            @endforelse
        </div>
        {{--<a class="carousel-control-prev" href="#alerts" role="button" data-slide="prev">
            <span class="carousel-control-custom-icon" aria-hidden="true">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#alerts" role="button" data-slide="next">
            <span class="carousel-control-custom-icon" aria-hidden="true">
              <i class="fas fa-chevron-right"></i>
            </span>
            <span class="sr-only">Next</span>
        </a>--}}
    </div>
</div>
