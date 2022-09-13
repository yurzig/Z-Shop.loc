@php $j = 0; @endphp
@foreach ($medias as $media)
    @include('admin.shop.includes._media', ['j' => $j, 'collapsed' => 'collapsed'])
    @php $j++ @endphp
@endforeach

@php $media = new \App\Models\Media(); @endphp

<template id="tpl-media">
    @include('admin.shop.includes._media', ['j' => 'xxx', 'collapsed' => ''])
</template>

<div class="card-tools-more js-block-end" slot="footer">
    <div class="btn btn-primary btn-add-block act-add fa"
         data-tpl="#tpl-media"
         data-count="{{ $j }}"
         title="Вставить изображение"></div>
</div>
