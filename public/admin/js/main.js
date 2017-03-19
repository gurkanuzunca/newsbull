
var baseUrl = document.getElementsByTagName('base')[0].href;


if (typeof CKFinder !== 'undefined'){
    CKFinder.setupCKEditor(null, document.getElementsByTagName('base')[0].href.replace('admin/', '') + 'public/admin/plugin/ckfinder/');
}

// Document ready
$(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $('.fancybox').fancybox();
    $('.mask-money').maskMoney({thousands: ''});
    $(".datetimepicker").datetimepicker({language: 'tr', todayBtn: true});

    $('.sidemenu > ul > li > a').on('click', function(){
        var $this = $(this);

        if (! $this.next().is(':visible')){
            $('.sidemenu li ul:visible').slideUp(200);
        }

        if ($this.next()){
            $this.next().slideDown(200);
        }
    });


    var modal = {
        confirm: function(callback){
            $('#modal-confirm-delete').modal('show');
            $('#confirm-true').on('click', function(){
                callback();
                return false;
            });
        }
    };


    $('.confirm-delete').on('click', function(){
        var url = $(this).attr('href');

        modal.confirm(function(){
            location.href = url;
        });
        return false;
    });



    $('.checkall').on('click', function(){
        if (! $(this).hasClass('active')){
            $('.checkall-item').prop('checked','checked');
        } else {
            $('.checkall-item').removeAttr('checked');
        }
    });


    $('.deleteall').on('click', function(){
        var url = $(this).attr('href');
        var ids = [];

        $('.checkall-item:checked').each(function(){
            ids.push($(this).val());
        });

        if (ids.length > 0){

            modal.confirm(function(){
                $.post(url, {ids: ids}, function(response){
                    location.href = response;
                });
            });
        }
        return false;
    });



    $('#modal-relation-button').on('click', function(){
        var url = $(this).attr('href');

        $.get(url, function(response){
            $('#modal-relation .modal-body').html(response.html);
        }, 'json');

        $('#modal-relation').modal('show');

        return false;
    });




    $('#modal-relation').on('click', '.relation-insert', function(){
        var element = $(this);
        var url = element.attr('href');

        $.get(url, function(response){
            if (response.success === true){
                element
                    .addClass('disabled')
                    .removeClass('btn-danger')
                    .addClass('btn-success')
                    .attr('href', '');
            }
        }, 'json');

        return false;
    });


    $('#modal-relation').on('hidden.bs.modal', function(){
        location.reload();
    });


    $('.sortable').sortable({
        opacity : 0.8,
        containment : 'parent',
        cursor : 'move',
        placeholder : 'placeholder',
        handle : '.sortable-handle',

        update : function(event, ui) {
            var ids = $(this).sortable('toArray', {attribute : 'data-id'}).toString();
            $('#order-update').data('ids', ids).removeClass('hide');
        },

        helper : function(event, ui){
            ui.children('td').each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }
    });



    $('#order-update').on('click', function(){
        var url = $(this).attr('href');

        $.post(url, {ids: $(this).data('ids')}, function(){
            location.reload();
        });

        return false;
    });



    /**
     * Plupload objesi varsa.
     */
    if (typeof plupload !== 'undefined'){

        var pluploadModalButton = $('#modal-plupload-button');
        var pluploadModal = $('#modal-plupload');
        var pluploadPickFiles = $('#plupload-pickfiles');
        var pluploadCancel = $('#plupload-cancel');
        var pluploadUpload = $('#plupload-upload');
        var pluploadOkay = $('#plupload-okay');
        var pluploadFileList = $('#plupload-filelist');

        var filelist = [];
        var uploader = new plupload.Uploader({
            runtimes		: 'html5,flash,html4',
            browse_button	: 'plupload-pickfiles',
            max_file_size	: '10mb',
            url				: baseUrl + pluploadModalButton.attr('href'),
            flash_swf_url	: 'plupload.flash.swf',
            filters : [
                {title : "Dosya", extensions : "jpg,gif,png"}
            ]
        });

        uploader.init();


        var Template = function(options){
            var node		= $('<div/>').addClass('row').prop('id', options.id).css({'overflow': 'hidden', 'white-space': 'nowrap', 'text-overflow': 'ellipsis'});
            var name		= $('<div/>').addClass('col-xs-6');
            var size		= $('<div/>').addClass('col-xs-2');
            var progress	= $('<div/>').addClass('col-xs-4').append(
                $('<div/>').addClass('progress').append(
                    $('<div/>').addClass('progress-bar progress-bar-success').css('width', '0%')
                )
            );

            name.text(options.name);
            size.text(options.size);
            node.append(name);
            node.append(size);
            node.append(progress);
            node.appendTo(pluploadFileList);
        };


        pluploadModalButton.on('click', function(){
            pluploadPickFiles.show();
            pluploadCancel.show();
            pluploadUpload.hide();
            pluploadOkay.hide();

            uploader.files = [];
            filelist = [];

            pluploadFileList.empty();
            pluploadModal.modal('show');

            return false;
        });


        pluploadUpload.on('click', function() {
            uploader.start();
            pluploadOkay.show().addClass('disabled');
            pluploadUpload.hide();
            pluploadCancel.hide();

            return false;
        });


        pluploadOkay.on('click', function(){
            if (! $(this).hasClass('disabled')){
                location.reload();
            }
        });


        uploader.bind('FilesAdded', function(up, files) {
            $.each(files, function(i, file) {

                // aynı dosya kontrolü
                if ($.inArray(file.name, filelist) >= 0){
                    up.removeFile(file);
                } else {

                    pluploadUpload.show();
                    pluploadOkay.hide();

                    new Template({
                        id		: file.id,
                        name	: file.name,
                        size	: plupload.formatSize(file.size)
                    });
                }
                filelist.push(file.name);

            });

            up.refresh();
        });


        uploader.bind('UploadProgress', function(up, file) {
            if (file.percent < 100 && file.percent >= 1){
                $('.progress-bar', '#'+file.id).css('width', file.percent + '%');
            }
        });


        uploader.bind('FileUploaded', function(up, file, response) {
            $('.progress-bar', '#'+file.id).css('width', '100%');

            response = $.parseJSON(response.response);
            if (response.error.code === '500') {
                $('#' + file.id).css('margin-bottom', '20px').html('<div class="col-xs-12">Hata: ' + response.error.message + ' Dosya: ' + file.name + '</div>');
                file.status = plupload.FAILED;
            } else {
                file.status = plupload.DONE;
            }
        });


        uploader.bind('UploadComplete', function(up, file) {
            pluploadOkay.removeClass('disabled');
        });


        uploader.bind('Error', function(up, error) {

            // aynı dosya kontrolü
            if ($.inArray(error.file.name, filelist) >= 0){
                up.removeFile(error.file);
            } else {
                $('<div/>')
                    .prop('id', error.file.id)
                    .css('margin-bottom', '20px')
                    .text('Hata: ' + error.message + ' Dosya: ' + error.file.name)
                    .appendTo(pluploadFileList);
            }
            filelist.push(error.file.name);


            up.refresh();
        });

    }


});
