<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    public $table = 'team_members';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public function member() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function team() {
        return $this->belongsTo(Teams::class, 'team_id');
    }
    
}
