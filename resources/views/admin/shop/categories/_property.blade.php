<div class="group-item card js-block">
    <div id="item-property-group-item-{{ $i }}" class="card-header header js-repl">
        <div class="card-tools-start">
            <div class="btn btn-card-header act-show fa show{{ $collapsed === 'collapsed' ? ' collapsed' : ''}} js-repl"
                 title="Скрыть.Показать"
                 data-bs-target="#item-property-group-data-{{ $i }}"
                 data-bs-toggle="collapse"
                 aria-controls="item-property-group-data-{{ $i }}"
                 aria-expanded="{{ $collapsed === 'collapsed' ? 'false' : 'true'}}"></div>
        </div>
        @php   $f = $property->filter ? '(Фильтр) ' : '';
               $title = $f . $property->title; @endphp
        <span class="item-label header-label">{{ $title }}</span>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete"
                 data-id="{{ $property->id }}"
                 data-model="prop"
                 title="Удалить этот блок"></div>
        </div>
    </div>
    <div id="item-property-group-data-{{ $i }}" class="card-block collapse row js-repl{{ $collapsed === 'collapsed' ? '' : ' show'}}"
         aria-labelledby="item-property-group-item-{{ $i }}" role="tabpanel">
        <div class="col-xl-6">

            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Название</label>
                <div class="col-sm-8">
                    <input type="hidden" class="js-repl" name="prop[{{ $i }}][id]" value="{{ $property->id }}">
                    <input class="form-control js-repl" type="text"
                           name="prop[{{ $i }}][title]"
                           placeholder="Название свойства"
                           value="{{ $property->title }}"
                           required="required">
                </div>
            </div>
            <div class="form-group row">
                <label id="switch-filter" class="col-sm-4 form-control-label">Фильтр</label>
                <div class="col-sm-8 form-check form-switch">
                    <input type="checkbox"
                           name="prop[{{ $i }}][filter]"
                           id="switch-filter"
                           class="form-check-input"
                           {{ $property->filter ? ' checked' : '' }}>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Тип</label>
                <div class="col-sm-8">
                    <select class="form-select item-status property-kind js-repl" required="required" name="prop[{{ $i }}][type]">
                        <option value="text"{{ $property->type === 'text' ? ' selected' : '' }}>Текст</option>
                        <option value="select"{{ $property->type === 'select' ? ' selected' : '' }}>Список</option>
                        <option value="yesNo"{{ $property->type === 'yesNo' ? ' selected' : '' }}>Да/нет</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-xl-6">
            <div class="form-group row options-input select-input{{ $property->type === 'select' ? '' : ' hidden'}}">

                <table class="item-config table">
                    <thead>
                    <tr>
                        <th class="config-row-key"><span>Опция</span></th>
                        <th class="actions">
                            <div class="btn act-add fa js-add-option" data-tpl="#option"></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <template id="option">
                        <tr class="config-item">
                            <td class="config-row-key">
                                <input class="form-control option-key" type="text" name="">
                            </td>
                            <td class="action">
                                <div class="btn act-delete fa opt-delete" title="Удалить этот элемент"></div>
                            </td>
                        </tr>
                    </template>
                    @if(isset($options))
                    @foreach($options as $key => $option)
                        <tr class="config-item">
                            <td class="config-row-key">
                                <input type="hidden" name="prop[{{ $i }}][opt][{{ $key }}][id]" value="{{ $option->id }}">
                                <input class="form-control option-key" type="text"
                                       name="prop[{{ $i }}][opt][{{ $key }}][key]"
                                       value="{{ $option->title }}">
                            </td>
                            <td class="action">
                                <div class="btn act-delete fa option-delete" data-id="{{ $option->id }}" title="Удалить этот элемент"></div>
                            </td>
                        </tr>

                    @endforeach
                    @endif
                    <tr class="option-end js-repl" data-prop="{{ $i }}" data-count="{{ isset($options) ? $options->count() : 1}}"></tr>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
