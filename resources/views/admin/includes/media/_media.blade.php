<div class="group-item card js-block">
    <div class="card-header header">
        <div class="card-tools-start">
            <div class="btn btn-card-header act-show fa show {{ $collapsed }} js-repl"
                 title="Скрыть/Показать"
                 data-bs-target="#media-group-{{ $j }}"
                 data-bs-toggle="collapse"
                 aria-controls="media-group-{{ $j }}"
                 aria-expanded="{{ $collapsed === 'collapsed' ? 'false' : 'true'}}"></div>
        </div>
        <div class="card-tools-center w-100">
            <img src="{{ imgSmall($media->link, $media->object) }}" height="60" class="mx-3" alt="">
            <span class="item-label header-label" style="position: absolute; left: 180px">{{ $media->title }}</span>
        </div>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete" title="Удалить этот блок"></div>
        </div>
    </div>
    <div id="media-group-{{ $j }}" class="card-block collapse row js-repl{{ $collapsed === 'collapsed' ? '' : ' show'}}"
         role="tabpanel">
        <div class="col-xl-6">

            <div class="form-group media-preview">
                <input type="hidden" class="js-repl" name="media[{{ $j }}][id]" value="{{ $media->id }}">
                <input class="js-img js-repl" type="file" name="media{{ $j }}">
                <img src="{{ imgLarge($media->link, $media->object) }}" alt="">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Название</label>
                <div class="col-sm-8">
                    <input class="form-control js-repl" type="text"
                           name="media[{{ $j }}][title]"
                           placeholder="Название картинки"
                           value="{{ old('media[' . $j . '][title]', $media->title) }}">
                </div>
            </div>
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Место размещения</label>
                <div class="col-sm-8">
                    <select class="form-select js-repl" required="required" name="media[{{ $j }}][placement]">
                        <option value=''>Расположение картинки</option>
                    @foreach($placements as $key => $optionItem)
                        <option value="{{ $key }}"{{ $media->pivot->placement === $key ? ' selected' : ''}}>
                            {{ $optionItem }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
