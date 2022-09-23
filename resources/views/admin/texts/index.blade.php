<?php
$fields = [
    ['name' => 'Id',              'dbName' => 'id',         'type' => 'text',   'op' => '=',    'class' => ''],
    ['name' => 'Тип',             'dbName' => 'type',       'type' => 'select', 'op' => '=',    'class' => ''],
    ['name' => 'Наименование',    'dbName' => 'title',      'type' => 'text',   'op' => 'like', 'class' => ' class=js-title'],
    ['name' => 'Текст',           'dbName' => 'content',    'type' => 'text',   'op' => 'like', 'class' => ''],
    ['name' => 'Дата создания',   'dbName' => 'created_at', 'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Дата обновления', 'dbName' => 'updated_at', 'type' => 'date',   'op' => '=',    'class' => ' class="flatpickr-input"'],
    ['name' => 'Редактор',        'dbName' => 'editor',     'type' => 'text',   'op' => '=',    'class' => ''],
];
$type_items = $types;
$type_options = '<option value="">Все</option>';
foreach($types as $key => $typeItem) {
    if(is_array($filter) && !empty($filter) && $filter['val']['type'] == $key) {
        $type_options .= "<option value='$key' selected='selected'>$typeItem</option>";
    } else {
        $type_options .= "<option value='$key'>$typeItem</option>";
    }
}
$pageName = 'Тексты';
$page = 'admin.texts.';
?>
@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    @include('admin.includes._result_messages')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3">
        <div class="list">
            <table class="list-items table table-hover table-striped">
                <thead class="list-header">
                <tr>
                    @foreach($fields as $field)
                        @if(in_array($field['dbName'], $columns))
                            <th{{ $field['class'] }}>
                                <a href="{{ route($page . 'sort', ['order' => $field['dbName']]) }}"
                                   title="Направление сортировки"
                                   @if($field['dbName'] === $sort[0])
                                       class="sort-{{ $sort[1] }}"
                                    @endif
                                >
                                    {{ $field['name'] }}
                                </a>
                            </th>
                        @endif
                    @endforeach
                    <th class="actions">
                        <a class="btn fa act-add" tabindex="1"
                           href="{{ route($page . 'create') }}"
                           title="Добавить новую запись">
                        </a>
                        <button type="button" class="btn act-columns fa"
                                data-bs-toggle="modal"
                                data-bs-target="#columns-form"
                                title="Колонки">
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="list-search">
                    <form method="POST" action="{{ route($page . 'search') }}">
                        @csrf
                        @foreach($fields as $field)
                            @if(!in_array($field['dbName'], $columns))
                                @continue
                            @endif
                            <td{{ $field['class'] }}>
                                <input type="hidden" name="filter[op][{{ $field['dbName'] }}]" value="{{ $field['op'] }}">
                                @switch($field['type'])
                                    @case('select')
                                        <select class="form-select" name="filter[val][{{ $field['dbName'] }}]">
                                            @php $var = $field['dbName'] . '_options';
                                         echo $$var
                                            @endphp
                                        </select>
                                        @break
                                    @case('switch')
                                        <div class="form-check form-switch">
                                            <input type="checkbox"
                                                   name="filter[val][{{ $field['dbName'] }}]"
                                                   class="form-check-input"
                                                   value="1"
                                                {{ (isset($filter['val'][$field['dbName']]) &&
                                                    $filter['val'][$field['dbName']]
                                                    ) ? ' checked' : '' }}>
                                        </div>
                                        @break
                                    @case('date')
                                        <input class="form-control flatpickr-input" type="text"
                                               name="filter[val][{{ $field['dbName'] }}]"
                                               value="{{ $filter['val'][$field['dbName']] ?? '' }}">
                                        @break
                                    @case('text')
                                        <input class="form-control" type="{{ $field['type'] }}"
                                               name="filter[val][{{ $field['dbName'] }}]"
                                               value="{{ $filter['val'][$field['dbName']] ?? '' }}">
                                        @break
                                @endswitch
                            </td>
                        @endforeach
                        <td class="actions">
                            <button type="submit" class="btn act-search fa"
                                    name="action"
                                    value="search"
                                    title="Поиск">
                            </button>
                            <a class="btn fa act-reset" tabindex="1"
                               href="{{ route($page . 'reset') }}"
                               title="Сброс фильтра">
                            </a>
                        </td>
                    </form>
                </tr>
                @foreach($items as $item)
                    <tr class="list-item">
                        @foreach($fields as $field)
                            @if(!in_array($field['dbName'], $columns))
                                @continue
                            @endif

                            @php
                                switch ($field['type']) {
                                    case 'select':
                                        $dbName = $field['dbName'];
                                        $key = $item->$dbName;
                                        $arrayName = $dbName . '_items';
                                        $value = $$arrayName[$key];
                                        break;
                                    case 'switch':
                                        $dbName = $field['dbName'];
                                        $checked = '';
                                        if($item->$dbName) { $checked = ' checked'; }
                                        $value = '<div class="form-check form-switch">
                                                      <input type="checkbox" class="form-check-input"' . $checked . ' disabled>
                                                  </div>';
                                        break;
                                    case 'date':
                                        $dbName = $field['dbName'];
                                        $value = \Carbon\Carbon::parse($item->$dbName)->format('Y-m-d');
                                        break;
                                    case 'text':
                                        $dbName = $field['dbName'];
                                        $value = $item->$dbName;
                                        break;
                                }
                            @endphp
                            <td{!! $field['class'] !!}>
                                {!! $value !!}
                            </td>
                        @endforeach
                        <td class="actions">
                            <a class="btn act-edit fa"
                               data-bs-toggle="tooltip"
                               data-bs-html="true"
                               href="{{ route($page . 'edit', $item) }}"
                               title="Редактировать.{{ $item->textable->count() > 0 ? ' <b>Внимание!</b> Есть связанные объекты (' . $item->textable->count() . ') ' : '' }}">
                            </a>
                            <button type="button" class="btn act-delete fa row-delete"
                                    data-bs-toggle="tooltip"
                                    data-bs-html="true"
                                    data-action="{{ route($page . 'destroy', $item) }}"
                                    title="Удалить.{{ $item->textable->count() > 0 ? ' <b>Внимание!</b> Есть связанные объекты (' . $item->textable->count() . ') ' : '' }}">
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @if($items->total() > $items->count())
    <div class="list-page d-flex justify-content-center">
        {{ $items->onEachSide(2)->links() }}
    </div>
    @endif

<!-- Modal -->
    @include('admin.includes._modal_columns', ['action' => route($page . 'columns')])
    @include('admin.includes._modal_delete')
@endsection
