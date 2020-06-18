<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

abstract class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        \App::setLocale(\Cookie::get('app-language') ?: config('app.locale'));
        Carbon::setLocale(\App::getLocale());
    }
}
