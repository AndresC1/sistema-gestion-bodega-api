<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "orderBy" => "string",
            "order" => "in:asc,desc",
            "limit" => "integer|min:1",
            "search" => "string",
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            "paginate.required" => "The paginate field is required.",
            "paginate.in" => "The paginate field must be true or false.",
            "orderBy.required" => "The orderBy field is required.",
            "orderBy.string" => "The orderBy field must be a string.",
            "order.required" => "The order field is required.",
            "order.in" => "The order field must be asc or desc.",
            "limit.required" => "The limit field is required.",
            "limit.integer" => "The limit field must be an integer.",
            "search.string" => "The search field must be a string.",
        ];
    }
}
