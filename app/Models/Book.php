<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_name',
        'author_name',
        'price',
        'created_by',
        'is_available',
        'created_at',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // public function delete()
    // {
    //     // delete all related photos 
    //     $this->issue_books()->delete();
    //     // as suggested by Dirk in comment,
    //     // it's an uglier alternative, but faster
    //     // Photo::where("user_id", $this->id)->delete()

    //     // delete the user
    //     return parent::delete();
    // }

}
