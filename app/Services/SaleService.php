<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\ProductInput;
use App\Repository\SaleRepository;
use App\Rules\Sale\ValidateInputExistInTheOrganization;
use Illuminate\Support\Facades\Validator;
use Exception;

class SaleService
{
    protected $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
    }
    public function store($data)
    {
        return $this->saleRepository->store([
            'number_bill' => $data['number_bill'],
            'organization_id' => auth()->user()->organization_id,
            'client_id' => $data['client_id'],
            'user_id' => auth()->user()->id,
            'date' => now('America/Managua')->format('Y-m-d'),
            'total' => 0,
            'earning_total'=> 0,
            'note' => $data['note'],
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
        ]);
    }
    public function create($dataHeader, $dataBody)
    {
        $detailsSaleService = new DetailsSaleService();
        $outputProductService = new OutputProductService();
        $inventoryService = new InventoryService();
        $entryProductService = new EntryProductService();
        $dataSale = $this->store($dataHeader);
        $total = 0;
        $earning_total = 0;
        foreach ($dataBody as $data) {
            $productInput = ProductInput::find($data['product_input_id']);
            $inventory = Inventory::find($productInput->inventory->id);
            $detailsSaleService->store($dataSale->id, $data);
            $outputProductService->store([
                'inventory_id' => $inventory->id,
                'quantity' => $data['quantity'],
                'total' => $data['quantity'] * $productInput->price,
                'price' => $productInput->price,
                'observation' => "Salida de producto el " . now('America/Managua')->format('d/m/Y')." por venta.",
            ]);
            $inventoryService->update_decrease(
                $inventory,
                $data['quantity'],
                $data['quantity'] * $productInput->price
            );
            $total += $data['quantity'] * $data['price'];
            $earning_total += ($data['quantity'] * $data['price']) - ($data['quantity'] * $productInput->price);
            $entryProductService->updateDisponibility($data['product_input_id'], $data['quantity']);
        }
        $this->saleRepository->update(
            $dataSale,
            $total,
            $earning_total
        );
        return $dataSale;
    }
    public function validate($data)
    {
        $validatorSale = Validator::make($data, [
            '*.product_input_id' => [
                'required',
                'numeric',
                'min:1',
                'exists:product_inputs,id',
                new ValidateInputExistInTheOrganization()
            ],
            '*.quantity' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($data) {
                    $this->ValidateDisponibility($data, $attribute, $value);
                }
            ],
            '*.price' => 'required|numeric|min:0',
        ]);
        if ($validatorSale->fails()) {
            return $validatorSale->errors();
        }
        $validatorSale->validate();
        return null;
    }
    private function ValidateDisponibility($data, $attribute, $value){
        $product_input_id = $data[$attribute[0]]['product_input_id'];
        $product_input = ProductInput::find($product_input_id);
        if ($value > $product_input->disponibility) {
            throw new Exception("La cantidad ingresada es mayor a la cantidad que dispone en la entrada.");
        }
    }
}
