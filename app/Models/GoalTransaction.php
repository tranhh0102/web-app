<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalTransaction extends Model
{
    use HasFactory;

    protected $table = 'goal_transactions';

    protected $fillable = [
        'charge',
        'user_id',
        'm_saving_id',
    ];  

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'm_saving_id', 'id');
    }
}
