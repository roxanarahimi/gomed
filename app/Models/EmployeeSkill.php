<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class,  'employee_id', 'id');
    }
    public function skill()
    {
        return $this->belongsTo(Skill::class,  'skill_id', 'id');
    }
}


