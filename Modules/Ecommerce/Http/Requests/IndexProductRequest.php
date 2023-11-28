<?php

namespace Modules\Ecommerce\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Ecommerce\Traits\Response;

/**
 *
 */
class IndexProductRequest extends FormRequest
{
    use Response;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'categoryName' => ['string', 'max:191'],
            'sortBy' => [Rule::in('price')],
            'dir' => [Rule::in('asc', 'desc')],
        ];
    }


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @param Validator $validator
     * @return mixed|void
     */
    protected function failedValidation(Validator $validator)
    {
        return $this->expectsJson() ? $this->errorResponse($validator->errors()->all()) : redirect()->back()->withErrors($validator);
    }
}
