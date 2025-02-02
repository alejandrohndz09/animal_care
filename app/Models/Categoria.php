<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categorium
 * 
 * @property string $idCategoria
 * @property string|null $categoria
 * 
 * @property Collection|Recurso[] $recursos
 * @property Collection|UnidadMedida[] $unidadmedidas
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categoria';
	protected $primaryKey = 'idCategoria';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'categoria'
	];

	public function recursos()
	{
		return $this->hasMany(Recurso::class, 'idCategoria');
	}

	public function unidadmedidas()
	{
		return $this->hasMany(UnidadMedida::class, 'idCategoria');
	}
}
