<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    /*public function resolveRouteBinding($voterId, $field = null)
    {
        return $this->where('id', decode_url($voterId))->firstOrFail();
    }*/

    public function wardName()
    {
        return $this->belongsTo('App\Models\Pollingward', 'polling_ward');
    }
}
