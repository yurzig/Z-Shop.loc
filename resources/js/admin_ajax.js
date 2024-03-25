window.requestAjax = function ( url, data, success_func, error_func, data_type = 'json' ){

    if( $.isArray(data) ){
        data.push({name: 'ajax', value: true});
    }else{
        data.ajax = true;
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: data_type,
        processData: false,
        contentType: false,
        cache: false,
        headers:  {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function( response, textStatus, xhr ){

            if( success_func )
                success_func(response, textStatus, xhr);

        },
        error: function (error,i,code) {

            if( error_func )
                error_func(error,code);

        }
    });

};

$(document).ready(function () {
    $.ajaxSetup({
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        processData: false,
        contentType: false,
    });
    function uploadImage(image, textarea) {
        let data = new FormData();

        data.append('image', image);

        $.ajax({
            url        : '/admin/image/upload',
            data       : data,
            cache      : false,
            success: function(response) {
                if (response.success) {
                    $(textarea).summernote('insertImage', response.filepath, function ($img) {
                        $img.css('max-width', '100%');
                    });
                } else {
                    console.log(response.message);
                }
            }
        });
    }

    $(document).on('click', '.js-add-text', function() {
        const template = document.querySelector($(this).attr('data-tpl')),
            el = template.content.cloneNode(true),
            textId = $(this).data('id'),
            dataId = $('#card-tools-more');
        let id = dataId.data('id'),
            data = new FormData(),
            item;

        $('.new-block').removeClass('new-block');
        $(el).find('.js-block').addClass('new-block');

        $(el).insertBefore(dataId);

        data.append('id', textId);

        $.ajax({
            url    : '/admin/texts/row',
            data   : data,
            success: function(response) {
                $('.new-block .header-label').text(response.type + ' | ' + response.title);
                $('.new-block .text-id').val(response.id);
                $('.new-block .text-type').val(response.type);
                $('.new-block .text-title').val(response.title);
                $('.new-block .text-content').html(response.content);
            },
            error: function( response ){
                console.log( 'AJAX error: ' + JSON.stringify(response));
            }
        });
        $('.new-block .js-repl').each( function() {
            item = $(this);
            $.each(this.attributes, function(index, attribute) {
                if(attribute.value.indexOf('xxx') >= 0) {
                    item.attr(attribute.name, attribute.value.replace('xxx', id));
                }
            });
        });

        dataId.removeData('id').attr('data-id', ++id);
    });

});
