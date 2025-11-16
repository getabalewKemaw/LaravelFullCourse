<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') instanceof \App\Models\Category
            ? $this->route('category')->id
            : (int) $this->route('category');

        return [
            'name' => [
                'required', 'string', 'min:2', 'max:120',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'slug' => [
                'nullable', 'string', 'max:150',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim($this->name) : $this->name,
            'slug' => is_string($this->slug) ? trim($this->slug) : $this->slug,
        ]);
    }
}
