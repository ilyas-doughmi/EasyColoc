<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['token','colocation_id','email','is_active'];
    
    public function colocations()
    {
        return $this->belongsTo(Colocation::class);
    }
}
