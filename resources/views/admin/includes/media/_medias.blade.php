<?php
$help = [
    'title' => '1',
    'link' => '2',
    'placement' => '',
    'status' => '4',
];
?>
@php $j = 0; @endphp
@foreach ($item->medias as $media)
    @include('admin.includes.media._media', ['j' => $j, 'collapsed' => 'collapsed'])
    @php $j++ @endphp
@endforeach

@php $media = new \App\Models\Media(); @endphp

<template id="tpl-media">
    @include('admin.includes.media._media', ['j' => 'xxx', 'collapsed' => ''])
</template>
<template id="tpl-media-new">
    @include('admin.includes.media._media_new', ['j' => 'xxx'])
</template>

<div class="card-tools-more" data-id="{{ $j }}">
    <button type="button" class="btn btn-primary js-add-new act-add fa" data-tpl="#tpl-media-new"
            title="Добавить новую картинку"></button>
    <button type="button" class="btn btn-primary act-add fa" data-bs-toggle="modal" data-bs-target="#listMediaModal"
            title="Добавить картинку из галереи">
        <span>Из галереи</span>
    </button>
</div
