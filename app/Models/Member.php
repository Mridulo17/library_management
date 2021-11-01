<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'created_by',
        'created_at',
    ];

    protected $hidden = [
        'updated_at', 
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // public static function boot() {
    //     parent::boot();

    //     static::deleting(function($member) { // before delete() method call this
    //          $member->issue_books()->delete();
    //          // do the rest of the cleanup...
    //     });
    // }
}
