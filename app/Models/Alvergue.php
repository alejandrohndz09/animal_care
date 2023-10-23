<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Alvergue
 * 
 * @property string $idAlvergue
 * @property string|null $direccion
 * @property string|null $idMiembro
 * @property int|null $estado
 * 
 * @property Miembro|null $miembro
 * @property Collection|Expediente[] $expedientes
 *
 * @package App\Models
 */
class Alvergue extends Model
{
	protected $table = 'alvergue';
	protected $primaryKey = 'idAlvergue';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'direccion',
		'idMiembro',
		'estado'
	];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'idMiembro');
	}

	public function expedientes()
	{
		return $this->hasMany(Expediente::class, 'idAlvergue');
	}
}
