/**
 Инициализация сортировки категорий
 */
window.blogCategoriesSortableSetup = function () {

    if ($('.node:not(.table-sortable-init)').length > 0) {

        $('.node:not(.table-sortable-init)').each(function (key, elem) {

            $(elem).addClass('table-sortable-init');

            Sortable.create(elem, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onEnd: function (evt) {

                    let item = $(evt.item),
                        ids = '',
                        data = new FormData();

                    const node = item.closest('.node');

                    data.append('node', node.attr('data-id'));

                    // Устанавливаем перемещенному элементу текущий уровень
                    item.attr('data-level', node.attr('data-level'));

                    // Формируем массив id элементов уровня
                    node.find('[data-level='+node.attr('data-level')+']').each(function (key, element) {
                        ids = ids + $(element).attr('data-id') + ',';
                    });

                    data.append('ids', ids);

                    requestAjax(item.closest('.menu-tree').attr('data-url'), data, function (response){
                         console.log(response);
                     }, function (error, i, code ){
                        console.log('error-' + error + ' i-' + i + ' code-' + code);
                    });

                }

            });
        });
    }
}

blogCategoriesSortableSetup();
