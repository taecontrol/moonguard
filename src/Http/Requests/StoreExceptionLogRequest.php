<?php

namespace Taecontrol\MoonGuard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExceptionLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'api_token' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
            'file' => 'required|string',
            'line' => 'required|int',
            'trace' => 'required|array',
            'request' => 'array',
            'thrown_at' => 'required|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
