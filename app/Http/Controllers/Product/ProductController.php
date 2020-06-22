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
use App\Http\Models\Translate\Translation;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\SaveProductTranslationsRequest;
use App\Http\Requests\Product\UploadImporterRequest;
use App\Imports\ProductsImport;
use App\Jobs\ParseCSVProducts;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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


    /**
     * Display products.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('product.list');
    }

    /**
     * List resources.
     *
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(DataTables $dataTables) {
        $query = Product::query()
                        ->select(['id', 'name', 'description', 'price', 'stock', 'last_sale_at', 'sku']);

        return $dataTables->eloquent($query)
                          ->editColumn('name', static function ($item) { return ucfirst($item->name); })
                          ->editColumn('description', static function ($item) { return ucfirst($item->description); })
                          ->editColumn('price', static function ($item) { return "{$item->price} €"; })
                          ->editColumn('last_sale_at', static function ($item) { return $item->last_sale_at->toDateTimeString('minute'); })
                          ->addColumn('actions', function ($item) {
                              return $this->getEditButton(route('product.edit', $item->id), trans('product.edit'));
                          })
                          ->rawColumns(['actions'])
                          ->setRowId('id')->toJson();
    }

    /**
     * Edit Resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product) {
        return view('product.edit', compact('product'));
    }

    /**
     * Update resource data.
     *
     * @param Product        $product
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Product $product, ProductRequest $request): ?\Illuminate\Http\RedirectResponse {
        try {
            \DB::beginTransaction();

            $product->update($request->validated());
            $product->save();

            \DB::commit();
            return redirect()->route('product.index')
                ->with(FlashStatus::SUCCESS, trans('general.model.update.correct', ['value' => ucfirst($product->name)]));

        } catch (\Exception $exception) {
            \Log::error($exception);
            \DB::rollBack();

            return redirect()->back()->withInput()
                             ->with(FlashStatus::ERROR, trans('general.model.update.error'));
        }
    }

    /**
     * Save & update product translations.
     *
     * @param Product                        $product
     * @param SaveProductTranslationsRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function updateTranslation(Product $product, SaveProductTranslationsRequest $request) {
        try {
            \DB::beginTransaction();
            $translations = $product->translations->where('locale', $request->input('locale'));

            collect($request->input('data'))->each(function ($transData) use ($translations, &$product) {
                $translation = $translations->firstWhere('column_name', $transData['column']);

                if ($translation instanceof Translation) {
                    $translation->value = $transData['value'];
                } else {
                    $product->translate(request()->input('locale'), $transData['column'], $transData['value']);
                    $product->save();
                }
            });

            \DB::commit();
            return response(trans('general.model.update.correct', ['value' => "{$product->name} - ({$request->input('locale')})"]));
        } catch (\Exception $exception) {
            \Log::error($exception);
            \DB::rollBack();

            return response(trans('general.model.update.error', $exception->getCode()));
        }
    }
}
