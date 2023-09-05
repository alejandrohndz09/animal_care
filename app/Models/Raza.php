<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Raza
 * 
 * @property int $idRaza
 * @property string|null $raza
 * @property int|null $idEspecie
 * 
 * @property Especie|null $especie
 * @property Collection|Animal[] $animals
 *
 * @package App\Models
 */
class Raza extends Model
{
	protected $table = 'raza';
	protected $primaryKey = 'idRaza';
	public $timestamps = false;

	protected $casts = [
		'idEspecie' => 'int'
	];

	protected $fillable = [
		'raza',
		'idEspecie'
	];

	public function especie()
	{
		return $this->belongsTo(Especie::class, 'idEspecie');
	}

	public function animals()
	{
		return $this->hasMany(Animal::class, 'idRaza');
	}
}
