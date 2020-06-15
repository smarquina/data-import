<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Models\Product;


use App\Http\Models\BaseModel;


/**
 * App\Http\Models\Product\Product
 *
 * @property int                                    $id
 * @property string                                 $sku
 * @property int|null                               $category_id
 * @property string                                 $name
 * @property string|null                            $description
 * @property float|null                             $price
 * @property int|null                               $stock
 * @property \Illuminate\Support\Carbon|null        $last_sale_at
 * @property \Illuminate\Support\Carbon|null        $created_at
 * @property \Illuminate\Support\Carbon|null        $updated_at
 * @property-read \App\Http\Models\Product\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereLastSaleAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sku',
                           'category_id',
                           'name',
                           'description',
                           'price',
                           'stock',
                           'last_sale_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sku'          => 'string',
        'category_id'  => 'integer',
        'name'         => 'string',
        'description'  => 'string',
        'price'        => 'float',
        'stock'        => 'integer',
        'last_sale_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'last_sale_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'id');
    }
}
