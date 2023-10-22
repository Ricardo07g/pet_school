<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'usuarios'; // Nome da sua tabela de usuários
    protected $primaryKey = 'id_usuario'; // Nome da chave primária da tabela
    protected $fillable = ['nome', 'email', 'senha'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['senha','remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /*
    public function setPasswordAttribute($password)
    {
        $this->attributes['senha'] = Hash::make($password);
    }
    */

    public function getAuthPassword()
    {
        return $this->senha;
    }

    /*
    protected function guard()
    {
        return Auth::guard('usuariosGuard'); // Substitua 'web' pelo nome da sua guarda, se for diferente
    }
    */

}



/*

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
}
*/