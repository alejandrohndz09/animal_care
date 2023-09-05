<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TelefonoMiembro
 * 
 * @property int $idTelefono
 * @property string|null $telefono
 * @property string|null $idMiembro
 * 
 * @property Miembro|null $miembro
 *
 * @package App\Models
 */
class TelefonoMiembro extends Model
{
	protected $table = 'telefono_miembro';
	protected $primaryKey = 'idTelefono';
	public $timestamps = false;

	protected $fillable = [
		'telefono',
		'idMiembro'
	];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'idMiembro');
	}
}
