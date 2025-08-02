<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'department',
        'gross_salary',
        'hire_date',
        'status'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'gross_salary' => 'decimal:2'
    ];
      // Relationship with payrolls
      public function payrolls()
      {
          return $this->hasMany(Payroll::class);
      }


    // Get full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    // Generate employee number automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->employee_number)) {
                $employee->employee_number = 'EMP' . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
