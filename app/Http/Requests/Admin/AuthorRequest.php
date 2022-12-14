<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $model = $this->route('author');

        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => [$model ? 'nullable' : 'required', 'image', 'max:5000'],
            'email' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'array'],
            'slug.en' => ['required', 'string', 'max:255'],
            'slug.*' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'array'],
            'description.en' => ['required', 'string', 'max:10000'],
            'description.*' => ['nullable', 'string', 'max:10000'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'steam' => ['nullable', 'string', 'max:255'],
        ];
    }
}
