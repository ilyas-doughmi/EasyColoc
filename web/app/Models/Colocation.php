<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
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

    public function expenses()
    {
        return $this->hasMany(Expense::class)->latest();
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('name');
    }
}
