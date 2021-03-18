<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MindBranch extends Model
{
    protected $table = 'mind_branches';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
