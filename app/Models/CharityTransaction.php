<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityTransaction extends Model
{
    use HasFactory;

    protected $table = 'charity_transactions';

    protected $fillable = ['charge','name','user_id'];
}
