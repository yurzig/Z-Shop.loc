@php
    $placementOptions = "<option>Расположение картинки</option>";
    foreach ($placements as $key => $placement) {
        $placementOptions .= "<option value='$key'>$placement</option>";
     }
@endphp
<div class="group-item card js-block">
    <div class="card-header header">
        <div class="card-tools-start">
            <div class="btn btn-card-header act-show fa show js-repl"
                 title="Скрыть/Показать"
                 data-bs-target="#media-group-{{ $j }}"
                 data-bs-toggle="collapse"
                 aria-controls="media-group-{{ $j }}"
                 aria-expanded="true"></div>
        </div>
{{--        <img src="{{ imgSmall($media->link) }}" height="60">--}}
        <span class="item-label header-label">Новая картинка</span>
        <div class="card-tools-end">
            <div class="btn btn-card-header act-delete fa block-delete" title="Удалить этот блок"></div>
        </div>
    </div>
    <div id="media-group-{{ $j }}" class="card-block collapse row js-repl show" role="tabpanel">
        <div class="col-xl-6">

            <div class="form-group media-preview">
                <input class="fileupload js-img" type="file" name="imagefile">
                <img id="upload-img" class="item-preview" src="" alt="">

{{--                <input class="fileupload js-img js-repl" type="file" name="media[{{ $j }}][imagefile]">--}}
{{--                <img class="item-preview" src="" alt="">--}}
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group row">
                <label class="col-sm-4 form-control-label">Название</label>
                <div class="col-sm-8">
                    <input class="form-control js-repl" type="text"
                           name="media[{{ $j }}][title]"
                           placeholder="Название картинки"
                           value="">
                </div>
            </div>
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Тип</label>
                <div class="col-sm-8">
                    <select class="form-select item-status js-repl" required="required" name="media[{{ $j }}][placement]">
                        {!! $placementOptions !!}
                    </select>
                </div>
            </div>
            <div class="form-group row mandatory">
                <label class="col-sm-4 form-control-label">Статус</label>
                <div class="col-sm-8">
                    <select class="form-select item-status js-repl" required="required" name="media[{{ $j }}][status]">
                        <option value="1"{{ $media->status === '1' ? ' selected' : ''}}>Активна</option>
                        <option value="0"{{ $media->status === '0' ? ' selected' : ''}}>Скрыта</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
