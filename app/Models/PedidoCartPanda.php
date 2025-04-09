<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoCartPanda extends Model
{
    // Definindo os campos que podem ser atribuídos em massa (mass-assigned)
    protected $fillable = [
        'order_number',  // Adicionando o campo 'order_number' à lista de campos preenchíveis
        'total_amount',  // Adicione os outros campos que também devem ser atribuídos em massa
        'status',
    ];
}
