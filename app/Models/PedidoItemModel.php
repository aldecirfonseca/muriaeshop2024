<?php

namespace App\Models;

class PedidoItemModel extends BaseModel
{
    protected $table = 'pedidoitem';
    protected $primaryKey = 'id';

    protected $allowedFields = ['pedido_id', 'produto_id', 'quantidade', 'valorUnitario', 'valorTotal'];

    protected $useTimestamps = true;
}