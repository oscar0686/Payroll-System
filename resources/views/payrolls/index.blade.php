@extends('layouts.app')

@section('title', 'Payrolls')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-invoice-dollar"></i> Payrolls</h2>
    <a href="{{ route('payrolls.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Generate Payroll
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('payrolls.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="period" class="form-label">Payroll Period</label>
                    <select class="form-control" id="period" name="period">
                        <option value="">All Periods</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->payroll_period }}"
                                {{ request('period') === $period->payroll_period ? 'selected' : '' }}>
                                {{ $period->payroll_period }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-control" id="employee_id" name="employee_id">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('results'))
    <div class="card mb-4">
        <div class="card-header">
            <h5>Bulk Payroll Generation Results</h5>
        </div>
        <div class="card-body">
            @if(!empty(session('results')['success']))
                <div class="alert alert-success">
                    <h6>Successfully Generated ({{ count(session('results')['success']) }}):</h6>
                    <ul class="mb-0">
                        @foreach(session('results')['success'] as $employee)
                            <li>{{ $employee }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty(session('results')['errors']))
                <div class="alert alert-warning">
                    <h6>Errors ({{ count(session('results')['errors']) }}):</h6>
                    <ul class="mb-0">
                        @foreach(session('results')['errors'] as $error)
                            <li>{{ $error['employee'] }}: {{ $error['error'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Gross Salary</th>
                        <th>SHIF</th>
                        <th>Housing Levy</th>
                        <th>PAYE</th>
                        <th>Total Deductions</th>
                        <th>Net Salary</th>
                        <th>Pay Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $payroll->employee->full_name }}</strong><br>
                                    <small class="text-muted">{{ $payroll->employee->employee_number }}</small>
                                </div>
                            </td>
                            <td>{{ $payroll->payroll_period }}</td>
                            <td>KSh {{ number_format($payroll->gross_salary, 2) }}</td>
                            <td class="text-danger">KSh {{ number_format($payroll->shif_deduction, 2) }}</td>
                            <td class="text-danger">KSh {{ number_format($payroll->housing_levy, 2) }}</td>
                            <td class="text-danger">KSh {{ number_format($payroll->paye_tax, 2) }}</td>
                            <td class="text-danger"><strong>KSh {{ number_format($payroll->total_deductions, 2) }}</strong></td>
                            <td class="text-success"><strong>KSh {{ number_format($payroll->net_salary, 2) }}</strong></td>
                            <td>{{ $payroll->pay_date->format('M j, Y') }}</td>
                            <td>
                                <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No payrolls found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $payrolls->withQueryString()->links() }}
    </div>
</div>
@endsection