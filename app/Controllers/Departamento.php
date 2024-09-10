<?php

namespace App\Controllers;

class Departamento extends BaseController
{
    public function index()
    {
        $data['dados'] = [
            ['id' => 100, 'descricao' => "Geladeira"],
            ['id' => 150, 'descricao' => "Computadores"],
        ];

        return view("admin/listaDepartamento", $data);
    }
}