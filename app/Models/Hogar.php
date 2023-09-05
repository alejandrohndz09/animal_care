<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hogar
 * 
 * @property string $idHogar
 * @property string|null $direccion
 * @property int|null $companiaHumana
 * @property int|null $companiaAnimal
 * @property string|null $tamanioHogar
 * @property int|null $estado
 * 
 * @property Collection|Adoptante[] $adoptantes
 *
 * @package App\Models
 */
class Hogar extends Model
{
	protected $table = 'hogar';
	protected $primaryKey = 'idHogar';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'companiaHumana' => 'int',
		'companiaAnimal' => 'int',
		'estado' => 'int'
	];

	protected $fillable = [
		'direccion',
		'companiaHumana',
		'companiaAnimal',
		'tamanioHogar',
		'estado'
	];

	public function adoptantes()
	{
		return $this->hasMany(Adoptante::class, 'idHogar');
	}
}
