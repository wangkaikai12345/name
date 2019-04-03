<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use SoftDeletes;

    protected $dates = ['delete_at'];
    //
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
