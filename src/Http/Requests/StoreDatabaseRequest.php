<?php

namespace AbnDevs\Installer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDatabaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'driver' => ['required', 'string', 'in:mysql,pgsql,sqlsrv'],
            'host' => ['required', 'string'],
            'port' => ['required', 'numeric'],
            'database' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['nullable', 'string', 'regex:/^[^\'"]*$/'],
            'force' => ['nullable', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password cannot contain quotes.',
        ];
    }
}
