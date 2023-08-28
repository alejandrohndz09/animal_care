<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patologium
 * 
 * @property string $idPatologia
 * @property string|null $patologia
 * 
 * @property Collection|Historialpatologium[] $historialpatologia
 *
 * @package App\Models
 */
class Patologium extends Model
{
	protected $table = 'patologia';
	protected $primaryKey = 'idPatologia';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'patologia'
	];

	public function historialpatologia()
	{
		return $this->hasMany(Historialpatologium::class, 'idPatologia');
	}
}
