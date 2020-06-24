<?php

/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Query\Builder;


/**
 * App\Http\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel comboList()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel comboJson()
 * @mixin \Eloquent
 */
class BaseModel extends \Eloquent {

    use FormAccessible;

    public $comboIdentifierField = 'name';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Common combo.
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeComboList($query) {
        return $query->get()->pluck($this->getNameFieldComboBoxAttribute(), 'id');
    }

    /**
     * Json combo.
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeComboJson($query) {
        return $query->get()->transform(function ($item) {
            $field = $this->getNameFieldComboBoxAttribute();
            return [
                'id'   => $item->id,
                'text' => $item->$field,
            ];
        });
    }

    /**
     * Columns name that will be used in combo boxes.
     *
     * @return string
     */
    protected function getNameFieldComboBoxAttribute() {
        return $this->comboIdentifierField;
    }
}
