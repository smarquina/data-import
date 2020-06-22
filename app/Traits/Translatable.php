<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Traits;


use App\Http\Models\Translate\Translation;

trait Translatable {

    /**
     * Translate given attribute.
     *
     * @param string $column
     * @return mixed
     */
    public function trans(string $column) {
        $translation = Translation::where(function ($query) {
            $query->whereTable($this);
        })
                                  ->whereLocale(app()->getLocale())
                                  ->whereColumnName($column)
                                  ->first();
        return optional($translation)->value ?? $this->attributes[$column];
    }
}
