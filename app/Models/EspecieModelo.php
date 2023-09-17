<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecieModelo extends Model
{
    protected $table= 'especie';

    protected $primaryKey = 'idEspecie';
	public $incrementing = false;
	public $timestamps = false;

}
