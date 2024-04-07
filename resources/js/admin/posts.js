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


$(document).on('change','.block-image-upload',function(event){
    let reader = new FileReader(),
        output = $("#change-img-modal").find('img');

    $("#change-img-modal").modal("show");

    reader.readAsDataURL(event.target.files[0]);
    reader.onload = function () {
        output.attr('src', reader.result);
        createCropper(16/9);
    }

});

var cropper={destroy:function(){}};

var cropX;
var cropY;
var cropWidth;
var cropHeight;

var upload_block=0;

function createCropper(aspectRatio){
    cropper.destroy();
    var cropImg = $("#change-img-modal").find("img")[0];
    console.log(cropImg);
    // console.log(aspectRatio);
    cropper = new Cropper(cropImg, {
        aspectRatio:aspectRatio,
        responsive: true,
        restore: true,
        viewMode: 2,
        zoomable: false,
        crop: function(e) {
            cropX= Math.round(e.detail.x);
            cropY= Math.round(e.detail.y);
            cropWidth= Math.round(e.detail.width);
            cropHeight= Math.round(e.detail.height);
            console.log('cropWidth'+cropWidth);
        },
        ready:function(){

            var cropRatio=aspectRatio;
            var cropWidth=0;
            var cropHeight=0;
            var cropX=0;
            var cropY=0;
            var imgData=cropper.getImageData();
            var imgW=imgData.naturalWidth;
            var imgH=imgData.naturalHeight;
            var imgRatio=imgData.aspectRatio;

            if(imgRatio>cropRatio){
                cropHeight=imgH;
                cropWidth=cropHeight*cropRatio;
                cropY=0;
                cropX=(imgW-cropWidth)/2;
            }else{
                cropWidth=imgW;
                cropX=0;
                cropHeight=cropWidth/cropRatio;
                cropY=(imgH-cropHeight)/2;
            }
            console.log('cropWidth'+cropWidth);

            cropper.setData({width:cropWidth,height:cropHeight});
            cropper.setData({x:cropX,y:cropY});
        }
    });
}


