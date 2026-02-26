<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Invitation;

class Colocation extends Model
{
    protected $fillable = ['name','status'];

    public function User()
    {
       return $this->belongsToMany(User::class)->withPivot('role','status','joined_at');
    }

    public function Invitation()
    {
        return $this->hasMany(Invitation::class);
    }
}
