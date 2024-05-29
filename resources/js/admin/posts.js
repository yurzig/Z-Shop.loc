// Добавляем блок текста в статью
$('.add-block-to-post button').on('click', function (event) {
    event.preventDefault()

    let data = new FormData(),
        block = $(this),
        type = block.data('type');

    data.append('type', type);

    requestAjax(block.closest('.add-block-to-post').data('url'), data, function (response){

        block.parent().before(response);

        if (type === 'img-and-text' || type === 'img-only') {
            $('.summernote').summernote();
        }

    }, function (error, i, code ){
        console.log('error-' + error + ' i-' + i + ' code-' + code);
    },
        'html');
});


// let image = $("#change-img-modal #image");
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
    let url;

    let w = $('input[name="img-width"]:checked');

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

        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            const cropImage = reader.result;

            image.attr('src', cropImage);
console.log(cropImage);
            data.append('image', cropImage);

            requestAjax(url, data, function (response){
                console.log(response);
                $("#change-img-modal").modal("hide");
                alert("Картинка сохранена");

                }, function (error, i, code ){
                    console.log('error-' + error + ' i-' + i + ' code-' + code);
                });

        }
    });
});

// Поведение кнопок при изменении ширины картинки
$(document).on('click',$('input[name="img-width"]'),function(){
    const value = $('input[name="img-width"]:checked').val();

    if (value !== undefined) {
        if (value === '100') {
            $('.percent-100').hide();
        } else {
            $('.percent-100').show();
        }
    }
});
