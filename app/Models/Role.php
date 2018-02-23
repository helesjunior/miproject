<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;

class Role extends \Spatie\Permission\Models\Role
{
    protected $fillable = [
        'name', 'description', 'guard_name'
    ];
}
