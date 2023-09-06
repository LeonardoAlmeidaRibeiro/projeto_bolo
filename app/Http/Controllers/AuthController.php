<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $customer = Customer::where('email', '=', $request->email)->first();
        
        if ($customer == null) {
            return $this->error('Email não encontrado');
        }
        if (Hash::check($request->password, $customer->password)) {
            return $this->sucess([
                'user' => $customer
            ], 'Acesso Liberado');
        } else {
            return $this->error('Senha Incorreta');
        }
    }

    public function register(Request $request)
    {

        $passoword = Hash::make($request->password);
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'password' => $passoword,
        ]);

        if ($customer) {
            return $this->sucess([
                'user' => $customer
            ], 'Cadastrado com sucesso');
        }else{
            return $this->error('Cadastro falhou');
        }
    }


}
