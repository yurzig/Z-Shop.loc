// Добавляем блок текста в статью
$('.add-block-to-post button').on('click', function (event) {
    event.preventDefault()

    const block = $(this),
          main = block.closest('.add-block-to-post'),
          type = block.data('type');

    let id = parseInt(main.attr('data-last-block'));

    id = id + 1;

    main.attr('data-last-block', id);

    let data = new FormData();
    data.append('blockId', id);
    data.append('type', type);

    requestAjax(main.data('url'), data, function (response){

        block.parent().before(response);

        if (type === 'img-and-text' || type === 'text-only'|| type === 'subtitle') {
            $('.summernote').summernote();
        }

    }, function (error, i, code ){
        console.log('error-' + error + ' i-' + i + ' code-' + code);
    },
        'html');

});

let image = document.getElementById('image');

let imageWidth = 0;
let imageHeight = 0;

let cropper;
$(document).on('change','.block-image-upload',function(e){
    let files = e.target.files;
    let done = function (url) {
        image.src = url;
        $("#change-img-modal").modal("show");
    }
    let reader = new FileReader();
    let file;

    let w = $('input[id^="img-width"]:checked');

    imageWidth = w.data('width');
    imageHeight = w.data('height');

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);

        }
    }
});

$('#change-img-modal').on('shown.bs.modal',function () {
    cropper = new Cropper(image, {
        aspectRatio: imageWidth/imageHeight,
        viewMode: 3,
        zoomable: false,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
});

// Сохраняем обрезанное изображение
$('.apply-btn').on('click', function () {
    let url = $(this).data('url');
    let canvas = cropper.getCroppedCanvas({
        width: imageWidth,
        height: imageHeight,
    });

    canvas.toBlob(function(blob) {
        let data = new FormData();
        let reader = new FileReader();
        var image = $(".head-image").find('img');
        var path = $(".head-image").find('input');


        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            const cropImage = reader.result;

            image.attr('src', cropImage);
            data.append('image', cropImage);

            requestAjax(url, data, function (response){
                console.log(response.success);
                $("#change-img-modal").modal("hide");

                path.val(response.success);
                alert("Картинка сохранена");

                }, function (error, i, code ){
                    console.log('error-' + error + ' i-' + i + ' code-' + code);
                });

        }
    });
});

// Поведение кнопок при изменении ширины картинки
$(document).on('click',$('input[id^="img-width"]'),function(){
    const value = $('input[id^="img-width"]:checked').val();

    if (value !== undefined) {
        if (value === '100') {
            $('.percent-100').hide();
        } else {
            $('.percent-100').show();
        }
    }
});

/**
 Инициализация сортировки блоков
 */

Sortable.create(sortableBlock, {
    handle: '.handle',
    animation: 150,

});

/**
 Раскрыть\скрыть все блоки статьи
 */
$(document).on('click', '.collapsed-btn', function(){
    if ($(this).text() === 'Развернуть блоки') {
        $('.accordion-collapse').collapse('show');
        $(this).text('Свернуть блоки');
    } else {
        $('.accordion-collapse').collapse('hide');
        $(this).text('Развернуть блоки');
    }
});

/**
 Удалить блок
 */
$(document).on('click', '.js-delete-block', function() {
    const block = $(this).closest('.accordion-item');
    block.remove();
});

/**
 Создать блок заголовка при первоначальном заполнении поля Название статьи
 */
$(document).on('change','.js-title', function() {
    console.log($(this).val());

    if($(".block-subtitle").length) {
        return;
    }

    const main = $('.add-block-to-post'),
        title = $('input[name="title"]').val();

    let id = parseInt(main.attr('data-last-block'));

    id = id + 1;

    main.attr('data-last-block', id);

    let data = new FormData();
    data.append('blockId', id);
    data.append('type', 'subtitle');
    data.append('title',title);
    data.append('titleType','h1');

    requestAjax(main.data('url'), data, function (response){

            main.before(response);

            $('.summernote').summernote();

        }, function (error, i, code ){
            console.log('error-' + error + ' i-' + i + ' code-' + code);
        },
        'html');

    // console.log($('input[name="content[0][text]"]').html('<div></div>'));
   // $('.note-editable').val($(this).val());
   //  $('.summernote').summernote();
});