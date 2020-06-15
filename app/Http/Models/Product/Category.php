<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Models\Product;


use App\Http\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Product\Category
 *
 * @property int                                                                              $id
 * @property string                                                                           $name
 * @property \Illuminate\Support\Carbon|null                                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                                  $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Http\Models\Product\Product[] $products
 * @property-read int|null                                                                    $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Product\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends BaseModel {

    /**
     * Time to refresh cache
     * @var int  REFRESH_TIME
     */
    private const REFRESH_TIME = 600;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['name' => 'string'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = ['*'])
    {
        return \Cache::get('dbCategories', function () use ($columns) {
            $dbCategories = parent::all($columns);
            \Cache::add('dbCategories', $dbCategories, self::REFRESH_TIME);
            return $dbCategories;
        });
    }
}
