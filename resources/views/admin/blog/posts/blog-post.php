<? /** @var \site\requests\admin\clsAdminBlogPost $object */
$post=$object->getBlogPost();
if(empty($post->getLang())){
    $clsTranslationLangs = \entities\clsTranslationLangs::getBySlug('ru');
    $post->setLang($clsTranslationLangs->getIdVal());
}
$box = $post->getLowcost();

$langsList = \entities\clsTranslationLangs::getAll();

$link = '';
if ($box && \functions::isDebug())
    $link = 'https://pochtoy-lowcost.alef.im/blog/';
elseif ($box && !\functions::isDebug())
    $link = 'https://prostobox.com/blog/';
elseif (!$box && !\functions::isDebug())
    $link = 'https://pochtoy.com/blog/';
else
    $link = 'https://pochtoy-site.alef.im/blog/';
?>
<script src="/js/tinymce/tinymce.min.js"></script>
<div class="container blog">
    <div class="inner no-top-margin">
        <div class="block-wrapper no-top-margin">
            <div class="title">
                <h2>
                    Опции поста для
                    <span style="font-size: 20px; font-weight: bold">
                        <?php echo (!$box) ? 'POCHTOY.COM' : 'PROSTOBOX.COM'; ?>
                    </span>
                </h2>
            </div>
            <div class="row">
                <div class="col-md-4 l-col">
                    <label class="caption">Язык:</label>
                </div>
                <div class="col-md-8 r-col">
                    <select id="selectLang">
                        <? foreach ($langsList as $langItem): ?>
                            <option value="<?= $langItem->getIdVal(); ?>"
                                    <?= $post->getLang()->getIdVal() == $langItem->getIdVal() ? 'selected' : ''; ?>
                            >
                                <?= $langItem->getTitle(); ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Теги:</label></div>
                <div class="col-md-8 r-col">
                    <ul class="listbox selected-tags">
                        <? foreach ($post->getTags() as $tag): ?>
                            <li><label><?=$tag?></label><div class="action-btns"><button class="delete-tag">Удалить тег</button></div></li>
                        <? endforeach; ?>
                    </ul>
                    <input type="text" class="tags md inline-block" placeholder="Тег"><div class="btn-toolbar inline"><button class="add-tag btn sm btn-default">Добавить тег</button></div>
                    <ul class="listbox search-tags" style="display: none;">

                    </ul>
                </div>
                <div class="col-md-4 l-col"><label class="caption">Категории:</label></div>
                <div class="col-md-8">
                    <ul class="listbox categories-list">
                        <? foreach (\entities\clsBlogPostCategory::getCategories() as $category):
                            $checked="";
                            if($post->isCategory($category)){
                                $checked='checked="checked"';
                            }
                            ?>
                        <li><input data-id="<?=$category->getIdVal()?>" <?=$checked?> type="checkbox" id="cat-checkbox<?=$category->getIdVal()?>" ><label for="cat-checkbox<?=$category->getIdVal()?>" ><?=$category->getName()?></label></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Видимость поста:</label></div>
                <div class="col-md-8">
                    <span class="col-txt no-bottom-margin"><?=clsHTMLBuilder::checkBox($post->getVisible(),'post-visibility') ?><label for="post-visibility">Пост доступен для всех</label></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Превью:</label></div>
                <div class="col-md-8" style="position: relative;">
                    <img class="post-thumb-preview" src="<?=$post->getPictureUrl(true)?>">
                    <input type="file" class="post-thumb-upload" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Ссылка на пост:</label></div>
                <div class="col-md-8">
                    <span class="col-txt inline-block" style="float: left;">
                        <strong><a target="_blank" id="post-url" href="<?=$post->getAbsPublicUrl()?>" ><?php echo $link; ?></a></strong>
                    </span>
                    <div class="input-link" style="overflow: hidden;">
                        <input type="text" class="inline-block" style="margin-left: 5px;" value="<?=$post->getUrlName()?>" id="blog-url-name">
                    </div>

                    <span class="form-hint-txt">По умолчанию, ссылка будет сгенерирована из названия поста, но, если необходимо, ее можно изменить здесь.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Meta title:</label></div>
                <div class="col-md-8">
                    <input value="<?=$post->getMetaTitle(true)?>" type="text" class="inline-block" id="blog-meta-title">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 l-col"><label class="caption">Meta description:</label></div>
                <div class="col-md-8">
                    <input value="<?=$post->getMetaDescription(true)?>" type="text" class="inline-block" id="blog-meta-desk">
                </div>
            </div>
            <div class="row bw-footer">
                <div class="col-md-4 l-col"><label class="caption">&nbsp;</label></div>
                <div class="col-md-8"><button class="delete-post-btn btn md btn-danger">Удалить пост</button></div>
            </div>
        </div>

        <div class="post-content" style="margin-top: 60px;">
            <div class="post-intro">
                <textarea class="post-title" rows="1" placeholder="Заголовок поста"><?=$post->getTitle(true)?></textarea>
                <textarea class="post-intro-text tiny" rows="1" placeholder="Интро текст."><?=$post->getIntro(true)?></textarea>
            </div>

            <div class="add-block">
                <button data-type="text-only" class="btn btn-default">Блок текста</button>
                <button data-type="img-and-text" class="btn btn-default">Картинка + текст</button>
                <button data-type="img-only" class="btn btn-default">Картинка</button>
                <button data-type="subtitle" class="btn btn-default">Подзаголовок</button>
            </div>

            <? foreach($post->getBlocks() as $block): ?>
                <div data-id="<?=$block->getIdVal()?>" class="pblock" data-type="<?=$block->getType()?>">
                    <? if($block->getType()=='img-and-text'): ?>
                        <div class="pblock-head row">
                            <div class="col-lg-6">
                                <label>IMG title:</label><input type="text" class="image-title" value="<?=$block->getImageTitle(true)?>">
                            </div>
                            <div class="col-lg-6">
                                <label>IMG alt text:</label><input type="text" class="image-alt" value="<?=$block->getImageAlt(true)?>">
                            </div>
                        </div>
                        <? if ($post->getLowcost() === 1):
                            $img = rtrim(str_replace('/i/', '/', $block->getImageUrl(true)), '/'); ?>
                        <div style="background-image: url(<?=$img ?>)" class="head-image">

                        <?else:?>
                        <div style="background-image: url('<?=$block->getImageUrl(true)?>')" class="head-image">
                        <?endif;?>
                            <textarea class="pblock-title" rows="1" placeholder="Заголовок блока"><?=$block->getTitle(true)?></textarea>
                            <div class="gradient"></div>
                        </div>
                        <input type="file" class="block-image-upload" />
                    <? endif; ?>
                    <? if($block->getType()=='img-only'): ?>
                        <div class="pblock-head row">
                            <div class="col-lg-6">
                                <label>IMG title:</label><input type="text" class="image-title" value="<?=$block->getImageTitle(true)?>">
                            </div>
                            <div class="col-lg-6">
                                <label>IMG alt text:</label><input type="text" class="image-alt" value="<?=$block->getImageAlt(true)?>">
                            </div>
                        </div>
                        <? if ($post->getLowcost() === 1):
                            $img = rtrim(str_replace('/i/', '/', $block->getImageUrl(true)), '/'); ?>
                        <div style="background-image: url(<?=$img ?>)" class="head-image">

                        <?else:?>
                        <div style="background-image: url('<?=$block->getImageUrl(true)?>')" class="head-image">
                        <?endif;?>
                            <input type="file" class="block-image-upload" />
                        </div>
                    <?else:?>

                        <textarea class="pblock-text<?if ($block->getType()!='subtitle'):?> tiny<?endif;?>" rows="1" placeholder="Текст блока."><?=$block->getText(true)?></textarea>
                    <? endif; ?>

                    <? if($block->getType()=='img-and-text'): ?>
                        <input class="pblock-url" type="text" value="<?=$block->getUrl()?>" placeholder="Ссылка">
                    <? endif; ?>

                    <div class="post-actions">
                        <button class="btn btn-default up-btn">&uarr;</button><button class="btn btn-default down-btn">&darr;</button><button class="btn btn-default block-delete-btn">Удалить</button>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>

