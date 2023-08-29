<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vacuna
 * 
 * @property string $idVacuna
 * @property string|null $vacuna
 * 
 * @property Collection|Historialvacuna[] $historialvacunas
 *
 * @package App\Models
 */
class Vacuna extends Model
{
	protected $table = 'vacuna';
	protected $primaryKey = 'idVacuna';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'vacuna'
	];

	public function historialvacunas()
	{
		return $this->hasMany(Historialvacuna::class, 'idVacuna');
	}
}
