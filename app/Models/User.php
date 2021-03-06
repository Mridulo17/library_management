<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    public function members()
    {
        return $this->hasMany('App\Models\Member', 'created_by', 'id');
    }

    public function books()
    {
        return $this->hasMany('App\Models\Book', 'created_by', 'id');
    }

    public function issueBooks()
    {
        return $this->hasMany('App\Models\IssueBook', 'created_by', 'id');
    }

    // public function delete()
    // {
    //     // delete all related photos 
    //     $this->books()->delete();
    //     // as suggested by Dirk in comment,
    //     // it's an uglier alternative, but faster
    //     // Photo::where("user_id", $this->id)->delete()

    //     // delete the user
    //     return parent::delete();
    // }



    // // this is a recommended way to declare event handlers
    // public static function boot() {
    //     parent::boot();

    //     static::deleting(function($member) { // before delete() method call this
    //          $member->books()->delete();
    //          // do the rest of the cleanup...
    //     });
    // }
}
