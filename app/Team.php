<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'team_name',
        'room_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'space_type_id',
        'holder',
        'privacy',
        'feed',
        'about',
        'featured',
    ];
    
    public function members() {
        return $this->hasMany(TeamMember::class, 'team_id')->orderBy('created_at', 'desc');
    }
    
    public function owner() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
