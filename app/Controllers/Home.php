<?php

namespace App\Controllers;

use App\Models\ProdutoImagemModel;
use App\Models\ProdutoModel;

class Home extends BaseController
{
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
		$ProdutoModel = new ProdutoModel();

		return view('home', $ProdutoModel->getListaHome());
	}

	/**
	 * Carrega a view Sobre nós
	 *
	 * @return void
	 */
	public function sobrenos()
	{
		return view("sobrenos");
	}

	/**
	 * Carrega a view Contato
	 *
	 * @return void
	 */
	public function contato()
	{
		return view("contato", $this->dados);
	}

	/**
	 * Carrega a view Contato
	 *
	 * @return void
	 */
	public function contatoEnviaEmail()
	{
		$email = \Config\Services::email();
		$email->initialize(CONFIG_EMAIL);

		$post = $this->request->getPost();

		//
		$email->setFrom($post['email'], $post['nome']);				// Quem está enviando o e-mail
		$email->setTo("contatofoody@gmail.com");					// Define o (s) endereço (s) de e-mail do (s) destinatário (s).
//		$email->setCC('another@another-example.com');				// Define o (s) endereço (s) de e-mail CC (cópia)

		$email->setSubject($post['assunto']);						// Define o assunto do e-mail.
		$email->setMessage($post['mensagem']);						// Define o corpo da mensagem de e-mail:
		
		if ($email->send()) {
			return redirect()->to("/contato")->with("msgSucess", "E-mail enviado com sucesso, aguarde em breve entraremos em contato.");
		} else {
			return redirect()->back()->with("msgError", $email->printDebugger('header'))->withInput();
		}
	}

	/**
	 * Carrega a view Login
	 *
	 * @return void
	 */
	public function login()
	{
		return view("login");
	}

	/**
	 * Carrega a view Criar nova Conta
	 *
	 * @return void
	 */
	public function criarNovaConta()
	{
		return view("criar-nova-conta");
	}

	/**
	 * 	Carrega a view carrinho de compras
	 *
	 * @return void
	 */
	public function carrinhoCompras()
	{
		return view('carrinho-compras');
	}

	/**
	 * Carrega a view carrinho pagamento
	 *
	 * @return void
	 */
	public function carrinhoPagamento()
	{
		return view('carrinho-pagamento');
	}

	/**
	 * 	Carrega a view confirmação do carrinho de compras
	 *
	 * @return void
	 */
	public function carrinhoConfirmacao()
	{
		return view('carrinho-confirmacao');
	}

	/**
	 * produtoDetalhe
	 *
	 * @param mixed $id 
	 * @return void
	 */
	public function produtoDetalhe($id)
	{
		$ProdutoModel = new ProdutoModel();
		$ProdutoImagemModel = new ProdutoImagemModel();

		$produto = $ProdutoModel->find($id);
		$produto['imagem'] = $ProdutoImagemModel->where("produto_id", $id)->findAll();
		
		return view('produto-detalhe', $produto);
	}
}