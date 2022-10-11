@php
    $type = '';
    if(isset($text->type)) {
        $type = $types[$text->type];
    }
@endphp
<div class="group-item card js-block">
    <div class="card-header header">
        <div class="card-tools-start">
            <div class="btn btn-card-header act-show fa show {{ $collapsed }} js-repl"
                 title="Скрыть/Показать"
                 data-bs-target="#text-group-{{ $j }}"
                 data-bs-toggle="collapse"
                 aria-controls="text-group-{{ $j }}"
                 aria-expanded="{{ $collapsed === 'collapsed' ? 'false' : 'true'}}"></div>
        </div>
        <span class="item-label header-label">{{ $type }} | {{ $text->title }}</span>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete" title="Удалить этот блок"></div>
        </div>
    </div>
    <div id="text-group-{{ $j }}" class="card-block collapse row js-repl{{ $collapsed === 'collapsed' ? '' : ' show'}}"
         role="tabpanel">
        <div class="col-xl-12">
            <div class="form-group row">
                <input type="hidden" class="js-repl text-id" name="text[{{ $j }}][id]" value="{{ $text->id }}">
                <label class="col-sm-4 form-control-label">Тип</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-type" disabled value="{{ $type }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Наименование</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-title" disabled value="{{ $text->title }}">
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="form-group text-content mx-3">
                {!! $text->content !!}
            </div>
        </div>
    </div>
</div>
