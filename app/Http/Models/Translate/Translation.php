<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Models\Translate;


use App\Http\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


/**
 * App\Http\Models\Translate\Translation
 *
 * @property int                                                $id
 * @property string                                             $table_type
 * @property int                                                $table_id
 * @property string                                             $column_name
 * @property string                                             $locale
 * @property string                                             $value
 * @property \Illuminate\Support\Carbon|null                    $created_at
 * @property \Illuminate\Support\Carbon|null                    $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $table
 * @method static string[] availableLangs()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereColumnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereTable($model)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereTableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Translate\Translation whereValue($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel comboList()
 */
class Translation extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'translation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['table',
                           'column_name',
                           'foreign_key',
                           'locale',
                           'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'table'       => 'string',
        'column_name' => 'string',
        'foreign_key' => 'integer',
        'locale'      => 'string',
        'value'       => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function table() {
        return $this->morphTo('table');
    }

    /**
     * @param Model $table
     * @return $this
     */
    public function fillTable(Model $table) {
        return $this->fill([
                               'table_id'   => $table->getKey(),
                               'table_type' => $table->getMorphClass(),
                           ]);
    }

    /**
     * @param       $query
     * @param Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereTable($query, $model): \Illuminate\Database\Eloquent\Builder {
        return $query->where('table_id', $model->getKey())
                     ->where('table_type', $model->getMorphClass());
    }

    /**
     * @param Builder $query
     * @return string[]
     */
    public function scopeAvailableLangs($query): array {
        return [
            'es' => 'Español',
            'en' => 'English',
            'fr' => 'Francais',
        ];
    }
}
