<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'income';

    protected $fillable = ['name','user_id','charge','m_income_id','date'];

    public function micome()
    {
        return $this->belongsTo(MIncome::class, 'm_income_id');
    }
}
