<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 * Date: 23/06/2020
 * Time: 17:33
 */

namespace App\Http\Controllers\Translation;


use App\Http\Controllers\Controller;
use App\Http\Models\Translate\Translation;
use Illuminate\Support\Collection;

class TranslationController extends Controller {

    /**
     * List available application locales.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listLocales() {
        $locales = Collection::wrap(Translation::availableLangs())->transform(function ($language, $name) {
            return [
                'id'   => $name,
                'text' => $language,
            ];
        });
        return response()->json($locales);
    }
}
