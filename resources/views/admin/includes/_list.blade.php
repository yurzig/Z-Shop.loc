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
            <form method="POST" action="{{ route($page . 'filter') }}">
                @csrf
                @foreach($fields as $field)
                    @if(!in_array($field['dbName'], $columns))
                        @continue
                    @endif
                    <td{{ $field['class'] }}>
                        <input type="hidden" name="filters[op][{{ $field['dbName'] }}]" value="{{ $field['op'] }}">

                        @switch($field['type'])
                            @case('switch')
                            @case('select')
                                <select class="form-select" name="filters[val][{{ $field['dbName'] }}]">
                                    @php $var = $field['dbName'] . '_options';
                                         echo $$var
                                    @endphp
                                </select>
                                @break
{{--                                <div class="form-check form-switch">--}}
{{--                                    <input type="checkbox"--}}
{{--                                           name="filters[val][{{ $field['dbName'] }}]"--}}
{{--                                           class="form-check-input"--}}
{{--                                           value="1"--}}
{{--                                           @checked((isset($filter['val'][$field['dbName']]) && $filter['val'][$field['dbName']]))--}}
{{--                                </div>--}}
{{--                                @break--}}
                            @case('date')
                                <input class="form-control flatpickr-input" type="text"
                                       name="filters[val][{{ $field['dbName'] }}]"
                                       value="{{ $filter['val'][$field['dbName']] ?? '' }}">
                                @break
                            @case('text')
                                <input class="form-control" type="{{ $field['type'] }}"
                                       name="filters[val][{{ $field['dbName'] }}]"
                                       value="{{ $filter['val'][$field['dbName']] ?? '' }}">
                                @break
                        @endswitch
                    </td>
                @endforeach
                <td class="actions">
                    <button type="submit" class="btn act-filter fa"
                            name="action"
                            value="filter"
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
                            $value = $item->$dbName ? \Carbon\Carbon::parse($item->$dbName)->format('Y-m-d') : '';
                            break;
                        case 'text':
                            $dbName = $field['dbName'];
                            $value = $item->$dbName;
                            break;
                    }
                @endphp
            <td{!! $field['class'] === ' class=js-title' ? ' class=js-title' : '' !!}>
                {!! $value !!}
            </td>
            @endforeach
            <td class="actions">
                <a class="btn act-edit fa"
                   href="{{ route($page . 'edit', $item) }}"
                   title="Редактировать">
                </a>
                <button type="button" class="btn act-delete fa row-delete"
                        data-action="{{ route($page . 'destroy', $item) }}"
                        title="Удалить эту запись">
                </button>
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>
</div>
