console.log($.fn);
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
$("#employees-table").DataTable({
    ajax: {
        url: '/employees',
        beforeSend: function (request){
            request.setRequestHeader('Accept', 'application/json')
        }
    },
    order: [[1, 'asc']],
    columns: [
        {
            data: 'photo',
            name: 'photo',
            title: 'Photo',
            searchable: false,
            orderable: false,
            render: function(data){
                return `<img width="50px" height="50px" class="rounded-circle" src="${data}">`;
            }
        },
        {
            data: 'name',
            name: 'name',
            title: 'Full name'
        },
        {
            data: 'position.name',
            name: 'position.name',
            title: 'Position'
        },
        {
            data: 'employment_date',
            name: 'employment_date',
            title: 'Employment date'
        },
        {
            data: 'number',
            name: 'number',
            title: 'Phone number'
        },
        {
            data: 'email',
            name: 'email',
            title: 'Email'
        }
        ,
        {
            data: 'salary',
            name: 'salary',
            title: 'Salary'
        },
        {
            data: 'action',
            name: 'action',
            class: 'action-width',
            title: 'Action',
            searchable: false,
            orderable: false
        }
    ]
}).on('draw', function () {
    $('.button-db').on('click', function () {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Remove employee',
            text: 'Are you sure you want to remove employee ' + $(this).data('name'),
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


