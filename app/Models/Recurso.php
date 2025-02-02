<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recurso
 * 
 * @property string $idRecurso
 * @property string|null $recurso
 * @property string|null $idCategoria
 * @property float|null $cantidad
 * @property string|null $idUnidadMedida
 * @property int|null $estado
 * 
 * @property Categorium|null $categorium
 * @property UnidadMedida|null $unidadmedida
 * @property Collection|Movimiento[] $movimientos
 *
 * @package App\Models
 */
class Recurso extends Model
{
	protected $table = 'recurso';
	protected $primaryKey = 'idRecurso';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'cantidad' => 'float',
		'estado' => 'int'
	];

	protected $fillable = [
		'recurso',
		'idCategoria',
		'cantidad',
		'idUnidadMedida',
		'estado'
	];

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'idCategoria');
	}

	public function unidadmedida()
	{
		return $this->belongsTo(UnidadMedida::class, 'idUnidadMedida');
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'idRecurso');
	}
}
