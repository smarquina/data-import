<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 * Date: 13/06/2020
 * Time: 14:45
 */

namespace App\Http\Controllers;


use App\Http\Enums\FlashStatus;
use App\Http\Models\Translate\Translation;
use Illuminate\Http\Request;

class PublicController extends Controller {

    public function index() {
        return view('welcome');
    }

    /**
     * Update app language.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function setLang(Request $request) {
        if (array_key_exists($request->input('language'), Translation::availableLangs())) {
            app()->setLocale($request->input('language'));
            \Cookie::queue(\Cookie::make('app-language', app()->getLocale()));

            return redirect()->back()
                             ->with(FlashStatus::SUCCESS, trans('general.lang.success_update', ['value' => Translation::availableLangs()[app()->getLocale()]]));
        }

        return redirect()
            ->back()
            ->with(FlashStatus::WARNING, trans('general.lang.error_update'));
    }
}
