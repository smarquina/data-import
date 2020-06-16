<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadImporterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'file'       => 'required|file|',
            'import_alg' => ['required', Rule::in(['le', 'custom'])],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array {
        return [
            'file'       => trans('general.attributes.file'),
            'import_alg' => trans('product.attributes.import_alg'),
        ];
    }
}
