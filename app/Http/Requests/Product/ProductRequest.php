<?php
/**
 * Created for data-import.
 * User: Sergio Martin Marquina
 * Email: smarquina@zenos.es
 */

namespace App\Http\Requests\Product;


use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

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
            'category_id' => 'required|int|exists:category,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price'       => 'required|numeric|',
            'stock'       => 'required|int|',
            'sku'         => 'nullable|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array {
        return [
            'category_id' => trans('product.attributes.category_id'),
            'name'        => trans('general.attributes.name'),
            'description' => trans('general.attributes.description'),
            'price'       => trans('product.attributes.price'),
            'stock'       => trans('product.attributes.stock'),
            'sku'         => trans('product.attributes.sku'),
        ];
    }
}
