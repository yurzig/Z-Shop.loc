<div class="modal fade" id="columns-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Колонки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ $action }}">
                @csrf
                <div class="modal-body">
                    <ul class="column-list">
                        @foreach($fields as $field)
                        <li class="column-item">
                            <label tabindex="tabindex">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="field[]"
                                       {{ in_array($field['dbName'], $columns) ? ' checked' : ''}}
                                       value="{{ $field['dbName'] }}">
                                {{ $field['name'] }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
