<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 * Date: 18/06/2020
 * Time: 18:35
 */

namespace App\Http\Requests\Product;


use App\Http\Models\Product\Product;
use App\Http\Models\Translate\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProductTranslationsRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'locale'        => ['required', 'string', Rule::in(array_keys(Translation::availableLangs()))],
            'product_id'    => 'required|int|exists:product,id',
            'data'          => 'required|array|',
            'data.*.column' => ['required', 'string', Rule::in(array_keys(Product::translatableColumns()))],
            'data.*.value'  => 'required|string|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array {
        return [
            'locale'      => trans('general.attributes.file'),
            'product_id'  => trans('product.attributes.product'),
            'data.column' => trans('translation.attributes.column_name'),
            'data.value'  => trans('translation.attributes.value'),
        ];
    }
}
