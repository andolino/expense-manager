<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model {
    use HasFactory;

    protected $table = 'expenses';
    protected $fillable = [ 'id', 'expense_category_id', 'users_id', 'amount', 'created_at' ];
}
