<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;

class PayrollService
{
    /**
     * Calculate statutory deductions for an employee
     */
    public function calculateDeductions($grossSalary)
    {
        $calculations = [];

        // SHIF Deduction (2.75% of gross salary, max KSh 1,800)
        $calculations['shif'] = min($grossSalary * 0.0275, 1800);

        // Housing Levy (1.5% of gross salary)
        $calculations['housing_levy'] = $grossSalary * 0.015;

        // PAYE Tax (30% of gross salary - simplified)
        // Note: In reality, PAYE has progressive rates and personal relief
        $calculations['paye'] = $grossSalary * 0.30;

        // Total deductions
        $calculations['total_deductions'] =
            $calculations['shif'] +
            $calculations['housing_levy'] +
            $calculations['paye'];

        // Net salary
        $calculations['net_salary'] = $grossSalary - $calculations['total_deductions'];

        return $calculations;
    }

    /**
     * Generate payroll for an employee
     */
    public function generatePayroll(Employee $employee, $payrollPeriod)
    {
        // Check if payroll already exists for this period
        $existingPayroll = Payroll::where('employee_id', $employee->id)
            ->where('payroll_period', $payrollPeriod)
            ->first();

        if ($existingPayroll) {
            throw new \Exception('Payroll already exists for this employee in this period.');
        }

        // Calculate deductions
        $calculations = $this->calculateDeductions($employee->gross_salary);

        // Create payroll record
        return Payroll::create([
            'employee_id' => $employee->id,
            'payroll_period' => $payrollPeriod,
            'gross_salary' => $employee->gross_salary,
            'shif_deduction' => $calculations['shif'],
            'housing_levy' => $calculations['housing_levy'],
            'paye_tax' => $calculations['paye'],
            'total_deductions' => $calculations['total_deductions'],
            'net_salary' => $calculations['net_salary'],
            'pay_date' => now(),
        ]);
    }

    /**
     * Generate payroll for all active employees
     */
    public function generateBulkPayroll($payrollPeriod)
    {
        $employees = Employee::where('status', 'active')->get();
        $results = [];

        foreach ($employees as $employee) {
            try {
                $payroll = $this->generatePayroll($employee, $payrollPeriod);
                $results['success'][] = $employee->full_name;
            } catch (\Exception $e) {
                $results['errors'][] = [
                    'employee' => $employee->full_name,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }
}