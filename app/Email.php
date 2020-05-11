<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'subject',
        'content'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
