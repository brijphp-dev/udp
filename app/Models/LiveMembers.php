<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveMembers extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'membership';

    protected $guarded = [];

    const UPDATED_AT = null;

    public function memberCardDetail()
    {
        return $this->hasOne('App\Models\LiveMemberCard', 'MembershipID', 'MembershipID');
    }
}
