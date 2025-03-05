<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $table = 'statistic';

    const TYPE_EXPENSE = 1;
    const TYPE_INCOME = 2;
    const TYPE_GOAL = 3;
    const TYPE_CHARITY = 4;
}
