// Добавляем блок текста в статью
$('.add-block-to-post button').on('click', function (event) {
    event.preventDefault()

    let data = new FormData(),
        block = $(this);

    data.append('type', $(this).data('type'));

    requestAjax(block.closest('.add-block-to-post').data('url'), data, function (response){

        block.parent().before(response);
        $('.summernote').summernote();

    }, function (error, i, code ){
        console.log('error-' + error + ' i-' + i + ' code-' + code);
    },
        'html');
});


// let image = $("#change-img-modal #image");
var image = document.getElementById('image');

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
        aspectRatio: 1,
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
    let canvas = cropper.getCroppedCanvas({
        width: 600,
        height: 600,
    });

    canvas.toBlob(function(blob) {
        let url = URL.createObjectURL(blob);
        let reader = new FileReader();
        var image = $(".head-image").find('img');

        reader.readAsDataURL(blob);
        reader.onloadend = function() {

            image.attr('src', reader.result);
            $("#change-img-modal").modal("hide");
        //     $.ajax({
        //         введите: "ОПУБЛИКОВАТЬ",
        //         Тип данных: "json",
        //         url: "обрезка изображения-загрузка",
        //         данные: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
        //     успех: функция(данные){
        //         консоль.журнал(данные);
        //         $modal.модальный('скрыть');
        //         оповещение("Обрезка изображения успешно загружена");
        //     }
        // });
        }
    });

});

