<?php
$help = [
    'type' => '2',
    'list' => '',
    'title' => '1',
    'content' => '4',
];

?>

@php $j = 0; @endphp
@foreach ($item->texts as $text)
    @include('admin.includes.text._text', ['j' => $j, 'collapsed' => 'collapsed'])
    @php $j++ @endphp
@endforeach

{{--@php $text = new \App\Models\Text(); @endphp--}}

{{--<template id="tpl-text">--}}
{{--    @include('admin.includes.text._text', ['j' => 'xxx', 'collapsed' => ''])--}}
{{--</template>--}}
<template id="tpl-text-new">
    @include('admin.includes.text._text_new', ['j' => 'xxx'])
</template>

<div class="card-tools-more mt-2" data-id="{{ $j }}">
    <button type="button" class="btn btn-primary js-add-text-new act-add fa" data-tpl="#tpl-text-new"
            title="Добавить новый текст"></button>
    <button type="button" class="btn btn-primary act-add fa" data-bs-toggle="modal" data-bs-target="#listTextsModal"
            title="Добавить текст из списка">
        <span>Из списка</span>
    </button>
</div>
