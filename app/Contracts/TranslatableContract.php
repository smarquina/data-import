<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Contracts;


interface TranslatableContract {

    /**
     * Translate given attribute.
     *
     * @param string $column
     * @return mixed
     */
    public function trans(string $column);

    /**
     * Translatable column names.
     *
     * @return string[]
     */
    public function scopeTranslatableColumns(): array;
}
