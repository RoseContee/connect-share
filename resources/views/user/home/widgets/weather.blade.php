@php
$widgetId = 85924;
@endphp

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}">
@endpush

<!-- weather widget start -->
<div class="weather-widget-container d-block d-sm-flex align-items-center justify-content-center">
    <div class="d-flex justify-content-center">
        <input type="text" id="weather-city" class="form-control" style="max-width: 200px;">
    </div>
    <div id="m-booked-prime-days-{{ $widgetId }}"></div>
</div>
<!-- weather widget end -->

@push('before-scripts')
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        const weatherCss = document.createElement('link');
        weatherCss.setAttribute('rel', 'stylesheet');
        weatherCss.setAttribute('type', 'text/css');
        weatherCss.setAttribute('href', 'https://s.bookcdn.com/css/w/booked-wzs-widget-prime-days.css?v=0.0.1');
        document.getElementsByTagName('head')[0].appendChild(weatherCss);

        const weather_city = getCookie('weather_city').split('|');
        const cityID = weather_city[0] || 18087;
        const city = weather_city[1] || 'Rome';
        document.getElementById('weather-city').value = city;
        const params = {
            action: 'get_weather_info',
            ver: 7,
            cityID: cityID,
            type: 6,
            scode: '',
            ltid: 3457,
            domid: 'w209',
            anc_id: 62146,
            countday: 5,
            cmetric: 1,
            wlangID: 1,
            color: '137AE9',
            wwidth: 250,
            header_color: 'ffffff',
            text_color: '333333',
            link_color: '08488D',
            border_form: 1,
            footer_color: 'ffffff',
            footer_text_color: '333333',
            transparent: 0,
            v: '0.0.1',
            ref: '{{ url()->current() }}',
            rand_id: {{ $widgetId }},
        };
        let query = '';
        for (let key in params) {
            query += key + '=' + params[key] + ';';
        }
        const weatherScript = document.createElement('script');
        weatherScript.setAttribute('type', 'text/javascript');
        weatherScript.src = 'https://widgets.booked.net/weather/info?' + query;
        document.body.appendChild(weatherScript);

        function setWidgetData_{{ $widgetId }} (data) {
            if (typeof (data) != 'undefined' && data.results.length > 0) {
                for (let i = 0; i < data.results.length; ++i) {
                    const objMainBlock = document.getElementById('m-booked-prime-days-{{ $widgetId }}');
                    if (objMainBlock !== null) {
                        const copyBlock = document.getElementById('m-bookew-weather-copy-' + data.results[i].widget_type);
                        objMainBlock.innerHTML = data.results[i].html_code;
                        if (copyBlock !== null) objMainBlock.appendChild(copyBlock);
                    }
                }
            } else {
                alert('Cannot find city data.');
            }
        }
    </script>

    <script type="text/javascript">
        $(() => {
            $('#weather-city').autocomplete({
                position: {
                    collision: 'flip',
                },
                source: (request, response) => {
                    const q = request.term;
                    if (q.length < 2) {
                        return response([]);
                    }
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('weather-cities') }}',
                        dataType: 'json',
                        data: { q: q },
                        success: data => {
                            response($.map(data, val => {
                                return {
                                    id: val.id,
                                    cnt: val.cnt,
                                    label: val.full_city,
                                    value: val.city,
                                };
                            }));
                        },
                        error: () => {
                            response([]);
                        }
                    });
                },
                select: (event, ui) => {
                    document.cookie = 'weather_city=' + ui.item.id + '|' + ui.item.value;
                    location.reload();
                }
            });
        });
    </script>
@endpush
