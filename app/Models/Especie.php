<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Especie
 * 
 * @property int $idEspecie
 * @property string|null $especie
 * 
 * @property Collection|Raza[] $razas
 *
 * @package App\Models
 */
class Especie extends Model
{
	protected $table = 'especie';
	protected $primaryKey = 'idEspecie';
	public $timestamps = false;

	protected $fillable = [
		'especie'
	];

	public function razas()
	{
		return $this->hasMany(Raza::class, 'idEspecie');
	}
}
