<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Animal
 * 
 * @property string $idAnimal
 * @property string|null $nombre
 * @property Carbon|null $fechaNacimiento
 * @property string|null $sexo
 * @property string|null $particularidad
 * @property string|null $idRaza
 * @property string|null $imagen
 * @property int $estado
 * 
 * @property Raza|null $raza
 * @property Collection|Expediente[] $expedientes
 *
 * @package App\Models
 */
class Animal extends Model
{
	protected $table = 'animal';
	protected $primaryKey = 'idAnimal';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaNacimiento' => 'datetime',
		'estado' => 'int'
	];

	protected $fillable = [
		'nombre',
		'fechaNacimiento',
		'sexo',
		'particularidad',
		'idRaza',
		'imagen',
		'estado'
	];

	public function raza()
	{
		return $this->belongsTo(Raza::class, 'idRaza');
	}

	public function expedientes()
	{
		return $this->hasMany(Expediente::class, 'idAnimal');
	}
}
