<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expediente
 * 
 * @property string $idExpediente
 * @property string|null $idAnimal
 * @property string|null $idAlvergue
 * @property Carbon|null $fechaIngreso
 * @property string|null $estadoGeneral
 * @property int|null $estado
 * 
 * @property Alvergue|null $alvergue
 * @property Animal|null $animal
 * @property Collection|Adopcion[] $adopcions
 * @property Collection|Historialpatologium[] $historialpatologia
 * @property Collection|Historialvacuna[] $historialvacunas
 *
 * @package App\Models
 */
class Expediente extends Model
{
	protected $table = 'expediente';
	protected $primaryKey = 'idExpediente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaIngreso' => 'datetime',
		'estado' => 'int'
	];

	protected $fillable = [
		'idAnimal',
		'idAlvergue',
		'fechaIngreso',
		'estadoGeneral',
		'estado'
	];

	public function alvergue()
	{
		return $this->belongsTo(Alvergue::class, 'idAlvergue');
	}

	public function animal()
	{
		return $this->belongsTo(Animal::class, 'idAnimal');
	}

	public function adopcions()
	{
		return $this->hasMany(Adopcion::class, 'idExpediente');
	}

	public function historialpatologia()
	{
		return $this->hasMany(Historialpatologium::class, 'idExpediente');
	}

	public function historialvacunas()
	{
		return $this->hasMany(Historialvacuna::class, 'idExpediente');
	}
}
