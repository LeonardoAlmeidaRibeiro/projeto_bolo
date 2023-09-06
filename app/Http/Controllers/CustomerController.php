<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function storeAddress(Request $request)
    {
        $customer = Customer::find('id', $request->customer_id);

        if (!$customer) {
            return $this->error("Cliente não encontrado");
        } else {
            $customer->address()->create([
                'street' => $request->street,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'cep' => $request->cep,

            ]);

            return $this->sucess([
                'customer' => $customer->address()
            ],"Endereço cadastrado com sucesso.");
        }
    }
}
