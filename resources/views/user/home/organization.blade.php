@extends('user.home.layouts')

@section('title', 'Organization Chart')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/orgchart/css/jquery.orgchart.min.css') }}">
@endpush

@section('home-content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-header">
                    <button id="show-path" class="btn btn-default btn-sm mr-2">
                        <i class="fa fa-filter"></i> Show Path
                    </button>
                    <button id="show-all" class="btn btn-default btn-sm">
                        <i class="fa fa-eye"></i> Show All
                    </button>
                </div>
                <div class="card-body">
                    <div id="orgchart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/orgchart/js/jquery.orgchart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/json-digger/json-digger.js') }}"></script>
@endpush

@push('after-scripts')
    <script src="{{ asset('assets/custom/js/orgchart.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            orgChart = $('#orgchart').orgchart({
                data : {!! json_encode($organization) !!},
                draggable: true,
                pan: true,
                zoom: true,
                toggleSiblingsResp: true,
                nodeTemplate: ocNodeTemplate,
                dropCriteria: function($draggedNode) {
                    return !$draggedNode.find('.card').data('admin');
                }
            });

            $('#show-path').on('click', showOCNodePath);

            $('#show-all').on('click', showOCAllNode);
        });
    </script>
@endpush
