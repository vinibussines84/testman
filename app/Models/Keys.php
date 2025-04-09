<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keys extends Model
{
    // Defina o `user_id` como a chave primária
    protected $primaryKey = 'user_id';  // 'user_id' agora será a chave primária no modelo Keys

    // Indica que o campo 'user_id' é um campo inteiro
    protected $keyType = 'int';

    // Define que o campo `user_id` não é auto incrementável
    public $incrementing = false;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'shop_slug',
        'authorization',
        'token',
        'x_api_key',
        'user_id',  // Relacionamento com o usuário
    ];

    // Relacionamento com o usuário
    public function user()
    {
        // Aqui garantimos que todos os campos do usuário serão carregados
        return $this->belongsTo(User::class, 'user_id', 'id');  // A chave estrangeira é 'user_id'
    }

    // Método para obter o merchant_name associado ao usuário
    public function getMerchantNameAttribute()
    {
        return $this->user ? $this->user->merchant_name : null;
    }

    // Método para setar o merchant_name
    public function setMerchantNameAttribute($value)
    {
        // Quando o merchant_name é alterado, também altera no usuário relacionado
        if ($this->user) {
            $this->user->merchant_name = $value;
            $this->user->save(); // Salva a alteração no usuário
        }
    }
}
