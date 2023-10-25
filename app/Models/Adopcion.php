<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adopcion
 * 
 * @property string $idAdopcion
 * @property Carbon|null $fechaTramiteInicio
 * @property Carbon|null $fechaTramiteFin
 * @property string|null $idAdoptante
 * @property string|null $idExpediente
 * @property string|null $idMiembro
 * @property int|null $aceptacion
 * @property int|null $estado
 * 
 * @property Adoptante|null $adoptante
 * @property Expediente|null $expediente
 * @property Miembro|null $miembro
 *
 * @package App\Models
 */
class Adopcion extends Model
{
	protected $table = 'adopcion';
	protected $primaryKey = 'idAdopcion';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaTramiteInicio' => 'datetime',
		'fechaTramiteFin' => 'datetime',
		'aceptacion' => 'int',
		'estado' => 'int'
	];

	protected $fillable = [
		'fechaTramiteInicio',
		'fechaTramiteFin',
		'idAdoptante',
		'idExpediente',
		'idMiembro',
		'aceptacion',
		'estado'
	];

	public function adoptante()
	{
		return $this->belongsTo(Adoptante::class, 'idAdoptante');
	}

	public function expediente()
	{
		return $this->belongsTo(Expediente::class, 'idExpediente');
	}

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'idMiembro');
	}
}
