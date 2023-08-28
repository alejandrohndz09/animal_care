<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TelefonoDonante
 * 
 * @property int $idTelefono
 * @property string|null $telefono
 * @property string|null $idDonante
 * 
 * @property Donante|null $donante
 *
 * @package App\Models
 */
class TelefonoDonante extends Model
{
	protected $table = 'telefono_donante';
	protected $primaryKey = 'idTelefono';
	public $timestamps = false;

	protected $fillable = [
		'telefono',
		'idDonante'
	];

	public function donante()
	{
		return $this->belongsTo(Donante::class, 'idDonante', 'idDonante');
	}
}
