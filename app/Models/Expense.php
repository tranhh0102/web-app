<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expense';

    protected $fillable = ['name','user_id','charge','m_expense_id','date'];

    public function mexpense()
    {
        return $this->belongsTo(MExpense::class, 'm_expense_id');
    }
}
