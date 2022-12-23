@php
    $placementOptions = '"<option>Все</option>';
    foreach($placements as $key => $placement) {
        $placementOptions .= "<option value='$key'>$placement</option>";
    }
    $objectOptions = '"<option>Все объекты</option>';
    foreach(\App\Models\Media::OBJECTS as $key => $object) {
        $objectOptions .= "<option value='$key'>$object</option>";
    }
@endphp
<div class="d-flex flex-wrap justify-content-between products-cards w-100 box">
    <div class="item-filter">
        <select name="object" class="form-select">
            {!! $objectOptions !!}
        </select>
    </div>
    <div class="item-filter">
        <select name="subobject" class="form-select">
            <option>Подобъект</option>
            <option>Подобъект 1</option>
            <option>Подобъект 2</option>
            <option>Подобъект 3</option>
            <option>Подобъект 4</option>
        </select>
    </div>
    <div class="item-filter">
        <input type="text" id="date-start" name="date-start" class="form-control flatpickrStart" placeholder="Начало периода">
    </div>
    <div class="item-filter">
        <input type="text" id="date-end" name="date-end" class="form-control flatpickrEnd" placeholder="Конец периода">
    </div>
    <div class="item-filter">
        <select name="placement" class="form-select">
            {!! $placementOptions !!}
        </select>
    </div>
    <button class="btn btn-primary">Применить</button>
</div>
<div class="d-flex flex-wrap justify-content-between products-cards w-100">
    @foreach($items as $item)
        <div class="card my-3">
            <div class="card-body">
{{--                <a href="{{ route('product', $item->slug) }}">--}}
@php                //TODO при наведении показать параметры
                //TODO при клике показать полный размер картинки @endphp
                    <div class="card-image" style="width: 240px; height: 240px">
                        @if(imgMedium($item->link, $item->object, $item->subobject) === '')
                            <img src="/images/noimage.jpg" class="card-img-top" alt="" height="240px">
                        @else
                            <img src="{{ imgMedium($item->link, $item->object, $item->subobject) }}" style="max-width: 240px; max-height: 240px" alt="">
                        @endif
                    </div>
                    <div class="card-title my-2 fs-6" style="width: 240px">{{ $item->title }}</div>
{{--                </a>--}}
            </div>
        </div>
    @endforeach
</div>
