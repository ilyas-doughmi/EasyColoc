<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Colocation extends Model
{
    protected $fillable = ['name', 'code', 'status'];

    public function User()
    {
       return $this->belongsToMany(User::class);
    }
}
