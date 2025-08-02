<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payroll_period',
        'gross_salary',
        'shif_deduction',
        'housing_levy',
        'paye_tax',
        'total_deductions',
        'net_salary',
        'pay_date'
    ];


    protected $casts = [
        'gross_salary' => 'decimal:2',
        'shif_deduction' => 'decimal:2',
        'housing_levy' => 'decimal:2',
        'paye_tax' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'pay_date' => 'date'
    ];


    // Relationship with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
