<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unidadmedida
 * 
 * @property string $idUnidadMedida
 * @property string|null $unidadMedida
 * @property string|null $simbolo
 * @property string|null $idCategoria
 * 
 * @property Categoria|null $categorium
 * @property Collection|Recurso[] $recursos
 *
 * @package App\Models
 */
class Unidadmedida extends Model
{
	protected $table = 'unidadmedida';
	protected $primaryKey = 'idUnidadMedida';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'unidadMedida',
		'simbolo',
		'idCategoria'
	];

	public function categorium()
	{
		return $this->belongsTo(Categoria::class, 'idCategoria');
	}

	public function recursos()
	{
		return $this->hasMany(Recurso::class, 'idUnidadMedida');
	}
}
