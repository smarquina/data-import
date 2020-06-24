<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Models\Product;


use App\Contracts\TranslatableContract;
use App\Http\Models\BaseModel;
use App\Http\Models\Translate\Translation;
use App\Traits\Translatable;


/**
 * App\Http\Models\Product\Product
 *
 * @property int                                                                                    $id
 * @property string                                                                                 $sku
 * @property int|null                                                                               $category_id
 * @property string                                                                                 $name
 * @property string|null                                                                            $description
 * @property float|null                                                                             $price
 * @property int|null                                                                               $stock
 * @property \Illuminate\Support\Carbon|null                                                        $last_sale_at
 * @property \Illuminate\Support\Carbon|null                                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                                        $updated_at
 * @property-read \App\Http\Models\Product\Category                                                 $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Http\Models\Translate\Translation[] $translations
 * @property-read int|null                                                                          $translations_count
 * @method static string[] translatableColumns()
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel comboList()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel comboJson()
 * @mixin \Eloquent
 */
class Product extends BaseModel implements TranslatableContract {

    use Translatable;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function translations() {
        return $this->morphMany(Translation::class, 'table');
    }

    /**
     * Name getter.
     *
     * @return string
     */
    public function getNameAttribute(): string {
        return $this->trans('name');
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getDescriptionAttribute(): string {
        return $this->trans('description');
    }

    /**
     * Translatable column names.
     *
     * @return string[]
     */
    public function scopeTranslatableColumns(): array {
        return [
            'name'        => trans('general.attributes.name'),
            'description' => trans('general.attributes.description'),
        ];
    }

    /**
     * Save new translation.
     *
     * @param string         $locale
     * @param string         $column
     * @param string|integer $value
     * @return Translation
     */
    public function translate(string $locale, string $column, $value): Translation {
        $translation = (new Translation)->fillTable($this)
                                        ->fill([
                                                   'foreign_key' => $this->id,
                                                   'locale'      => $locale,
                                                   'column_name' => $column,
                                                   'value'       => $value,
                                               ]);

        $this->translations()->save($translation);

        return $translation;
    }
}
