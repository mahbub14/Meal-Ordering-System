<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'meal_date',
        'breakfast',
        'lunch',
        'dinner',
        'status',
    ];


public function employee()
{
    return $this->belongsTo(Employee::class);
}


}
