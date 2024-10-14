<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'nivel', 'statusRegistro', "email", 'senha', 'pessoa_id'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules = [
        'nome' => [
            "label" => 'Nome',
            'rules' => 'required|min_length[3]|max_length[50]'
        ],
        'nivel' => [
            'label' => 'Nível',
            'rules' => 'required|integer'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|integer'
        ],
        'email' => [
            "label" => 'E-mail',
            'rules' => 'required|valid_email'
        ],
    ];

    /**
     * getByEmail
     *
     * @param string $email 
     * @return array
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * insertDadosSuperUser
     *
     * @param array $aPessoa 
     * @param array $aEndereco 
     * @param array $aUsuario 
     * @return integer
     */
    public function insertDadosSuperUser() 
    {
        $CidadeModel = new CidadeModel();

        $aCidade = $CidadeModel->getCidade("MG", "Muriae");
        $created_at = date("Y-m-d H:i:s");

        $aPessoa = [
            "nome"		        => "Muriae Shop",
            "ddd1"		        => "32",
            "celular1"		    => "987654321",
            "statusRegistro"	=> 1,
            "created_at"		=> $created_at,
            "updated_at"		=> $created_at
        ]; 

        $aEndereco = [
            "tipoEndereco"      => 1,
            "logradouro"        => "Praça Irmã Annina Bisegna",
            "numero"            => "40",
            "complemento"       => "",
            "bairro"            => "Centro",
            "cep"               => "36880083",
            "cidade_id"         => $aCidade['id'],
            "created_at"		=> $created_at,
            "updated_at"		=> $created_at
        ];
        
        $aUsuario = [
            "nome"				=> "Administrador",
            "nivel"				=> 1,                   // 1 = Administrador
            "statusRegistro"	=> 1,
            "email"				=> "administrador@muriaeshop.com.br",
            "senha"				=> password_hash("fasm@2024", PASSWORD_DEFAULT),
            "pessoa_id"		    => null,
            "created_at"		=> $created_at,
            "updated_at"		=> $created_at
        ];

        //

        $db = \Config\Database::connect();

        $db->transBegin();      // Inicia controle de transação

        // insere a Empresa
        $tbPessoa = $db->table("pessoa");
        $tbPessoa->insert($aPessoa);

        $pessoa_id = $db->insertID();

        if ($pessoa_id > 0) {

            // Insere o usuário

            $aUsuario['pessoa_id']  = $pessoa_id;
            $aEndereco['pessoa_id'] = $pessoa_id;

            $tbEndereco = $db->table("pessoaendereco");
            $tbEndereco->insert($aEndereco);

            $tbUsuario = $db->table("usuario");
            $tbUsuario->insert($aUsuario);

            $usuario_id = $db->insertID();

            //

            if ($db->transStatus() === FALSE) {
                $db->transRollback();               // Defaz o que foi feito na base de dados
                return 0;
            } else {
                $db->transCommit();                 // Confirmar a gravação dos dados na base dados
                return $usuario_id;
            }

        } else {
            $db->transRollback();                   // Defaz o que foi feito na base de dados
            return 0;           
        }
    }
}