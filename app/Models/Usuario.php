<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
/**
 * Class Usuario
 *
 * @property string $idUsuario
 * @property string|null $usuario
 * @property string|null $clave
 * @property string|null $token
 * @property string|null $idMiembro
 * @property int $rol
 * @property int|null $estado
 *
 * @property Miembro|null $miembro
 *
 * @package App\Models
 */

class Usuario extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $table = 'usuario';
    protected $primaryKey = 'idUsuario';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'rol' => 'int',
        'estado' => 'int',
    ];

    protected $hidden = [
        'token',
    ];

    protected $fillable = [
        'usuario',
        'clave',
        'token',
        'idMiembro',
        'rol',
        'estado',
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'idMiembro');
    }
}
