<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelForPermission extends Model
{
    use HasFactory;

    protected $table='models';

    protected $fillable=[
        'model',
    ];

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission', 'model_id'); //->selectRaw(['display_name', 'permissions_name', 'group_id']);
    }
}
