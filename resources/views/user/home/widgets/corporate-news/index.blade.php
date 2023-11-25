@push('after-styles')
    <style>
        #corporate-news.carousel .carousel-indicators {
            margin-bottom: 0;
            bottom: -30px;
        }

        #corporate-news.carousel .carousel-indicators li {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #007bff;
        }

        @media (min-width: 768px) {
            #corporate-news.carousel .carousel-inner .carousel-item.active,
            #corporate-news.carousel .carousel-inner .carousel-item.active + .carousel-item {
                display: block;
            }

            #corporate-news.carousel .carousel-inner .carousel-item {
                margin-right: 0;
            }
        }
    </style>
@endpush

<div class="corporate-news-container {{ $class ?? '' }}">
    <h5>Corporate News <i class="fa fa-chevron-right"></i></h5>
    <div id="corporate-news" class="carousel" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($newses as $index => $news)
                <li data-target="#corporate-news" data-slide-to="{{ $index }}" @if (!$index) class="active" @endif></li>
            @endforeach
        </ol>
        <div class="carousel-inner row flex-nowrap">
            @forelse ($newses as $news)
                <div class="carousel-item col-md-6 @if ($loop->first) active @endif">
                    <div class="card m-0">
                        <div class="card-body d-flex align-items-center bg-gray-light p-2">
                            <div class="img-rounded bg-primary text-center px-2 py-1 mr-2">
                                <h6 class="text-nowrap m-0">{{ date('j M', strtotime($news['date'])) }}</h6>
                                <p class="small m-0">{{ date('H:i', strtotime($news['date'])) }}</p>
                            </div>
                            <p class="text-truncate m-0">{{ $news['description'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="font-italic py-3">No news for company.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
