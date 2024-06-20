<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class KardexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'inventory_id' => 'required|integer|exists:inventories,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start|date_format:Y-m-d',
            'type_movement' => 'required|in:output,input,all'
        ];
    }

    public function messages(): array
    {
        return [
            'inventory_id.required' => 'El campo inventario es obligatorio.',
            'inventory_id.integer' => 'El campo inventario debe ser un entero.',
            'inventory_id.exists' => 'El campo inventario no existe.',
            'date_start.required' => 'El campo fecha de inicio es obligatorio.',
            'date_start.date' => 'El campo fecha de inicio debe ser una fecha.',
            'date_end.required' => 'El campo fecha termino es obligatorio.',
            'date_end.date' => 'El campo fecha termino debe ser una fecha.',
            'type_movement.required' => 'El campo tipo de movimiento es obligatorio.',
            'type_movement.in' => 'El campo tipo de movimiento debe ser input o output o all'
        ];
    }
}
