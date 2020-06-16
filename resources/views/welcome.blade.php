@extends('layouts.app')

@section('content')

    <div class="flex-center position-ref">
        <card>
            <template v-slot:header>
                <div class="float-right">
                    <a data-click="generate" title="{{__('product.view.generate_random_product')}}"
                       href="{{ route('product.generateRandomProducts') }}">
                        <i class="fa fa-download"></i> {{__('product.view.download_product_list')}}
                    </a>
                </div>
            </template>

            {!! Form::open(['route' => 'product.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

            <div class="row">
                <div class="col-12">
                    <form-group attribute="file"
                                :width="10"
                                v-bind:label="'{{trans('general.attributes.file')}}'">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="{{--custom-file-input--}} form-control"
                                       id="inputGroupFile" accept="text/csv">
                                {{-- <label class="custom-file-label" for="inputGroupFile">--}}
                                {{-- {{__('general.attributes.choose_file')}}--}}
                                {{-- </label>--}}
                            </div>
                        </div>
                    </form-group>
                </div>
                <div class="col-12">
                    <form-group attribute="import_alg"
                                :width="10"
                                v-bind:label="'{{trans('product.attributes.import_alg')}}'">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                   name="import_alg"
                                   id="import_alg1"
                                   value="custom" checked>
                            <label class="form-check-label" for="import_alg1">
                                {{__('product.view.custom_alg')}}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="import_alg" id="import_alg2" value="le">
                            <label class="form-check-label" for="import_alg2">
                                {{__('product.view.le_alg')}}
                            </label>
                        </div>
                    </form-group>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary disabled"
                            disabled>@lang('general.buttons.save')</button>
                </div>
            </div>

            {!! Form::close() !!}
        </card>

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        (function (window, document) {
            document.querySelector("a[data-click=generate]").addEventListener('click', event => {
                event.preventDefault();
                return confirm(`{{__('product.alert.generation_takes_long')}}`)
                    ? window.location = event.target.getAttribute('href')
                    : false;
            }, false);

            document.querySelector("input[name=file]").addEventListener('change', () => {
                const btn = document.querySelector("button[type=submit");
                btn.disabled = false;
                btn.classList.remove('disabled');
            }, false);
        })(window, document);
    </script>
@endsection
