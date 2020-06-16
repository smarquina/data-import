<?php

namespace App\Exports;


use App\Http\Models\Product\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Class ProductsExport
 * @package App\Exports
 */
class ProductsExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings {

    use Exportable;

    protected $products;

    /**
     * ProductsExport constructor.
     * @param Collection $products
     */
    public function __construct(Collection $products) {
        $this->products = $products;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array {
        switch ($product) {
            case $product instanceof Product:
                return [
                    $product->category_name,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->stock,
                    optional($product->last_sale_at)->format('Y-m-d h:i:s'),
                    $product->sku,
                ];
                break;
            case is_array($product):
                return [
                    $product['categoria'],
                    $product['nombre'],
                    $product['descripcion'],
                    $product['precio'],
                    $product['stock'],
                    $product['fecha_ultima_venta'],
                    $product['sku'] ?? null,
                ];
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * @return string[]
     */
    public function headings(): array {
        return [
            'categoria',
            'nombre',
            'descripcion',
            'precio',
            'stock',
            'fecha_ultima_venta',
            'sku',
        ];
    }
}
