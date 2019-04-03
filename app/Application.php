<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $dates = ['delete_at'];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNum($query)
    {
        return $query->where('user_id', auth()->id())->count();
    }
}
