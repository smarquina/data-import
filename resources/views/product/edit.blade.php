@extends('layouts.app')

@php
    /** @var \App\Http\Models\Product\Product $product */
@endphp

@section('content')
    <div class="flex-center position-ref">
        <card v-bind:title="'{{__('product.edit') . " {$product->name}"}}'">
            <div class="row">
                <div class="col-12">
                    {!! Form::model($product, ['route' => ['product.update', $product], 'method' => 'PUT']) !!}

                    <div class="row">
                        <div class="col-6">
                            <form-group attribute="name"
                                        :width="8"
                                        v-bind:label="'{{trans('general.attributes.name')}}'">
                                {!! Form::text('name', null, ['class'=> "form-control". ($errors->has('name') ? ' is-invalid' : ''), 'required'=>'required']) !!}
                            </form-group>

                            <form-group attribute="description"
                                        :width="8"
                                        v-bind:label="'{{trans('general.attributes.description')}}'">
                                {!! Form::textarea('description', null, ['class'=> "form-control". ($errors->has('description') ? ' is-invalid' : ''), 'required'=>'required']) !!}
                            </form-group>
                        </div>

                        <div class="col-6">
                            <form-group attribute="category_id"
                                        :width="8"
                                        v-bind:label="'{{trans('product.attributes.category_id')}}'">
                                {!! Form::select('category_id', \App\Http\Models\Product\Category::comboList() ,null,
                                                 ['class'=> "form-control". ($errors->has('category_id') ? ' is-invalid' : ''), 'required'=>'required']) !!}
                            </form-group>

                            <form-group attribute="price"
                                        :width="8"
                                        v-bind:label="'{{trans('product.attributes.price')}}'">
                                {!! Form::number('price', null, ['class'=> "form-control". ($errors->has('price') ? ' is-invalid' : ''),
                                                    'required'=>'required', 'step' => 0.01]) !!}
                            </form-group>

                            <form-group attribute="stock"
                                        :width="8"
                                        v-bind:label="'{{trans('product.attributes.stock')}}'">
                                {!! Form::number('stock', null, ['class'=> "form-control". ($errors->has('stock') ? ' is-invalid' : ''),
                                                    'required'=>'required', 'step' => 1]) !!}
                            </form-group>

                            <form-group attribute="sku"
                                        :width="8"
                                        v-bind:label="'{{trans('product.attributes.sku')}}'">
                                {!! Form::text('sku', null, ['class'=> "form-control". ($errors->has('sku') ? ' is-invalid' : '')]) !!}
                            </form-group>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                @lang('general.buttons.save')
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </card>

        <product-translations v-bind:save-title="'{{ __('general.buttons.save') }}'"
                              v-bind:save-route="'{{ route('product.updateTranslation', $product->id) }}'"
                              v-bind:column-label="'{{ __('translation.attributes.column_name') }}'"
                              v-bind:value-label="'{{ __('translation.attributes.value') }}'"
                              v-bind:language-route="'{{ route('translation.listLocales') }}'"
                              v-bind:translations-route="'{{ route('product.listTranslations', $product->id) }}'"
                              v-bind:columns-route="'{{ route('product.listTranslatableColumns') }}'">

        </product-translations>
    </div>
@endsection

@section('js')
    <script type="text/javascript"></script>
@endsection
