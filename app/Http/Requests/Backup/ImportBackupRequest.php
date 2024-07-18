<?php

namespace App\Http\Requests\Backup;

use Illuminate\Foundation\Http\FormRequest;

class ImportBackupRequest extends FormRequest
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
            "backup_id" => ["required", "exists:backups,id"],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            "backup_id.required" => "Backup ID is required",
            "backup_id.exists" => "Backup not found",
        ];
    }
}
