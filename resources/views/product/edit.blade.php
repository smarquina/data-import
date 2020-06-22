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

        @foreach($product->translations->groupBy('locale') as $translations)
            <card>
                <template v-slot:header>
                    <div class="float-left">
                        {{\App\Http\Models\Translate\Translation::availableLangs()[$translations->first()->locale]}}
                    </div>
                    <div class="float-right">
                        <a data-action="save-translations"
                           data-locale="{{$translations->first()->locale}}"
                           data-product="{{$product->id}}"
                           title="{{__('general.buttons.save')}}"
                           href="{{ route('product.updateTranslation', $product->id) }}">
                            <i class="fas fa-save"></i> {{__('general.buttons.save')}}
                        </a>
                    </div>
                </template>

                @foreach($translations as $translation)
                    <form data-locale="{{$translations->first()->locale}}">
                        <div class="row">
                            <div class="col-6">
                                <form-group attribute="column_name"
                                            :width="8"
                                            v-bind:label="'{{trans('translation.attributes.column_name')}}'">
                                    {!! Form::select('column_name',\App\Http\Models\Product\Product::translatableColumns() , $translation->column_name,
                                            ['class'=> "form-control". ($errors->has('column_name') ? ' is-invalid' : ''), 'required'=>'required']) !!}
                                </form-group>
                            </div>
                            <div class="col-6">
                                <form-group attribute="value"
                                            :width="8"
                                            v-bind:label="'{{trans('translation.attributes.value')}}'">
                                    {!! Form::textarea('value', $translation->value,
                                            ['class'=> "form-control". ($errors->has('value') ? ' is-invalid' : ''), 'required'=>'required', 'rows' => 3]) !!}
                                </form-group>
                            </div>
                        </div>
                    </form>
                @endforeach
            </card>
        @endforeach
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        (function (window, document) {
            window.onload = () => {
                document.querySelectorAll("a[data-action=save-translations]").forEach(anchor => {
                    anchor.addEventListener('click', event => {
                        event.preventDefault();
                        const lang = event.target.getAttribute('data-locale');
                        const product = event.target.getAttribute('data-product');
                        let langData = [];
                        document.querySelectorAll(`form[data-locale=${lang}]`).forEach(localeForm => {
                            const column = localeForm.querySelector('select').value;
                            const value = localeForm.querySelector('textarea').value
                            langData.push({column: column, value: value});
                        });

                        let actionIcons = event.target.querySelector('i')
                        const previousData = actionIcons.classList.value;
                        actionIcons.className = "fas fa-circle-notch fa-spin";

                        fetch(event.target.getAttribute('href'), {
                            headers: {
                                'X-CSRF-TOKEN': window.data.csrfToken,
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            method: "PUT",
                            body: JSON.stringify({locale: lang, product_id: product, data: langData}),
                        }).then(res => {
                            res.text().then(function (text) {
                                $('#toast').showToast(text);
                            });
                            actionIcons.className = previousData;
                        }).catch(error => {
                            actionIcons.className = previousData;
                            console.error(error);
                        });
                    }, false)
                });
            }
        })(window, document);
    </script>
@endsection
