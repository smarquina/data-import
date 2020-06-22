@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref">
        <card v-bind:title="'{{__('product.list')}}'">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group">
                        {{-- <a href="#" class="btn btn-lg btn-primary mb-4"><i class="fas fa-plus"></i></a>--}}
                    </div>
                </div>
                <div class="col-12">
                    <table ref="dataTable"
                           class="table table-striped table-dark table-hover table-responsive-sm filter-head no-footer dataTable">
                        <thead>
                        <tr>
                            <th scope="row">{{__('general.attributes.id')}}</th>
                            <th>{{__('general.attributes.name')}}</th>
                            <th>{{__('general.attributes.description')}}</th>
                            <th>{{__('product.attributes.price')}}</th>
                            <th>{{__('product.attributes.stock')}}</th>
                            <th>{{__('product.attributes.last_sale_at')}}</th>
                            <th>{{__('product.attributes.sku')}}</th>
                            <th>{{__('general.attributes.actions')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </card>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        (function (window, document) {
            let langUrl;
            switch ("{{app()->getLocale()}}") {
                case "es":
                    langUrl = "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json";
                    break;
                case "fr":
                    langUrl = "//cdn.datatables.net/plug-ins/1.10.15/i18n/French.json";
                    break;
                default:
                    langUrl = "//cdn.datatables.net/plug-ins/1.10.15/i18n/English.json";
            }

            $("table.dataTable").DataTable({
                ordering: true,
                info: true,
                autoWidth: true,

                pageLength: 25,
                stateSave: true,
                order: [[0, "desc"]],
                fixedColumns: true,

                bPaginate: true,
                searching: true,
                processing: true,
                serverSide: true,
                ajax: "{{route('product.list')}}",
                columns: [
                    {data: "id", name: "id", className: "text-center"},
                    {data: "name", name: "name", className: "text-center"},
                    {data: "description", name: "description", className: "text-center"},
                    {data: "price", name: "price", className: "text-center"},
                    {data: "stock", name: "stock", className: "text-center"},
                    {data: "last_sale_at", name: "last_sale_at", className: "text-center"},
                    {data: "sku", name: "sku", className: "text-center"},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                language: {
                    url: langUrl,
                },
                initComplete: function (settings, json) {

                }
            });
        })(window, document);

    </script>
@endsection
