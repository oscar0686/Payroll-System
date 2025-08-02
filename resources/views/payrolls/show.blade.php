@extends('layouts.app')

@section('title', 'Payroll Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-file-invoice-dollar"></i> Payroll Details</h4>
                <div>
                    <button onclick="window.print()" class="btn btn-success btn-sm">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Employee Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-primary">Employee Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Employee Number:</strong></td>
                                <td>{{ $payroll->employee->employee_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Full Name:</strong></td>
                                <td>{{ $payroll->employee->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Position:</strong></td>
                                <td>{{ $payroll->employee->position }}</td>
                            </tr>
                            <tr>
                                <td><strong>Department:</strong></td>
                                <td>{{ $payroll->employee->department }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-primary">Payroll Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Payroll Period:</strong></td>
                                <td>{{ $payroll->payroll_period }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pay Date:</strong></td>
                                <td>{{ $payroll->pay_date->format('F j, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Generated On:</strong></td>
                                <td>{{ $payroll->created_at->format('F j, Y g:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Salary Breakdown -->
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h5 class="text-primary text-center mb-4">Salary Breakdown</h5>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-lg">
                                    <tr class="table-info">
                                        <td class="fs-5"><strong>Gross Salary</strong></td>
                                        <td class="text-end fs-5"><strong>KSh {{ number_format($payroll->gross_salary, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong class="text-danger">Statutory Deductions:</strong></td>
                                    </tr>
                                    <tr class="table-light">
                                        <td class="ps-4">Social Health Insurance Fund (SHIF) - 2.75%</td>
                                        <td class="text-end text-danger">-KSh {{ number_format($payroll->shif_deduction, 2) }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td class="ps-4">Affordable Housing Levy - 1.5%</td>
                                        <td class="text-end text-danger">-KSh {{ number_format($payroll->housing_levy, 2) }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td class="ps-4">Pay As You Earn (PAYE) Tax - 30%</td>
                                        <td class="text-end text-danger">-KSh {{ number_format($payroll->paye_tax, 2) }}</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td class="fs-6"><strong>Total Statutory Deductions</strong></td>
                                        <td class="text-end fs-6"><strong class="text-danger">-KSh {{ number_format($payroll->total_deductions, 2) }}</strong></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td class="fs-4"><strong>NET SALARY</strong></td>
                                        <td class="text-end fs-4"><strong class="text-success">KSh {{ number_format($payroll->net_salary, 2) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h6>Gross Salary</h6>
                                        <h4>KSh {{ number_format($payroll->gross_salary, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h6>Total Deductions</h6>
                                        <h4>KSh {{ number_format($payroll->total_deductions, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h6>Net Salary</h6>
                                        <h4>KSh {{ number_format($payroll->net_salary, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection