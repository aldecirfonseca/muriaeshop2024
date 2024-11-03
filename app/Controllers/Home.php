<?php

namespace App\Controllers;

use App\Models\DepartamentoModel;
use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\PessoaEnderecoModel;
use App\Models\ProdutoImagemModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;

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
		
		if (is_null(session()->get('aMenuDepartamento'))) {

			$DepartamentoModel = new DepartamentoModel();
			$DepartamentoModel->getMenuDepartamento();
		}

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
		$this->dados['data'] = [];
		return view("criarNovaConta", $this->dados);
	}

	/**
	 * gravarNovaConta
	 *
	 * @return void
	 */
	public function gravarNovaConta()
	{
		$UsuarioModel = new UsuarioModel();

		$post = $this->request->getPost();
		
		// verificar se usuário já tem conta
		$temUsuario = $UsuarioModel->where("email", $post['email'])->first();

		if (is_null($temUsuario)) {

			if (trim($post['senha']) == trim($post['confirmaSenha'])) {

				$created_at = date("Y-m-d H:i:s");
	
				$aPessoa = [
					"nome"		        => $post['nome'],
					"ddd1"		        => $post['ddd1'],
					"celular1"		    => $post['celular1'],
					"statusRegistro"	=> 1,
					"created_at"		=> $created_at,
					"updated_at"		=> $created_at
				]; 
		
				$aEndereco = [
					"tipoEndereco"      => 1,
					"created_at"		=> $created_at,
					"updated_at"		=> $created_at
				];
				
				$aUsuario = [
					"nome"				=> $post['nome'],
					"nivel"				=> 11,                   // 11 = Cliente
					"statusRegistro"	=> 1,
					"email"				=> $post['email'],
					"senha"				=> password_hash(trim($post['senha']), PASSWORD_DEFAULT),
					"pessoa_id"		    => null,
					"created_at"		=> $created_at,
					"updated_at"		=> $created_at
				];
		
				if ($UsuarioModel->insertUsuario($aPessoa, $aEndereco, $aUsuario) > 0) {
					return redirect("criarNovaConta")->with("msgSucess", "Conta Criada com sucesso");
				} else {
	
					session()->set("msgError", $UsuarioModel->errors());
	
					return view('criarNovaConta', [
						'data'		=> $post,
						'errors' 	=> $UsuarioModel->errors()
					]);
				}
	
			} else {
				session()->setFlashdata("msgError", "Senhas não conferem.");
			} 
			
		} else {
			session()->setFlashdata("msgError", "Usuário já existe na plataforma.");
		}

		return view('criarNovaConta', [
				'data'		=> $post,
				'errors' 	=> []
			]);

	}

	/**
	 * addProdutoCarrinho
	 *
	 * @return void
	 */
	public function addProdutoCarrinho()
	{
		$ProdutoModel 		= new ProdutoModel();
		$ProdutoImagemModel = new ProdutoImagemModel();

		$post 			= $this->request->getPost();
		$aProduto 		= $ProdutoModel->where("id", $post['produto_id'])->first();
		$aProdutoImagem = $ProdutoImagemModel->where("produto_id", $post['produto_id'])->orderBy('created_at')->first();

		$aCarrinhoItens = session()->get("CarrinhoItens");

		if (is_null($aCarrinhoItens)) {
			$aCarrinhoItens = [];
		}

		$posicao = array_search($post['produto_id'], array_column($aCarrinhoItens, 'produto_id'));

		if ($posicao === false) {

			$aCarrinhoItens[] = [
				'produto_id' => $post['produto_id'],
				'descricao' => $aProduto['descricao'],
				"quantidade" => 1,
				"valorUnitario" => $aProduto['precoVenda'],
				"valorTotal" => $aProduto['precoVenda'],
				'imagem' => $aProdutoImagem['nomeArquivo']
			];

		} else {

			$aCarrinhoItens[$posicao]['quantidade'] = $aCarrinhoItens[$posicao]['quantidade'] + 1;
			$aCarrinhoItens[$posicao]['valorTotal'] = $aCarrinhoItens[$posicao]['quantidade'] * $aCarrinhoItens[$posicao]['valorUnitario'];

		}

		session()->set("CarrinhoItens", $aCarrinhoItens);
	}

	/**
	 * atualizaProdutoCarrinho
	 *
	 * @return void
	 */
	public function atualizaProdutoCarrinho()
	{
		$post = $this->request->getPost();
		$aCarrinhoItens = session()->get("CarrinhoItens");

		$posicao = array_search((int)$post['produto_id'], array_column($aCarrinhoItens, 'produto_id'));

		if ($posicao !== false) {

			if ($post['quantidade'] == 0) {
				array_splice($aCarrinhoItens, $posicao, 1);
			} else {
				$aCarrinhoItens[$posicao]['quantidade'] = $post['quantidade'];
				$aCarrinhoItens[$posicao]['valorTotal'] = $aCarrinhoItens[$posicao]['quantidade'] * $aCarrinhoItens[$posicao]['valorUnitario'];
			}
		} 

		session()->set("CarrinhoItens", $aCarrinhoItens);
	}

	/**
	 * atualizaFrete
	 *
	 * @return void
	 */
	public function atualizaFrete() 
	{
		$post = $this->request->getPost();

		$aCarrinho = session()->get("Carrinho");

		$aCarrinho["tipoFrete"] = $post['tipoFrete'];

		session()->set("Carrinho", $aCarrinho);
	}


	/**
	 * atualizaFormaPagamento
	 *
	 * @return void
	 */
	public function atualizaCarrinho() 
	{
		$post = $this->request->getPost();

		$aCarrinho = session()->get("Carrinho");

		$aCarrinho["formaPagamento"] 	= $post['formaPagamento'];
		$aCarrinho['aceitaTermos']		= $post['aceitaTermos'];

		if ($post['pessoaendereco_id'] > 0) {
			$aCarrinho['pessoaendereco_id'] = $post['pessoaendereco_id'];
		}

		session()->set("Carrinho", $aCarrinho);
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
		$PessoaEnderecoModel = new PessoaEnderecoModel();

		$this->dados['aPessoaEndereco'] = $PessoaEnderecoModel
												->select("pessoaendereco.*, cidade.nome as cidade, uf.sigla as uf")
												->join("cidade", "cidade.id = pessoaendereco.cidade_id")
												->join("uf", "uf.id = cidade.uf_id")
												->where('pessoaendereco.pessoa_id', session()->get('userPessoa_id') )
												->findAll();

		return view('carrinho-pagamento', $this->dados);
	}

	/**
	 * 	Carrega a view confirmação do carrinho de compras
	 *
	 * @return void
	 */
	public function carrinhoConfirmacao()
	{
		$PedidoModel = new PedidoModel();
		$PedidoItemModel = new PedidoItemModel();
		$PessoaEnderecoModel = new PessoaEnderecoModel();

		$aCarrinho = session()->get("Carrinho");
		$aCarrinhoItens = session()->get("CarrinhoItens");

		// preparando o pedido

		$aCarrinho['pessoa_id'] = session()->get('userPessoa_id');
		$aCarrinho['statusRegistro'] = 1;

		$valorProdutos = 0;
		$valorFrete = 0;

		for ($xyx = 0; $xyx < count($aCarrinhoItens); $xyx++) {
			$valorProdutos += $aCarrinhoItens[$xyx]['valorTotal'];

			unset($aCarrinhoItens[$xyx]['descricao']);
			unset($aCarrinhoItens[$xyx]['imagem']);
		}

		if ($aCarrinho['tipoFrete'] == 2) {
			$valorFrete = 15;
		}

		$aCarrinho['valorProdutos'] = $valorProdutos;
		$aCarrinho['valorFrete'] 	= $valorFrete;
		$aCarrinho['valorTotal'] 	= ($valorProdutos + $valorFrete);

		unset($aCarrinho['aceitaTermos']);
		unset($aCarrinho['endereco_id']);
		
		// Status

		$aStatus['statusRegistro'] 	= 1;
		$aStatus['usuario_id'] 		= session()->get('userId');

		$pedido_id = $PedidoModel->insertPedido($aCarrinho, $aCarrinhoItens, $aStatus);

		if ($pedido_id == 0) {
			redirect()->to("/carrinhoPagamento");
		} else {

			$this->dados['origem'] 		= "confirmacaoPedido";
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

			session()->set("Carrinho", null);
			session()->set("CarrinhoItens", null);

			return view('carrinho-confirmacao', $this->dados);
		}
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