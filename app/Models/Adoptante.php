<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adoptante
 * 
 * @property string $idAdoptante
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property string|null $dui
 * @property string|null $idHogar
 * @property int|null $estado
 * 
 * @property Hogar|null $hogar
 * @property Collection|Adopcion[] $adopcions
 * @property Collection|TelefonoAdoptante[] $telefono_adoptantes
 *
 * @package App\Models
 */
class Adoptante extends Model
{
	protected $table = 'adoptante';
	protected $primaryKey = 'idAdoptante';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'estado' => 'int'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'dui',
		'idHogar',
		'estado'
	];

	public function hogar()
	{
		return $this->belongsTo(Hogar::class, 'idHogar');
	}

	public function adopcions()
	{
		return $this->hasMany(Adopcion::class, 'idAdoptante');
	}

	public function telefono_adoptantes()
	{
		return $this->hasMany(TelefonoAdoptante::class, 'idAdoptante');
	}
}
