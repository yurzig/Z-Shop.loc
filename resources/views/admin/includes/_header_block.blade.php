<div class="item-actions my-1">
    <a class="btn btn-secondary js-help" role="button" data-bs-toggle="button" aria-pressed="false" title="Подсказки" href="#">?</a>
    <a class="btn btn-secondary act-cancel" title="Переход на список" href="{{ route($page . 'index') }}">
        Список
    </a>
    <div class="btn-group">
        <button type="submit" form="edit-form" class="btn btn-primary act-save" title="Сохранить запись" name="action" value="close">Сохранить</button>
        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu">
            <li><button type="submit" form="edit-form" class="btn btn-primary w-100" name="action" value="close">и закрыть</button></li>
            <li><button type="submit" form="edit-form" class="btn btn-primary w-100" name="action" value="edit">и редактировать</button></li>
            <li><button type="submit" form="edit-form" class="btn btn-primary w-100" name="action" value="new">и новый</button></li>
        </ul>
    </div>
</div>
