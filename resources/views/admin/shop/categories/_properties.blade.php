@php $i = 0;
//dd($options->where('property_id', 2));
@endphp
@foreach ($properties as $property)
    @include('admin.shop.categories._property', ['i' => $i,
                                                 'property' => $property,
                                                 'collapsed' => 'collapsed',
                                                 'options' => $options->where('property_id', $property->id), ])
    @php $i++ @endphp
@endforeach

@php
    $property = new \App\Models\Shop\PropertyList();
@endphp
<template id="tpl-property">
    @include('admin.shop.categories._property', ['i' => 'xxx',
                                                 'property' => $property,
                                                 'collapsed' => '',
                                                 'options' => null])

</template>

<div class="card-tools-more js-block-end" slot="footer">
    <div class="btn btn-primary btn-add-block act-add fa"
         data-tpl="#tpl-property"
         data-count="{{ $i }}"
         title="Вставить элемент"></div>
</div>
