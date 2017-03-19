$(function() {



    $('#modal-modules-button').on('click', function(){
        $('#modal-modules').modal('show');
        return false;
    });


    $('#modal-modules .nav').on('click', 'a', function(){
        var element = $(this);
        var table = $(element.attr('href')).find('tbody');
        var url = element.data('url');


        if (table.html() == '') {
            $.get(url, function(response){
                if (response.success === true){
                    table.html(response.html);
                }
            }, 'json');
        }

    });



    $('#modal-modules').on('click', '.menu-insert', function(){
        var element = $(this);
        var url = $('#modal-modules-button').attr('href');
        var data = {
            'module': element.data('module'),
            'id': element.data('id'),
            'title': element.data('title'),
            'hint': element.data('hint'),
            'link': element.data('link')
        };

        $.post(url, data, function(response){
            if (response.success === true){
                element.removeClass('btn-danger').addClass('btn-success');
            }
        }, 'json');

        return false;
    });


    $('#modal-modules').on('hidden.bs.modal', function(){
        location.reload();
    });



});
