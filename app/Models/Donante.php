<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donante
 * 
 * @property string|null $idDonante
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property string|null $dui
 * 
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|TelefonoDonante[] $telefono_donantes
 *
 * @package App\Models
 */
class Donante extends Model
{
	protected $table = 'donante';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'idDonante',
		'nombres',
		'apellidos',
		'dui'
	];

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'idDonante', 'idDonante');
	}

	public function telefono_donantes()
	{
		return $this->hasMany(TelefonoDonante::class, 'idDonante', 'idDonante');
	}
}
