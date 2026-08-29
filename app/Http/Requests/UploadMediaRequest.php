<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'file' => ['required_without:files', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
        ];
    }
}
