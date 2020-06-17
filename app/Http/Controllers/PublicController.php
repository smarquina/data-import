<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 * Date: 13/06/2020
 * Time: 14:45
 */

namespace App\Http\Controllers;


use App\Http\Models\Product\Product;

class PublicController extends Controller {

    public function index() {
        return view('welcome');
    }
}
