$.extend(true, $.fn.dataTable.defaults, {
    'ajax': {
        error: function (jqXHR) {
            console.log(jqXHR);
        },
        beforeSend: function (request) {
            request.setRequestHeader("Accept", 'application/json');
        }
    },
    'autoWidth': false,
    'responsive': true,
    'stateSave': true,
    'serverSide': true,
    'paging': true,
    'lengthChange': true,
    'lengthMenu': [50, 100, 150],
    'pageLength': 50,
    'searching': true,
    'ordering': true,
    'processing': true,
});
$("#position-table").DataTable({
    ajax: {
        url: '/positions',
        beforeSend: function (request){
            request.setRequestHeader('Accept', 'application/json')
        }
    },
    order: [[1, 'asc']],
    columns: [
        {
            data: 'name',
            name: 'name',
            title: 'Name'
        },
        {
            data: 'updated_at',
            name: 'updated_at',
            title: 'Last update',
            width: '100px'
        },
        {
            data: 'action',
            name: 'action',
            class: 'action-width',
            title: 'Action',
            searchable: false,
            orderable: false,
            width: '90px'
        }
    ]
}).on('draw', function () {
    $('.button-db').on('click', function () {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Remove position',
            text: 'Are you sure you want to remove position ' + $(this).data('name'),
            confirmButtonText: 'Remove',
            cancelButtonText: 'Cancel',
            showCancelButton: true,
            reverseButtons: true,
            showCloseButton: true
        }).then(function(result){
            if (result.value)
                form.submit();
        })
    })
})

$('.countable>input[type="text"]').on('input', function(){
    const length = $(this).val().length;
    const maxlength = $(this).attr('maxlength');
    const inputName = $(this).attr('name');
    $(`small#${inputName}-meta`).text(   `${length}/${maxlength}` )
})


