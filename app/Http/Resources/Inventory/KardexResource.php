<?php

namespace App\Http\Resources\Inventory;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KardexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $inputs = $this->productInputs->toArray();
        $outputs = $this->productOutputs->toArray();
        $movements = array_merge($inputs, $outputs);
        for ($i = 0; $i < count($movements); $i++) {
//            $user_id = $movements[$i]['user_id'];
//            $movements[$i]['username'] = User::find($user_id)->name;
            if(array_key_exists('disponibility', $movements[$i])){
                $movements[$i]['type'] = 'Input';
                $movements[$i]['input'] = $movements[$i]['quantity'];
                $movements[$i]['output'] = 0;
            } else{
                $movements[$i]['type'] = 'Output';
                $movements[$i]['input'] = 0;
                $movements[$i]['output'] = $movements[$i]['quantity'];
            }
        }
        usort($movements, function ($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

        return [
            'id' => $this->id,
            'product' => $this->product->name,
            'type' => $this->type,
            'stock' => $this->stock,
            'stock_min' => $this->stock_min,
            'measurement_type' => $this->product->measurement_type,
            'unit_of_measurement' => $this->unit_of_measurement,
            'location' => $this->location,
            'date_last_modified' => $this->date_last_modified,
            'lot_number' => $this->lot_number,
            'note' => $this->note,
            'status' => $this->status,
            'total_value' => $this->total_value,
            'code' => $this->code,
            'description' => $this->description,
            'movements' => $movements,
        ];
    }
}
