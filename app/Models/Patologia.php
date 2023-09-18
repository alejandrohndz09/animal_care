<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table = 'patologia';
	protected $primaryKey = 'idPatologia';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'patoligia'
	];
}
