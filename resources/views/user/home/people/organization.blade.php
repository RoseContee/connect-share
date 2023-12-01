@extends('user.home.layouts')

@php
$user = request()->user();
@endphp

@section('title', 'Organization Chart')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/orgchart/css/jquery.orgchart.min.css') }}">
@endpush

@section('home-content')
    <div class="card">
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

    @if ($user['is_admin'])
        <!-- User Info Modal -->
        <div id="user-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img id="user_avatar" src="" alt="Avatar"
                                 class="profile-user-img img-fluid img-circle">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Given Name:</b></div>
                                    <div id="given_name" class="col-8"></div>
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Surname:</b></div>
                                    <div id="family_name" class="col-8"></div>
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Title:</b></div>
                                    <div id="org_title" class="col-8"></div>
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Department:</b></div>
                                    <div id="org_department" class="col-8"></div>
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Email:</b></div>
                                    <div id="user_email" class="col-8"></div>
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-4"><b>Phone:</b></div>
                                    <div id="user_phone" class="col-8"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Hide Modal -->
        <div id="user-hide-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('organization') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user">
                        <div class="modal-header">
                            <h4 class="modal-title">Remove User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to remove this user from organization chart?</p>
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

@push('before-scripts')
    <script src="{{ asset('assets/plugins/orgchart/js/jquery.orgchart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/json-digger/json-digger.js') }}"></script>
@endpush

@push('after-scripts')
    <script type="text/javascript">
        $(() => {
            const orgChartData = {!! json_encode($organization) !!};

            const nodeTemplate = function (node) {
                const isAdmin = {{ $user['is_admin'] ? 1 : 0 }};
                const children = node.children?.length || 0;
                return `
                    <div class="card" data-admin="${ !!node.isAdmin }" data-children="${ children }">
                        <div class="card-body">
                            <div class="avatar"><img src="${ node.avatar }" alt="avatar"></div>
                            ${ node.name }
                            <div class="info">
                                <span class="user-info">
                                    ${ node.id !== 1 ? `<i class="fa fa-info-circle"></i>` : '' }
                                </span>
                                <span class="user-number">
                                    ${ children ? `<i class="fa fa-user-circle"></i> ${ children }` : '' }
                                </span>
                                <span class="user-hide">
                                    ${ isAdmin && !node.manager && !children ? `<i class="fa fa-ban"></i>` : '' }
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            };

            const $orgchart = $('#orgchart');
            const orgChart = $orgchart.orgchart({
                data: orgChartData,
                pan: true,
                zoom: true,
                toggleSiblingsResp: true,
                verticalLevel: $(window).width() <= 576 ? 2 : undefined,
                nodeTemplate: nodeTemplate,
                dropCriteria: function($draggedNode) {
                    return !$draggedNode.find('.card').data('admin');
                }
            });

            $orgchart.on('mouseenter', '.node', function () {
                const $node = $(this);
                orgChart.getSiblings($node).addClass('highlight-siblings');
                orgChart.getChildren($node).addClass('highlight-children');
                let $parent = $node;
                while (($parent = orgChart.getParent($parent)).length) {
                    $parent.addClass('highlight-parent');
                }
            }).on('mouseleave', '.node', function () {
                orgChart.$chart
                    .find('.highlight-parent, .highlight-siblings, .highlight-children')
                    .removeClass('highlight-parent highlight-siblings highlight-children');
            });

            $('#show-path').on('click', function () {
                orgChart.$chart
                    .find('.node.focused')
                    .parents('.nodes')
                    .children(':has(.focused)')
                    .children('.node')
                    .each(function (index, node) {
                        orgChart.hideSiblings($(node));
                    });
            });

            $('#show-all').on('click', function () {
                orgChart.init({
                    data: orgChart.getHierarchy({includeNodeData: true}),
                });
            });

            @if ($user['is_admin'])
            const getUser = function (data, id) {
                if (data.id === id) return data;
                if (data.children && data.children.length) {
                    for (let i = 0; i < data.children.length; i++) {
                        const user = getUser(data.children[i], id);
                        if (user) return user;
                    }
                }
                return null;
            };

            $orgchart.on('click', '.user-info', function() {
                const selectedUserId = $(this).closest('.node').attr('id').trim();
                const user = getUser(orgChartData, selectedUserId);
                const $modal = $('#user-info-modal');
                $modal.find('.modal-title').text(user?.name ?? '');
                $modal.find('#user_avatar').attr('src', user?.avatar);
                $modal.find('#given_name').text(user?.given_name ?? '');
                $modal.find('#family_name').text(user?.family_name ?? '');
                $modal.find('#org_title').text(user?.org_title ?? '');
                $modal.find('#org_department').text(user?.org_department ?? '');
                $modal.find('#user_email').text(user?.email ?? '');
                $modal.find('#user_phone').text(user?.phone ?? '');
                $modal.modal('show');
            }).on('click', '.user-hide', function() {
                const selectedUserId = $(this).closest('.node').attr('id').trim();
                const $modal = $('#user-hide-modal');
                $modal.find('[name=user]').val(selectedUserId);
                $modal.modal('show');
            });
            @endif
        });
    </script>
@endpush
