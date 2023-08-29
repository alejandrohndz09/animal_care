<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TelefonoAdoptante
 * 
 * @property int $idTelefono
 * @property string|null $telefono
 * @property string|null $idAdoptante
 * 
 * @property Adoptante|null $adoptante
 *
 * @package App\Models
 */
class TelefonoAdoptante extends Model
{
	protected $table = 'telefono_adoptante';
	protected $primaryKey = 'idTelefono';
	public $timestamps = false;

	protected $fillable = [
		'telefono',
		'idAdoptante'
	];

	public function adoptante()
	{
		return $this->belongsTo(Adoptante::class, 'idAdoptante');
	}
}
