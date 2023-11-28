<?php

namespace Modules\Ecommerce\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Modules\Ecommerce\Traits\Response;

/**
 *
 */
class CreateProductRequest extends FormRequest
{
    use Response;


    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', Rule::unique('products', 'name')],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'category_ids' => ['array'],
            'category_ids.*' => [Rule::requiredIf(!empty($this->category_ids)), 'distinct','integer', Rule::exists('categories', 'id')],
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
     * @return void
     */
    protected function passedValidation(): void
    {
        (!$this->validator->fails() and $this->hasSession()) and $this->session()->put('success', trans('ecommerce::messages.success'));
    }


    /**
     * @param Validator $validator
     * @return RedirectResponse|mixed|void
     */
    protected function failedValidation(Validator $validator)
    {
        return $this->expectsJson() ? $this->errorResponse($validator->errors()->all()) : redirect()->back()->withErrors($validator);
    }
}
