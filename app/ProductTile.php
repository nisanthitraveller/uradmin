<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTile extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'category_id', 
        'title', 
        'duration', 
        'price', 
        'popup_title', 
        'popup_description', 
        'popup_second_title', 
        'popup_first_bullets', 
        'popup_third_title', 
        'popup_second_bullets'
        
    ];
    
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
