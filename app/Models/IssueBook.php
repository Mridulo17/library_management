<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class IssueBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'created_by',
        'issue_date',
        'return_date',
        'is_return',
        'created_at',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id', 'id');
    }
}
