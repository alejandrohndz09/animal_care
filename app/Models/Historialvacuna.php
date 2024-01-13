<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Historialvacuna
 * 
 * @property string $idHistVacuna
 * @property Carbon|null $fechaAplicacion
 * @property int|null $dosis
 * @property string|null $idVacuna
 * @property string|null $idExpediente
 * 
 * @property Vacuna|null $vacuna
 * @property Expediente|null $expediente
 *
 * @package App\Models
 */
class Historialvacuna extends Model
{
	protected $table = 'historialvacuna';
	protected $primaryKey = 'idHistVacuna';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaAplicacion' => 'datetime',
		'dosis' => 'int'
	];

	protected $fillable = [
		'fechaAplicacion',
		'dosis',
		'idVacuna',
		'idExpediente'
	];

	public function vacuna()
	{
		return $this->belongsTo(Vacuna::class, 'idVacuna');
	}

	public function expediente()
	{
		return $this->belongsTo(Expediente::class, 'idExpediente');
	}
}
