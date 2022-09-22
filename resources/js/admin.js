const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");
if (prefersDark.matches && !document.cookie.includes('grand_backend_theme=light')) {
    ['light', 'dark'].map(cl => document.body.classList.toggle(cl));
}

document.querySelectorAll(".btn-theme").forEach(item => {
    item.addEventListener("click", function() {
        ['light', 'dark'].map(cl => document.body.classList.toggle(cl));
        const theme = document.body.classList.contains("dark") ? "dark" : "light";
        document.cookie = "grand_backend_theme=" + theme + ";path=/";
    });
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

flatpickr('.flatpickr-input', {
    "locale": "ru"
});

$(document).ready(function () {
    $('.row-delete').on('click', function () {
        const text = $(this).closest('tr').find('.js-title').text(),
            modalDelete = new bootstrap.Modal(document.getElementById('confirmDelete'), {});

        $('#confirmDelete .items').text(text);
        $('#confirmDelete form').attr('action', $(this).data('action'));

        modalDelete.show();
    });

    $('.js-delete').on('click', function () {
        const text = $(this).closest('.menu-tree-item').find('.menu-tree-text').text(),
            modalDelete = new bootstrap.Modal(document.getElementById('confirmDelete'), {});

        $('#confirmDelete .items').text(text);
        $('#confirmDelete form').attr('action', $(this).attr('href'));

        modalDelete.show();
        return false;
    });

    $(document).on('click','.js-add-block',function(){
        const template = document.querySelector($(this).attr('data-tpl')),
              el = template.content.cloneNode(true),
              target = $(this).closest('.items-block').find('.block-element').last();
        let id = $(this).data('id'),
            str;

        $(el).insertAfter(target);

        id = id + 1;
        $(this).data('id', id);

        $(this).closest('.items-block').find('input').each(function (index, element) {
            str = $(this).attr('name').replace('--id--', id);
            $(this).attr('name', str);
        });
    });
    $(document).on('click','.js-delete-block',function(){
        $(this).closest('.block-element').remove();
    });

    $(document).on('click', '.js-add-text-new', function() {
        const template = document.querySelector($(this).attr('data-tpl')),
            el = template.content.cloneNode(true),
            dataId = $('#card-tools-more');
        let id = dataId.data('id'),
            item;

        $('.new-block').removeClass('new-block');
        $(el).find('.js-block').addClass('new-block');

        $(el).insertBefore(dataId);

        $('.new-block .js-repl').each( function() {
            item = $(this);
            $.each(this.attributes, function(index, attribute) {
                if(attribute.value.indexOf('xxx') >= 0) {
                    item.attr(attribute.name,attribute.value.replace('xxx', id));
                }
            });
        });
        summernoteInit();

        id = id + 1;
        dataId.removeData('id').attr('data-id', id);
    });

    $(document).on('click','.block-delete',function(){
        $(this).closest('.js-block').remove();
    });

    $(document).on('click','.js-help',function(){
        if($(this).hasClass('active')) {
            $('.help-text').show();
        } else {
            $('.help-text').hide();
        }
    });
    function summernoteInit() {
        $('.summernote').summernote({
            lang: 'ru-RU',
            height: 300,
            callbacks: {
                /*
                 * При вставке изображения загружаем его на сервер
                 */
                onImageUpload: function (images) {
                    for (var i = 0; i < images.length; i++) {
                        uploadImage(images[i], this);
                    }
                },
                /*
                 * При удалении изображения удаляем его на сервере
                 */
                //     onMediaDelete: function(target) {
                //         removeImage(target[0].src);
                //     }
            }
        });
    }
    summernoteInit();

    $(document).on('submit','#edit-form',function(e) {
        let id,
            fl = true;

        $('.is-invalid').removeClass('is-invalid');

        $('input, select, textarea').each(function () {
            if($(this).attr('required') === 'required' && $(this).val() === '') {
                if($(this).hasClass('summernote') && $(this).summernote('isEmpty')) {
                    $(this).closest('.form-group').addClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
                id = $(this).closest('.tab-pane').attr('aria-labelledby');
                $('#'+id).addClass('is-invalid');
                $('#id-edit-form').addClass('is-invalid');
                fl = false;
            }
        });

        return fl;
    });
    $(document).on('change','.is-invalid',function() {
        if($(this).val() !== '') {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $(document).on('summernote.change','.form-group.is-invalid .summernote',function() {
        $(this).closest('.form-group').removeClass('is-invalid');
    });

    // $(document).on('click','.opt-delete',function(){
    //     const id = $(this).data('id'),
    //           target = $(this).closest('table').find('.option-end');
    //
    //     if (id >= 0) {
    //         $(target).before('<input type="hidden" name="opt[delete][' + id + ']">');
    //     }
    //    $(this).closest('tr').remove();
    // });
    //
    // $(document).on('change','.property-kind2',function(){
    //     if ($(this).val() === 'select') {
    //         $('.options-input').removeClass('hidden');
    //     } else {
    //         $('.options-input').addClass('hidden');
    //     }
    // });
    // $("body").on("click", ".app-menu .menu", function(ev) {
    //     $(".main-sidebar").addClass("open");
    //     $(".app-menu").addClass("open");
    // });
    //
    // $("body").on("click", ".app-menu.open .menu", function(ev) {
    //     $(".main-sidebar").removeClass("open");
    //     $(".app-menu").removeClass("open");
    // });
    // $("#address").suggestions({
    //     token: "20fab7aea6655df01cdff782a426685673d9eb70",
    //     type: "ADDRESS",
    //     /* Вызывается, когда пользователь выбирает одну из подсказок */
    //     onSelect: function (suggestion) {
    //         let city = '';
    //         if (suggestion['data']['region_with_type'] !== null) {
    //             $('#region').val(suggestion['data']['region_with_type']);
    //         }
    //         if (suggestion['data']['area_with_type'] !== null) {
    //             city = city + ' ' + suggestion['data']['area_with_type'];
    //         }
    //         if (suggestion['data']['city_with_type'] !== null) {
    //             city = city + ' ' + suggestion['data']['city_with_type'];
    //         }
    //         if (suggestion['data']['settlement_with_type'] !== null) {
    //             city = city + ' ' + suggestion['data']['settlement_with_type'];
    //         }
    //         $('#city').val(city);
    //         if (suggestion['data']['street_with_type'] !== null) {
    //             $('#street').val(suggestion['data']['street_with_type']);
    //         }
    //         if (suggestion['data']['house'] !== null) {
    //             $('#house').val(suggestion['data']['house_type'] + ' ' + suggestion['data']['house']);
    //         }
    //         if (suggestion['data']['block'] !== null) {
    //             $('#corpus').val(suggestion['data']['block_type'] + ' ' + suggestion['data']['block']);
    //         }
    //         if (suggestion['data']['flat'] !== null) {
    //             $('#flat').val(suggestion['data']['flat_type'] + ' ' + suggestion['data']['flat']);
    //         }
    //     }
    // });
});

