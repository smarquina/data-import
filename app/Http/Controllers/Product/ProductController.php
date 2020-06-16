<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 * Date: 12/06/2020
 * Time: 21:18
 */

namespace App\Http\Controllers\Product;


use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Enums\FlashStatus;
use App\Http\Models\Product\Category;
use App\Http\Models\Product\Product;
use App\Http\Requests\Product\UploadImporterRequest;
use App\Imports\ProductsImport;
use App\Jobs\ParseCSVProducts;
use Faker\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller {

    /**
     * Generate downloadable CSV with random products.
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generateRandomProducts() {
        set_time_limit(360);
        $faker    = Factory::create(app()->getLocale());
        $products = collect();
        Category::all()->pluck('name')
                ->each(function ($category) use ($faker, &$products) {
                    //Category row
                    $products->add(new Product(['name' => $category]));

                    Collection::times($faker->numberBetween(5000, 15000), static function () use ($faker, $category, &$products) {
                        $product                = new Product([
                                                                  'sku'          => Str::random(5),
                                                                  'name'         => uniqid("{$faker->word}-", false),
                                                                  'description'  => $faker->realText(250),
                                                                  'price'        => $faker->randomFloat(2, 1, 150),
                                                                  'stock'        => $faker->numberBetween(0, 100),
                                                                  'last_sale_at' => $faker->dateTimeThisYear()->format('Y-m-d h:i:s'),
                                                              ]);
                        $product->category_name = $category;

                        $products->add($product);
                    });
                });
        return (new ProductsExport($products))->download('products.csv',
                                                         \Maatwebsite\Excel\Excel::CSV,
                                                         ['Content-Type' => 'text/csv']);
    }

    /**
     * Store and parse CSV.
     *
     * @param UploadImporterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UploadImporterRequest $request) {
        if ($request->input('import_alg', 'custom') === 'custom') {
            $file = \Storage::disk('temp')
                            ->putFileAs("uploaded", $request->file('file'), uniqid("products_", false) . ".csv");
            ParseCSVProducts::dispatch(\Storage::disk('temp')->path($file));
        } else {
            Excel::queueImport(new ProductsImport, $request->file('file')->getRealPath());
        }

        //START /b php artisan queue:work --timeout=0
        //nohup php artisan queue:work --timeout=0 &
        return redirect()->route('index')
                         ->with(FlashStatus::SUCCESS, trans('general.file.upload_ok'));
    }

}
