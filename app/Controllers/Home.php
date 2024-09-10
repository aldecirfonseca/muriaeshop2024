<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function sobrenos(): string
    {
        return view('sobrenos');
    }

    public function contato(): string
    {
        return view('contato');
    }

    public function login(): string
    {
        return view("login");
    }

    public function criarNovaConta(): string
    {
        return view("criarNovaConta");
    }

    public function carrinhoCompras(): string
    {
        return view("carrinhoCompras");
    }

    public function carrinhoPagamento(): string
    {
        return view("carrinhoPagamento");
    }

    public function carrinhoConfirmacao(): string
    {
        return view("carrinhoConfirmacao");
    }

    public function produtoDetalhe(int $produto_id): string
    {
        return view("produtoDetalhe");
    }
}