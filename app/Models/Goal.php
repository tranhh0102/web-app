<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';

    protected $fillable = [
        'user_id',
        'charge',
        'name', 
        'due_date'
    ];

    public function goalTransactions()
    {
        return $this->hasMany(GoalTransaction::class, 'm_saving_id', 'id');
    }
}
