@php
$typeOptions = '';
foreach ($types as $key => $type) {
    $typeOptions .= "<option value='$key'>$type</option>";
 }
@endphp
<div class="group-item card js-block">
    <div class="card-header header js-repl">
        <div class="card-tools-start">
            <div class="btn btn-card-header act-show fa show js-repl"
                 title="Скрыть/Показать"
                 data-bs-target="#text-group-{{ $j }}"
                 data-bs-toggle="collapse"
                 aria-controls="text-group-{{ $j }}"
                 aria-expanded="true"></div>
        </div>
        <span class="item-label header-label">Новый</span>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete" title="Удалить этот блок"
            ></div>
        </div>
    </div>
    <div id="text-group-{{ $j }}" class="card-block collapse row js-repl show" role="tabpanel">
        <div class="col-xl-12">
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Тип</label>
                <div class="col-sm-3">
                    <input type="hidden" class="js-repl" name="text[{{ $j }}][id]" value="{{ $text->id }}">
                    <select class="form-select item-status js-repl" name="text[{{ $j }}][type]" required="required">
                        {!! $typeOptions !!}
                    </select>
                    <div class="col-sm-12 help-text">{{ $help['type'] }}</div>
                </div>
            </div>
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Наименование</label>
                <div class="col-sm-8">
                    <input class="form-control js-repl" type="text"
                           name="text[{{ $j }}][title]"
                           placeholder="Наименование текста"
                           value="{{ old('text[' . $j . '][title]') }}"
                           required="required">
                    <div class="col-sm-12 help-text">{{ $help['title'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="form-group">
                <div class="col-sm-12 help-text">{{ $help['content'] }}</div>
                <textarea name="text[{{ $j }}][content]" required="required"
                          class="form-control js-repl item-content summernote">{{ old('text[' . $j . '][content]') }}</textarea>
            </div>
        </div>
    </div>
</div>