<!-- THUMB CHANGE -->
<div id="thumb-change-modal" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Изменить превью</h4>
            </div>

            <div class="modal-body">
                <p><img style="max-width: 600px" /></p>
            </div>
            <div class="modal-footer">
                <button class="btn md btn-default apply-btn">Сохранить</button><button type="button" class="cancel-btn btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<!-- / THUMB CHANGE -->

<script>

    const body = $('body');

    function initTinymce(selector) {
        tinymce.init({
            content_css:"/css/style.css",
            selector: selector,
            height: 400,
            promotion: false,
            paste_as_text: true,
            keep_styles : false,
            end_container_on_empty_block: false,
            plugins:['lists','link','table'],
            toolbar: [
                { name: 'history', items: [ 'undo', 'redo' ] },
                { name: 'styles', items: [ 'styles' ] },
                { name: 'formatting', items: [ 'bold', 'italic' ] },
                { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
                { name: 'indentation', items: [ 'numlist' , 'bullist', 'outdent', 'indent' ] }
            ],
            images_upload_base_path:"/",
            init_instance_callback:function(editor){
                editor.uploadImages(function(success){

                });

                editor.on('keyup', function (e) {
                    console.log('Element changed:', editor);
                    $(editor.targetElm).val(editor.getContent());
                });

                editor.on('change', function (e) {
                    console.log('Element changed:', editor);
                    $(editor.targetElm).val(editor.getContent());
                });
            },

            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    console.log("input change");
                    var file = this.files[0];
                    console.log({file:file});
                    adminApi.uploadImageForSale(file,function(data){
                        cb(data.url);
                    })
                };
                input.click();
            }
        });
    }

    initTinymce('textarea.tiny');

    var cropper={destroy:function(){}};

    var cropX;
    var cropY;
    var cropWidth;
    var cropHeight;

    var upload_block=0;

    $("#thumb-change-modal").find(".apply-btn").click(function(){
        console.log({cropX:cropX,cropY:cropY,cropWidth:cropWidth,minCropBoxHeight:cropHeight});
        if(upload_block==0) {
            adminApi.setBlogPostThumb(post_id, cropX, cropY, cropWidth, cropHeight, function (data) {
                if (data.status === 'save_error')
                    showAlert("Загрузка картинки на Prostobox.com завершилась ошибкой, попробуйте снова");

                $(".post-thumb-preview").attr("src", data.image);
                $("#thumb-change-modal").modal('hide');
            });
        }else{
            adminApi.setBlogPostBlockPicture(upload_block,cropX, cropY, cropWidth, cropHeight, function (data) {
                if (data.status === 'save_error')
                    showAlert("Загрузка картинки на Prostobox.com завершилась ошибкой, попробуйте снова");

                <? if ($post->getLowcost() === 1): ?>
                    $(".pblock[data-id="+upload_block+"] .head-image").css({'background-image':"url("+data.image+")"});
                <? else: ?>
                    $(".pblock[data-id="+upload_block+"] .head-image").css({'background-image':"url('"+data.image+"')"});
                <? endif; ?>
                $("#thumb-change-modal").modal('hide');
            });
        }
    });

    function createCropper(aspectRatio){
        cropper.destroy();
        var cropImg = $("#thumb-change-modal").find("img")[0];
        cropper = new Cropper(cropImg, {
            aspectRatio:aspectRatio,
            responsive: true,
            restore: true,
            viewMode: 3,
            zoomable: false,
            crop: function(e) {
                cropX= Math.round(e.detail.x);
                cropY= Math.round(e.detail.y);
                cropWidth= Math.round(e.detail.width);
                cropHeight= Math.round(e.detail.height);
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
                cropper.setData({width:cropWidth,height:cropHeight});
                cropper.setData({x:cropX,y:cropY});
            }
        });
    }

    let post_id = <?=$post->getIdVal()?>;

    body.on('change', '#selectLang', function () {
        const langId = $(this).val();

        adminApi.setBlogPostLang(post_id, langId, function(){

        });
    });

    $("#post-visibility").change(function(e){
        if(this.checked && !confirm("Вы действительно хотите опубликовать этот пост?")){
            this.checked=false;
            return;
        }
        var visible=this.checked?1:0;

        adminApi.setBlogPostVisible(post_id,visible,function(){
            if(visible) {
                showAlert('Пост опубликован!', 'success')
            }else{
                showAlert('Пост скрыт.', 'success')
            }
        });
    });

    function showButtons() {
        $(".up-btn,.down-btn").show();
        $(".pblock:first .up-btn").hide();
        $(".pblock:last .down-btn").hide();
    }
    showButtons();

    $(".up-btn").click(function(){
        var $pblock=$(this).closest('.pblock');
        var block_id=$pblock.attr('data-id');
        adminApi.moveBlogPostBlockUp(block_id,function(){

            var text_elem = $pblock.find('.pblock-text');
            var id = text_elem.attr('id');
            var tinymceEditor = tinymce.get(id);

            if (tinymceEditor) tinymceEditor.remove();

            var $upBlock=$pblock.prev('.pblock');
            $pblock.insertBefore($upBlock);

            if (tinymceEditor) initTinymce('#' + id);

            showButtons();
        });
    });

    $(".down-btn").click(function(){
        var $pblock=$(this).closest('.pblock');
        var block_id=$pblock.attr('data-id');
        adminApi.moveBlogPostBlockDown(block_id,function(){
            var text_elem = $pblock.find('.pblock-text');
            var id = text_elem.attr('id');
            var tinymceEditor = tinymce.get(id);

            if (tinymceEditor) tinymceEditor.remove();

            var $downBlock=$pblock.next('.pblock');
            $pblock.insertAfter($downBlock);

            if (tinymceEditor) initTinymce('#' + id);

            showButtons();
        });
    });

    timerChangeFunction.addHandler($("#blog-meta-desk")[0],function(input){
        adminApi.setBlogMetaDescription(post_id,$(input).val(),function(){
            setSaved($(input));
        });
    });

    timerChangeFunction.addHandler($("#blog-meta-title")[0],function(input){
        adminApi.setBlogMetaTitle(post_id,$(input).val(),function(){
            setSaved($(input));
        });
    });

    timerChangeFunction.addHandler($('.post-title')[0],function(textarea){
        if(textarea.value=='') return;
        adminApi.setBlogPostTitle(post_id,$(textarea).val(),function(data){
            setSaved($('.post-title'));
            $("#blog-url-name").val(data.url_name);
        });
    });

    timerChangeFunction.addHandler(document.getElementById('blog-url-name'),function(input){
        if(input.value=='') return;
        adminApi.setBlogPostUrlName(post_id,input.value,function(data){
            console.log("TADA");
            setSaved($(input));
            $("#post-url").attr("href",data.url);
        },function(){
            showAlert("Пост с таким URL уже существует.");
        });
    });

    timerChangeFunction.addHandler($('.post-intro-text')[0],function(textarea){
        adminApi.setBlogPostIntro(post_id,textarea.value,function(){
            setSaved($('.textarea'));
        })
    });

    $(".image-title").on("input",function(){
        const block_id=$(this).closest('.pblock').attr('data-id');
        adminApi.setBlogPostBlockImageTitle(block_id,this.value,()=>{
            setSaved($(this));
        })
    });

    $(".image-alt").on("input",function(){
        const block_id=$(this).closest('.pblock').attr('data-id');
        adminApi.setBlogPostBlockImageAlt(block_id,this.value,()=>{
            setSaved($(this));
        })
    });

    $(".pblock-title").each(function(){
        timerChangeFunction.addHandler(this,function(element){
            var block_id=$(element).closest('.pblock').attr('data-id');
            adminApi.setBlogPostBlockTitle(block_id,element.value,function(){
                setSaved($(element));
            })
        });
    });

    $(".pblock-text").each(function(){
        timerChangeFunction.addHandler(this,function(element){
            var block_id=$(element).closest('.pblock').attr('data-id');
            adminApi.setBlogPostBlockText(block_id,element.value,function(){
                setSaved($(element));
            })
        });
    });

    $(".pblock-url").each(function(){
        timerChangeFunction.addHandler(this,function(element){
            var block_id=$(element).closest('.pblock').attr('data-id');
            adminApi.setBlogPostBlockUrl(block_id,element.value,function(){
                setSaved($(element));
            })
        });
    });

    $(".add-block button").click(function(){
        var type=$(this).attr('data-type');
        adminApi.createBlogPostBlock(post_id,type,function(){
           location.reload();
        });
    });

    $(".block-delete-btn").click(function(){
        var block_id=$(this).closest('.pblock').attr('data-id');
        if(confirm('Вы действительно хотите удалить этот блок?')) {
            adminApi.removeBlogPostBlock(block_id, function () {
                location.reload();
            });
        }
    });

    $(".post-thumb-upload").change(function(){
        var image=this.files[0];
        if(typeof (image) !='undefined'){
            if(image.type=='image/jpeg' || image.type=='image/png'){
                adminApi.uploadImageForResize(image,function(data){
                    $("#thumb-change-modal").find("img").attr("src",data.image);
                    $("#thumb-change-modal").modal("show");
                    createCropper(307/148);
                    upload_block=0;
                });
            }else{
                showAlert("Можно загружать только .PNG или .JPG изображения");
            }
        }
    });

    $(".block-image-upload").change(function(){
        var image=this.files[0];
        var block_id=$(this).closest('.pblock').attr('data-id');
        if(typeof (image) !='undefined'){
            if(image.type=='image/jpeg' || image.type=='image/png'){
                adminApi.uploadImageForResize(image,function(data){
                    $("#thumb-change-modal").find("img").attr("src",data.image);
                    $("#thumb-change-modal").modal("show");
                    createCropper(600/300);
                    upload_block=block_id;
                });
            }else{
                showAlert("Можно загружать только .PNG или .JPG изображения");
            }
        }
    });

    $(".delete-post-btn").click(function(){
        if(confirm('Вы действительно хотите удалить этот пост?')){
            adminApi.deletePostBlog(post_id,function(){
                location.href='/admin-room/blog';
            });
        }
    });

    $(".categories-list input").on("change",function(){
        const categories=[];
        $(".categories-list input:checked").each(function(){
            categories.push($(this).attr("data-id"));
        });
        adminApi.setBlogPostCategories(post_id,categories);
    });

    $(".add-tag").click(function(){
        const tag=$(".tags").val();
        $(".tags").val("");
        for(let i=0;i<$(".selected-tags li").length;i++){
            const li=$(".selected-tags li")[i];
            if($(li).find("label").text()===tag) return;
        }

        $(".selected-tags").append('<li><label>'+tag+'</label><div class="action-btns"><button class="delete-tag" >Удалить тег</button></div></li>');
        saveTags();
    });

    $(".selected-tags").on('click','.delete-tag',function(){
        const $li=$(this).closest("li");
        $li.remove();
        saveTags();
    });


    function saveTags(){
        let tags="";
        $(".selected-tags li label").each(function(){
            tags=tags+$(this).text()+",";
        });
        adminApi.setBlogPostTags(post_id,tags,()=>{
            setSaved($(this));
        });
    }

    $(".search-tags").on("click","li",function(){
        $(".tags").val($(this).text());
        $(".add-tag").click();
    });

    let sth;

    $(".tags").on("input",function(){
        $(".search-tags").hide().html('');
        if($(this).val()==='') return;
        clearTimeout(sth);
        sth=setTimeout(()=>{
            adminApi.findTags($(this).val(),ret=>{
                let show=false;
                if(ret.status==="ok"){
                    ret.tags.forEach(tag=>{
                        show=true;
                        $(".search-tags").append('<li>'+tag+'</li>');
                    });
                }
                if(show) $(".search-tags").show();
            });
        },500);
    });

</script>
