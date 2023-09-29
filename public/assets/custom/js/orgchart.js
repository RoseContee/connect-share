let orgChart;

$(function () {
    $(window).on('load', function () {
        orgChart?.init({
            verticalLevel: $(window).width() > 576 ? undefined : 2,
        });
    });

    $('#orgchart').on('nodedrop.orgchart', function(e, params) {
        const $dragZoneCard = $(params.dragZone).find('.card'),
            dragZoneChildren = $dragZoneCard.data('children');
        const $dropZoneCard = $(params.dropZone).find('.card'),
            dropZoneChildren = $dropZoneCard.data('children');
        $dragZoneCard.data('children', dragZoneChildren - 1)
            .find('.info').html(ocNodeInfoTemplate(dragZoneChildren - 1));
        $dropZoneCard.data('children', dropZoneChildren + 1)
            .find('.info').html(ocNodeInfoTemplate(dropZoneChildren + 1));
    }).on('mouseenter', '.node', function () {
        if (!orgChart) return;
        const $node = $(this);
        orgChart.getSiblings($node).addClass('highlight-siblings');
        orgChart.getChildren($node).addClass('highlight-children');
        let $parent = $node;
        while (($parent = orgChart.getParent($parent)).length) {
            $parent.addClass('highlight-parent');
        }
    }).on('mouseleave', '.node', function () {
        if (!orgChart) return;
        orgChart.$chart
            .find('.highlight-parent, .highlight-siblings, .highlight-children')
            .removeClass('highlight-parent highlight-siblings highlight-children');
    });
});

const ocNodeTemplate = function (data) {
    const children = data.children?.length || 0;
    return `
        <div class="card" data-admin="${ !!data.isAdmin }" data-children="${children}">
            <div class="card-body">
                ${ocNodeAvatarTemplate(data.avatar)}
                ${data.name}
                <div class="info">${ocNodeInfoTemplate(children)}</div>
            </div>
        </div>
    `;
};

const ocNodeAvatarTemplate = function (avatar) {
    if (!avatar) return '';
    return `<div class="avatar"><img src="${avatar}" alt="avatar"></div>`
};

const ocNodeInfoTemplate = function (children) {
    if (!children) return '';
    return `<i class="fa fa-user-circle"></i> ${children}`;
};

const showOCNodePath = function () {
    if (!orgChart) return;
    const $selected = orgChart.$chart.find('.node.focused');
    orgChart.hideChildren($selected);
    $selected.parents('.nodes')
        .children(':has(.focused)')
        .children('.node')
        .each(function (index, node) {
            orgChart.hideSiblings($(node));
        });
};

const showOCAllNode = function () {
    if (!orgChart) return;
    orgChart.init({
        data: orgChart.getHierarchy({includeNodeData: true}),
    });
};
