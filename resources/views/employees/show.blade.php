@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-user"></i> Employee Details</h4>
                <div>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Employee Number:</strong></td>
                                <td>{{ $employee->employee_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Full Name:</strong></td>
                                <td>{{ $employee->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $employee->phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Position:</strong></td>
                                <td>{{ $employee->position }}</td>
                            </tr>
                            <tr>
                                <td><strong>Department:</strong></td>
                                <td>{{ $employee->department }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gross Salary:</strong></td>
                                <td><span class="badge bg-success">KSh {{ number_format($employee->gross_salary, 2) }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Hire Date:</strong></td>
                                <td>{{ $employee->hire_date->format('F j, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge {{ $employee->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calculator"></i> Salary Breakdown</h5>
            </div>
            <div class="card-body">
                @php
                    $payrollService = new App\Services\PayrollService();
                    $calculations = $payrollService->calculateDeductions($employee->gross_salary);
                @endphp

                <table class="table table-sm">
                    <tr>
                        <td>Gross Salary:</td>
                        <td class="text-end"><strong>KSh {{ number_format($employee->gross_salary, 2) }}</strong></td>
                    </tr>
                    <tr class="table-light">
                        <td>SHIF (2.75%):</td>
                        <td class="text-end text-danger">-KSh {{ number_format($calculations['shif'], 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <td>Housing Levy (1.5%):</td>
                        <td class="text-end text-danger">-KSh {{ number_format($calculations['housing_levy'], 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <td>PAYE (30%):</td>
                        <td class="text-end text-danger">-KSh {{ number_format($calculations['paye'], 2) }}</td>
                    </tr>
                    <tr class="table-warning">
                        <td><strong>Total Deductions:</strong></td>
                        <td class="text-end"><strong class="text-danger">-KSh {{ number_format($calculations['total_deductions'], 2) }}</strong></td>
                    </tr>
                    <tr class="table-success">
                        <td><strong>Net Salary:</strong></td>
                        <td class="text-end"><strong class="text-success">KSh {{ number_format($calculations['net_salary'], 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($recentPayrolls->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history"></i> Recent Payrolls</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th>Gross Salary</th>
                                <th>Total Deductions</th>
                                <th>Net Salary</th>
                                <th>Pay Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->payroll_period }}</td>
                                    <td>KSh {{ number_format($payroll->gross_salary, 2) }}</td>
                                    <td class="text-danger">KSh {{ number_format($payroll->total_deductions, 2) }}</td>
                                    <td class="text-success">KSh {{ number_format($payroll->net_salary, 2) }}</td>
                                    <td>{{ $payroll->pay_date->format('M j, Y') }}</td>
                                    <td>
                                        <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection