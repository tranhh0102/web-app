<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MIncome extends Model
{
    use HasFactory;

    protected $table = 'm_income';

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class, 'm_income_id');
    }
}
