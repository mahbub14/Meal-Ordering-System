<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employees_id',
        'name',
        'phone_no',
        'position',
        'organization',
        'department',
    ];

   public function dailyMeals()
{
    return $this->belongsToMany(DailyMeal::class);
}

}
