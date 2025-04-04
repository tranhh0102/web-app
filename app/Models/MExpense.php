<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MExpense extends Model
{
    use HasFactory;

    protected $table = 'm_expense';

    protected $fillable = ['name','user_id'];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'm_expense_id'); 
    }
}
