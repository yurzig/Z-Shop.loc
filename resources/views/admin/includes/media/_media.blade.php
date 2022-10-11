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
{{--        <img src="{{ imgSmall($media->link) }}" height="60">--}}
        <span class="item-label header-label">{{ $media->title }}</span>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete" title="Удалить этот блок"></div>
        </div>
    </div>
    <div id="media-group-{{ $j }}" class="card-block collapse row js-repl{{ $collapsed === 'collapsed' ? '' : ' show'}}"
         role="tabpanel">
        <div class="col-xl-6">

            <div class="form-group media-preview">
                <input type="hidden" class="js-repl" name="medi[{{ $j }}][id]" value="{{ $media->id }}">
                <input class="fileupload js-img js-repl" type="file" name="medi[{{ $j }}][imagefile]">
                <img class="item-preview" src="{{ asset($media->link) }}" alt="">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Название</label>
                <div class="col-sm-8">
                    <input class="form-control js-repl" type="text"
                           name="medi[{{ $j }}][title]"
                           placeholder="Название картинки"
                           value="{{ old('title', $media->title) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Тип</label>
                <div class="col-sm-8">
                    <select class="form-select item-status js-repl" required="required" name="medi[{{ $j }}][placement]">
{{--                    @foreach(\App\Models\Media::PLACEMENT as $key => $optionItem)--}}
{{--                        <option value="{{ $key }}"{{ $media->placement === $key ? ' selected' : ''}}>{{ $optionItem }}</option>--}}
{{--                    @endforeach--}}
                    </select>
                </div>
            </div>
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Статус</label>
                <div class="col-sm-8">
                    <select class="form-select item-status js-repl" required="required" name="medi[{{ $j }}][status]">
                        <option value="1"{{ $media->status === '1' ? ' selected' : ''}}>Активна</option>
                        <option value="0"{{ $media->status === '0' ? ' selected' : ''}}>Скрыта</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
