@extends('layouts.app')

@section('title', 'Generate Payroll')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-calculator"></i> Generate Payroll</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('payrolls.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="payroll_period" class="form-label">Payroll Period</label>
                        <input type="month" class="form-control @error('payroll_period') is-invalid @enderror"
                               id="payroll_period" name="payroll_period" value="{{ old('payroll_period', date('Y-m')) }}" required>
                        @error('payroll_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Select the year and month for payroll generation.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Generation Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="generation_type" id="single" value="single"
                                   {{ old('generation_type', 'single') === 'single' ? 'checked' : '' }}>
                            <label class="form-check-label" for="single">
                                <strong>Single Employee</strong>
                                <small class="d-block text-muted">Generate payroll for a specific employee</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="generation_type" id="bulk" value="bulk"
                                   {{ old('generation_type') === 'bulk' ? 'checked' : '' }}>
                            <label class="form-check-label" for="bulk">
                                <strong>Bulk Generation</strong>
                                <small class="d-block text-muted">Generate payroll for all active employees</small>
                            </label>
                        </div>
                        @error('generation_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" id="employee-select" style="{{ old('generation_type', 'single') === 'bulk' ? 'display: none;' : '' }}">
                        <label for="employee_id" class="form-label">Select Employee</label>
                        <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id">
                            <option value="">Choose an employee...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    data-salary="{{ $employee->gross_salary }}"
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }} ({{ $employee->employee_number }}) - KSh {{ number_format($employee->gross_salary, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Salary Preview -->
                    <div class="card mb-4" id="salary-preview" style="display: none;">
                        <div class="card-header">
                            <h6><i class="fas fa-calculator"></i> Salary Breakdown Preview</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td>Gross Salary:</td>
                                    <td class="text-end"><strong id="preview-gross">KSh 0.00</strong></td>
                                </tr>
                                <tr class="table-light">
                                    <td>SHIF (2.75%, max KSh 1,800):</td>
                                    <td class="text-end text-danger" id="preview-shif">-KSh 0.00</td>
                                </tr>
                                <tr class="table-light">
                                    <td>Housing Levy (1.5%):</td>
                                    <td class="text-end text-danger" id="preview-housing">-KSh 0.00</td>
                                </tr>
                                <tr class="table-light">
                                    <td>PAYE (30%):</td>
                                    <td class="text-end text-danger" id="preview-paye">-KSh 0.00</td>
                                </tr>
                                <tr class="table-warning">
                                    <td><strong>Total Deductions:</strong></td>
                                    <td class="text-end"><strong class="text-danger" id="preview-deductions">-KSh 0.00</strong></td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Net Salary:</strong></td>
                                    <td class="text-end"><strong class="text-success" id="preview-net">KSh 0.00</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-play"></i> Generate Payroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const singleRadio = document.getElementById('single');
    const bulkRadio = document.getElementById('bulk');
    const employeeSelect = document.getElementById('employee-select');
    const employeeDropdown = document.getElementById('employee_id');
    const salaryPreview = document.getElementById('salary-preview');

    // Toggle employee select visibility
    function toggleEmployeeSelect() {
        if (singleRadio.checked) {
            employeeSelect.style.display = 'block';
            updateSalaryPreview();
        } else {
            employeeSelect.style.display = 'none';
            salaryPreview.style.display = 'none';
        }
    }

    // Update salary preview
    function updateSalaryPreview() {
        const selectedOption = employeeDropdown.options[employeeDropdown.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.salary) {
            const grossSalary = parseFloat(selectedOption.dataset.salary);

            // Calculate deductions
            const shif = Math.min(grossSalary * 0.0275, 1800);
            const housingLevy = grossSalary * 0.015;
            const paye = grossSalary * 0.30;
            const totalDeductions = shif + housingLevy + paye;
            const netSalary = grossSalary - totalDeductions;

            // Update preview
            document.getElementById('preview-gross').textContent = 'KSh ' + grossSalary.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('preview-shif').textContent = '-KSh ' + shif.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('preview-housing').textContent = '-KSh ' + housingLevy.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('preview-paye').textContent = '-KSh ' + paye.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('preview-deductions').textContent = '-KSh ' + totalDeductions.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('preview-net').textContent = 'KSh ' + netSalary.toLocaleString('en-US', {minimumFractionDigits: 2});

            salaryPreview.style.display = 'block';
        } else {
            salaryPreview.style.display = 'none';
        }
    }

    singleRadio.addEventListener('change', toggleEmployeeSelect);
    bulkRadio.addEventListener('change', toggleEmployeeSelect);
    employeeDropdown.addEventListener('change', updateSalaryPreview);

    // Initialize
    toggleEmployeeSelect();
});
</script>
@endsection