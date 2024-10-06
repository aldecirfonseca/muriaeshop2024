<?php

namespace App\Controllers;

use App\Models\DepartamentoModel;

class Departamento extends BaseController
{
    public function index()
    {
        $DepartamentoModel = new DepartamentoModel();

        $data['dados'] = $DepartamentoModel
                            ->groupBy("descricao")
                            ->findAll();

        return view("admin/listaDepartamento", $data);
    }
}