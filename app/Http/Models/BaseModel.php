<?php

/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */
namespace App\Http\Models;

use Collective\Html\Eloquent\FormAccessible;



/**
 * App\Http\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends \Eloquent {

    use FormAccessible;

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
}
