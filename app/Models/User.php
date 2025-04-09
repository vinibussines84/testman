<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;  // Adicionando a trait Notifiable

class User extends Authenticatable
{
    use HasFactory, Notifiable;  // Incluindo a trait Notifiable

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'merchant_name',  // Se você precisar de um campo 'merchant_name' para o usuário, adicione aqui
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to a specific type.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relacionamento: Um usuário tem uma chave (Keys).
     *
     * A chave primária do modelo `Keys` agora é `user_id`, portanto,
     * vamos garantir que o relacionamento esteja configurado corretamente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function key()
    {
        return $this->hasOne(Keys::class, 'user_id', 'id');  // Relacionamento baseado no user_id
    }

    /**
     * Método para obter o Merchant Name do usuário.
     *
     * Se o campo 'merchant_name' existe no modelo, podemos acessar diretamente.
     * Caso contrário, você pode substituir por uma lógica personalizada.
     *
     * @return string|null
     */
    // Adicionar qualquer outra lógica ou métodos extras que você precise aqui.
}
