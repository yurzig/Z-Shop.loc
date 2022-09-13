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
// document.querySelectorAll(".admin .main-sidebar .sidebar-menu > li:not(.none)").forEach(function(item) {
//     let active = document.querySelector(".admin .main-sidebar .sidebar-menu > li.active");
//     item.addEventListener("mouseenter", function(ev) {
//         if(item !== active && ev.target.previousElementSibling) {
//             ev.target.previousElementSibling.classList.add("before");
//         }
//         if(item !== active && ev.target.nextElementSibling) {
//             ev.target.nextElementSibling.classList.add("after");
//         }
//     });
//     item.addEventListener("mouseleave", function(ev) {
//         if(item !== active && ev.target.previousElementSibling) {
//             ev.target.previousElementSibling.classList.remove("before");
//         }
//         if(item !== active && ev.target.nextElementSibling) {
//             ev.target.nextElementSibling.classList.remove("after");
//         }
//     });
// });
$(document).ready(function () {
     // $('.flatpickr-input').flatpickr({"locale": "ru"});

    // $('.row-delete').on('click', function () {
    //     const text = $(this).closest('tr').find('.js-title').text(),
    //         modalDelete = new bootstrap.Modal(document.getElementById('confirmDelete'), {});
    //
    //     $('#confirmDelete .items').text(text);
    //     $('#confirmDelete form').attr('action', $(this).data('action'));
    //
    //     modalDelete.show();
    // });

    $(document).on('click','.js-option',function(){
        const template = document.querySelector($(this).attr('data-tpl')),
              el = template.content.cloneNode(true),
              target = $(this).closest('table').find('.option-end');
        let count = $(target).data('count');
        $(el).insertBefore(target);

        count = count + 1;
        $(this).closest('table').find('.option-key').each(function (index, element) {
            if ($(this).attr('name') === '') {
                $(this).attr('name', 'opt[' + count + '][key]');
            }
        });
        $(this).closest('table').find('.option-value').each(function (index, element) {
            if ($(this).attr('name') === '') {
                $(this).attr('name', 'opt[' + count + '][val]');
            }
        });
        $(target).removeData('count');
        $(target).attr('data-count',count);
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

