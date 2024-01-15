<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Miembro
 * 
 * @property string $idMiembro
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property string|null $correo
 * @property int|null $estado
 * @property string|null $dui
 * 
 * @property Collection|Adopcion[] $adopcions
 * @property Collection|Alvergue[] $alvergues
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|TelefonoMiembro[] $telefono_miembros
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Miembro extends Model
{
	protected $table = 'miembro';
	protected $primaryKey = 'idMiembro';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'correo',
		'estado',
		'dui'
	];

	public function adopcions()
	{
		return $this->hasMany(Adopcion::class, 'idMiembro');
	}

	public function alvergues()
	{
		return $this->hasMany(Alvergue::class, 'idMiembro');
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'idMiembro');
	}

	public function telefono_miembros()
	{
		return $this->hasMany(TelefonoMiembro::class, 'idMiembro');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'idMiembro');
	}
}
