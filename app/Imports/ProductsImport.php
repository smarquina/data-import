<?php

namespace App\Imports;


use App\Http\Models\Product\Category;
use App\Http\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue {

    public $products;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|\App\Http\Models\Product\Product|null
     */
    public function model(array $row) {
        return self::toProductOrCategory($row);
    }

    /**
     * Parse raw row to model.
     *
     * @param string $row
     * @param array  $headers
     * @return Product|null
     */
    static function parseRow(string $row, array $headers) {
        $cells = str_getcsv($row);
        $data  = array_combine($headers, $cells);

        return self::toProductOrCategory($data);
    }

    /**
     * Parse row to Product or to Category.
     *
     * @param $rowData
     * @return Product|null
     */
    private static function toProductOrCategory($rowData) {
        if (empty($rowData['descripcion']) && empty($rowData['precio']) && empty($rowData['stock'])) {

            Category::whereName($rowData['nombre'])->firstOr(function () use ($rowData) {
                $category = new Category(['name' => $rowData['nombre']]);
                $category->save();
                \Cache::forget('dbCategories');
            });
            return null;
        } else {
            /** @var Category $category */
            $category = Category::all()->where('name', $rowData['categoria'])->first();
            return new Product([
                                   'name'         => $rowData['nombre'],
                                   'description'  => $rowData['descripcion'],
                                   'price'        => (float)$rowData['precio'],
                                   'stock'        => (int)$rowData['stock'],
                                   'last_sale_at' => Carbon::create($rowData['fecha_ultima_venta']) ?? null,
                                   'category_id'  => optional($category)->id,
                                   'sku'          => $rowData['sku'] ?? null,
                               ]);
        }
    }

    /**
     * Batch import size.
     *
     * @return int
     */
    public function batchSize(): int {
        return 100;
    }

    /**
     * Chunk Size of the import.
     *
     * @return int
     */
    public function chunkSize(): int {
        return 1000;
    }
}
