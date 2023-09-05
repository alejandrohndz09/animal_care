<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Historialpatologium
 * 
 * @property string $idHistPatologia
 * @property Carbon|null $fechaDiagnostico
 * @property string|null $idPatologia
 * @property string|null $datalles
 * @property string|null $estado
 * @property string|null $idExpediente
 * 
 * @property Patologium|null $patologium
 * @property Expediente|null $expediente
 *
 * @package App\Models
 */
class Historialpatologium extends Model
{
	protected $table = 'historialpatologia';
	protected $primaryKey = 'idHistPatologia';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaDiagnostico' => 'datetime'
	];

	protected $fillable = [
		'fechaDiagnostico',
		'idPatologia',
		'datalles',
		'estado',
		'idExpediente'
	];

	public function patologium()
	{
		return $this->belongsTo(Patologium::class, 'idPatologia');
	}

	public function expediente()
	{
		return $this->belongsTo(Expediente::class, 'idExpediente');
	}
}
