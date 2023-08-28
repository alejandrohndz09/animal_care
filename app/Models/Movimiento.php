<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movimiento
 * 
 * @property string $idMovimiento
 * @property string|null $descripcion
 * @property Carbon|null $fechaMovimento
 * @property string|null $tipoMovimiento
 * @property float|null $valor
 * @property string|null $idMiembro
 * @property string|null $idRecurso
 * @property string|null $idDonante
 * 
 * @property Miembro|null $miembro
 * @property Recurso|null $recurso
 * @property Donante|null $donante
 *
 * @package App\Models
 */
class Movimiento extends Model
{
	protected $table = 'movimiento';
	protected $primaryKey = 'idMovimiento';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechaMovimento' => 'datetime',
		'valor' => 'float'
	];

	protected $fillable = [
		'descripcion',
		'fechaMovimento',
		'tipoMovimiento',
		'valor',
		'idMiembro',
		'idRecurso',
		'idDonante'
	];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'idMiembro');
	}

	public function recurso()
	{
		return $this->belongsTo(Recurso::class, 'idRecurso');
	}

	public function donante()
	{
		return $this->belongsTo(Donante::class, 'idDonante', 'idDonante');
	}
}
