<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mind extends Model
{
	protected $table = 'minds';
	protected $casts = [
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
	];
}
