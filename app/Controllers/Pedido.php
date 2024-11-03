<?php

namespace App\Controllers;

use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\PessoaEnderecoModel;

class Pedido extends BaseController
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->model = new PedidoModel();
    }

    /**
     * index (lista)
     *
     * @return void
     */
    public function index()
    {
        $this->dados['data'] = $this->model->getLista([], 'id DESC');

        return view("admin/listaPedido", $this->dados);
    }

    /**
     * form
     *
     * @param integer $id 
     * @param string $action 
     * @return void
     */
    public function viewPedido($pedido_id = 0)
    {
		$PedidoModel = new PedidoModel();
		$PedidoItemModel = new PedidoItemModel();
		$PessoaEnderecoModel = new PessoaEnderecoModel();

        $this->dados['origem'] 		= "view";
        $this->dados['aPedido'] 	= $PedidoModel->where('id', $pedido_id)->first();
        $this->dados['aPedidoItem'] = $PedidoItemModel
                                            ->select("pedidoitem.*, produto.descricao")
                                            ->join("produto", "produto.id = pedidoitem.produto_id")
                                            ->where('pedido_id', $pedido_id)
                                            ->findAll();
        
        $this->dados['aEnderecoCob'] = $PessoaEnderecoModel
                                                ->select("pessoaendereco.*, cidade.nome as cidade, uf.sigla as uf")
                                                ->join("cidade", "cidade.id = pessoaendereco.cidade_id")
                                                ->join("uf", "uf.id = cidade.uf_id")
                                                ->where(['tipoEndereco' => 1,'pessoaendereco.id'=> $this->dados['aPedido']['pessoaendereco_id']])
                                                ->first();

        $this->dados['aEnderecoEnt'] = $PessoaEnderecoModel
                                                ->select("pessoaendereco.*, cidade.nome as cidade, uf.sigla as uf")
                                                ->join("cidade", "cidade.id = pessoaendereco.cidade_id")
                                                ->join("uf", "uf.id = cidade.uf_id")
                                                ->where('pessoaendereco.id', $this->dados['aPedido']['pessoaendereco_id'])
                                                ->first();

        return view('carrinho-confirmacao', $this->dados);


    }   
}