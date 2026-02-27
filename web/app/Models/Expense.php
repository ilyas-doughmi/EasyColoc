<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['colocation_id', 'user_id', 'category_id', 'title', 'amount', 'date'];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }
}
