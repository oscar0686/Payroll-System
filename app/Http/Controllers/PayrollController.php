<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index(Request $request)
    {
        $query = Payroll::with('employee');

        // Filter by payroll period if provided
        if ($request->filled('period')) {
            $query->where('payroll_period', $request->period);
        }

        // Filter by employee if provided
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $payrolls = $query->latest()->paginate(15);
        $employees = Employee::where('status', 'active')->get();
        $periods = Payroll::select('payroll_period')->distinct()->orderBy('payroll_period', 'desc')->get();

        return view('payrolls.index', compact('payrolls', 'employees', 'periods'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payroll_period' => 'required|string',
            'generation_type' => 'required|in:single,bulk',
            'employee_id' => 'required_if:generation_type,single|exists:employees,id',
        ]);

        try {
            if ($request->generation_type === 'single') {
                $employee = Employee::findOrFail($request->employee_id);
                $payroll = $this->payrollService->generatePayroll($employee, $request->payroll_period);

                return redirect()->route('payrolls.show', $payroll)
                    ->with('success', 'Payroll generated successfully for ' . $employee->full_name);
            } else {
                $results = $this->payrollService->generateBulkPayroll($request->payroll_period);

                $message = 'Bulk payroll generation completed. ';
                if (!empty($results['success'])) {
                    $message .= count($results['success']) . ' payrolls generated successfully.';
                }
                if (!empty($results['errors'])) {
                    $message .= ' ' . count($results['errors']) . ' errors occurred.';
                }

                return redirect()->route('payrolls.index')
                    ->with('success', $message)
                    ->with('results', $results);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error generating payroll: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }
}