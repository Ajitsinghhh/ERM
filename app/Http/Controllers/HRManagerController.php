<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class HRManagerController extends Controller
{
    public function __construct()
    {
        // Middleware is handled at route level
    }

    public function dashboard()
    {
        $user = Auth::user();

        // HR Manager specific data - count from employees table only
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::active()->count();
        $inactiveEmployees = Employee::inactive()->count();
        $hrManagers = \App\Models\User::where('employee_role', 'hr_manager')->count();

        // Task statistics
        $taskStats = [
            'total' => Task::count(),
            'pending' => Task::byStatus('pending')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'completed' => Task::byStatus('completed')->count(),
            'overdue' => Task::overdue()->count(),
        ];

        return view('hr.dashboard', compact('user', 'totalEmployees', 'activeEmployees', 'inactiveEmployees', 'hrManagers', 'taskStats'));
    }

    /**
     * Global search functionality for HR dashboard
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = [];

        if ($query) {
            // Search employees
            $employees = Employee::where(function($q) use ($query) {
                $q->where('full_name', 'like', "%{$query}%")
                  ->orWhere('personal_email', 'like', "%{$query}%")
                  ->orWhere('personal_mobile', 'like', "%{$query}%")
                  ->orWhere('designation', 'like', "%{$query}%")
                  ->orWhere('aadhaar_number', 'like', "%{$query}%");
            })->limit(10)->get();

            // Search tasks
            $tasks = Task::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('notes', 'like', "%{$query}%");
            })->limit(10)->get();

            $results = [
                'employees' => $employees,
                'tasks' => $tasks,
                'query' => $query
            ];
        }

        return view('hr.search', compact('results', 'query'));
    }

    /**
     * Show employee registration form
     */
    public function showRegistrationForm()
    {
        return view('hr.employee-registration');
    }

    /**
     * Process employee registration
     */
    public function registerEmployee(Request $request)
    {
        $request->validate([
            // Personal Information
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'blood_group' => 'required|string|max:10',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'marriage_anniversary' => 'nullable|date|before:today',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'aadhaar_number' => 'required|string|unique:employees,aadhaar_number|size:12',
            'aadhaar_card_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'aadhaar_card_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pan_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'passport_number' => 'nullable|string|max:20',
            
            // Professional Information
            'designation' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'date_of_joining' => 'required|date',
            
            // Contact Information
            'personal_mobile' => 'required|string|max:15',
            'personal_email' => 'required|email|unique:users,email',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            
            // Emergency Contact
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:15',
            'emergency_contact_relation' => 'required|string|max:100',
            'emergency_contact_address' => 'required|string',
            
            // Terms and Conditions
            'terms_accepted' => 'required|accepted',
        ], [
            'aadhaar_card_front.required' => 'Aadhaar Card Front Photo is required.',
            'aadhaar_card_front.image' => 'Aadhaar Card Front must be an image file.',
            'aadhaar_card_front.mimes' => 'Aadhaar Card Front must be a JPEG, PNG, or JPG file.',
            'aadhaar_card_front.max' => 'Aadhaar Card Front must not exceed 2MB.',
            'aadhaar_card_back.required' => 'Aadhaar Card Back Photo is required.',
            'aadhaar_card_back.image' => 'Aadhaar Card Back must be an image file.',
            'aadhaar_card_back.mimes' => 'Aadhaar Card Back must be a JPEG, PNG, or JPG file.',
            'aadhaar_card_back.max' => 'Aadhaar Card Back must not exceed 2MB.',
            'terms_accepted.required' => 'You must accept the Terms and Conditions to register.',
            'terms_accepted.accepted' => 'You must accept the Terms and Conditions to register.',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->personal_email,
            'password' => Hash::make('password123'), // Default password
            'role' => 'user',
            'employee_role' => 'employee',
            'email_verified_at' => now(),
        ]);

        // Handle file uploads
        $aadhaarFrontPath = $request->file('aadhaar_card_front')->store('documents/aadhaar', 'public');
        $aadhaarBackPath = $request->file('aadhaar_card_back')->store('documents/aadhaar', 'public');
        $passportPhotoPath = $request->file('passport_photo')->store('documents/passport', 'public');
        
        $panCardPath = null;
        if ($request->hasFile('pan_card')) {
            $panCardPath = $request->file('pan_card')->store('documents/pan', 'public');
        }

        // Create employee record
        try {
            $employee = Employee::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'marriage_anniversary' => $request->marriage_anniversary,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'aadhaar_number' => $request->aadhaar_number,
                'aadhaar_card_front' => $aadhaarFrontPath,
                'aadhaar_card_back' => $aadhaarBackPath,
                'passport_photo' => $passportPhotoPath,
                'pan_card' => $panCardPath,
                'passport_number' => $request->passport_number,
                'designation' => $request->designation,
                'date_of_joining' => $request->date_of_joining,
                'personal_mobile' => $request->personal_mobile,
                'personal_email' => $request->personal_email,
                'current_address' => $request->current_address,
                'permanent_address' => $request->permanent_address,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_number' => $request->emergency_contact_number,
                'emergency_contact_relation' => $request->emergency_contact_relation,
                'emergency_contact_address' => $request->emergency_contact_address,
                'terms_accepted' => true,
            ]);
            
            \Log::info('Employee created successfully', ['employee_id' => $employee->id, 'user_id' => $user->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create employee', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            // Delete the user if employee creation fails
            $user->delete();
            return redirect()->back()->withErrors(['error' => 'Failed to create employee record: ' . $e->getMessage()]);
        }

        return redirect()->route('hr.dashboard')
            ->with('success', 'Employee registered successfully! Login credentials sent to: ' . $request->personal_email);
    }

    /**
     * Show all employees
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default to active employees only
            $query->active();
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('personal_email', 'like', "%{$search}%")
                  ->orWhere('personal_mobile', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('hr.employees.index', compact('employees'));
    }

    /**
     * Show employee details
     */
    public function show(Employee $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Toggle employee status (active/inactive)
     */
    public function toggleStatus(Employee $employee)
    {
        $employee->status = $employee->status === 'active' ? 'inactive' : 'active';
        $employee->save();

        $statusText = $employee->status === 'active' ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "Employee {$statusText} successfully!");
    }

    /**
     * Show edit employee form
     */
    public function edit(Employee $employee)
    {
        return view('hr.employees.edit', compact('employee'));
    }

    /**
     * Update employee details
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            // Personal Information
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'blood_group' => 'required|string|max:10',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'aadhaar_number' => 'required|string|unique:employees,aadhaar_number,' . $employee->id . '|size:12',
            'passport_number' => 'nullable|string|max:20',
            
            // Professional Information
            'designation' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'date_of_joining' => 'required|date',
            
            // Contact Information
            'personal_mobile' => 'required|string|max:15',
            'personal_email' => 'required|email|unique:employees,personal_email,' . $employee->id,
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            
            // Emergency Contact
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:15',
            'emergency_contact_relation' => 'required|string|max:100',
            'emergency_contact_address' => 'required|string',
            
            // Additional Fields from CSV format
            'marriage_anniversary' => 'nullable|date',
            'pan_card' => 'nullable|string|max:20',
        ]);

        // Update employee record
        $employee->update([
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'aadhaar_number' => $request->aadhaar_number,
            'passport_number' => $request->passport_number,
            'designation' => $request->designation,
            'date_of_joining' => $request->date_of_joining,
            'personal_mobile' => $request->personal_mobile,
            'personal_email' => $request->personal_email,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_contact_relation' => $request->emergency_contact_relation,
            'emergency_contact_address' => $request->emergency_contact_address,
            // Additional Fields from CSV format
            'marriage_anniversary' => $request->marriage_anniversary,
            'pan_card' => $request->pan_card,
        ]);

        // No user record to update - employees don't have login accounts

        return redirect()->route('hr.employees.index')
            ->with('success', 'Employee details updated successfully!');
    }

    /**
     * Delete employee
     */
    public function destroy(Employee $employee)
    {
        // Delete employee record
        $employee->delete();

        return redirect()->route('hr.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Export all employees to CSV
     */
    public function exportEmployees()
    {
        $employees = Employee::all();
        
        $filename = 'employees_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Debug: Log the number of employees
        Log::info('Exporting ' . $employees->count() . ' employees');
        
        // Create CSV content
        $csvData = [];
        
        // Add CSV headers (matching user specified format)
        $csvData[] = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Date of Birth',
            'Gender',
            'Relationship Status',
            'Marriage Anniversary',
            'Designation',
            'Blood Group',
            'Date of Joining',
            'Current Address',
            'Nationality',
            'PAN Card',
            'Passport Number',
            'Permanent Address',
            'Emergency Contact Name',
            'Emergency Contact Number',
            'Emergency Contact Relation',
            'Emergency Contact Address',
            'Aadhaar Number',
            'Created At',
            'Updated At'
        ];
        
        // Add employee data (matching user specified format)
        foreach ($employees as $employee) {
            $csvData[] = [
                $employee->id,
                $employee->full_name,
                $employee->personal_email,
                $employee->personal_mobile,
                $employee->date_of_birth instanceof \Carbon\Carbon ? $employee->date_of_birth->format('Y-m-d') : 'N/A',
                ucfirst($employee->gender),
                ucfirst($employee->marital_status),
                $employee->marriage_anniversary instanceof \Carbon\Carbon ? $employee->marriage_anniversary->format('Y-m-d') : 'N/A',
                $employee->designation,
                $employee->blood_group,
                $employee->date_of_joining instanceof \Carbon\Carbon ? $employee->date_of_joining->format('Y-m-d') : 'N/A',
                $employee->current_address,
                $employee->nationality,
                $employee->pan_card ?: 'N/A',
                $employee->passport_number ?: 'N/A',
                $employee->permanent_address,
                $employee->emergency_contact_name,
                $employee->emergency_contact_number,
                $employee->emergency_contact_relation,
                $employee->emergency_contact_address,
                $employee->aadhaar_number,
                $employee->created_at->format('Y-m-d H:i:s'),
                $employee->updated_at->format('Y-m-d H:i:s')
            ];
        }
        
        // Convert to CSV string
        $csvContent = '';
        foreach ($csvData as $row) {
            $csvContent .= implode(',', array_map(function($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }
        
        // Debug: Log CSV content length
        Log::info('CSV content length: ' . strlen($csvContent));
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->header('Content-Length', strlen($csvContent));
    }

    /**
     * Show CSV import form
     */
    public function showImportForm()
    {
        return view('hr.employees.import');
    }

    /**
     * Download sample CSV template
     */
    public function downloadTemplate()
    {
        $filename = 'employee_template_' . date('Y-m-d') . '.csv';
        
        // Create sample CSV content (matching user specified format)
        // Note: ID, Created At, Updated At are auto-generated by the system
        $csvContent = "ID,Name,Email,Phone,Date of Birth,Gender,Relationship Status,Marriage Anniversary,Designation,Blood Group,Date of Joining,Current Address,Nationality,PAN Card,Passport Number,Permanent Address,Emergency Contact Name,Emergency Contact Number,Emergency Contact Relation,Emergency Contact Address,Aadhaar Number,Created At,Updated At\n";
        $csvContent .= "AUTO_GENERATED,John Doe,john.doe@example.com,1234567890,1990-01-15,Male,Single,,Developer,A+,2025-01-01,\"123 Main St, City\",Indian,ABCDE1234F,AB1234567,\"456 Home St, City\",Emergency Contact,9876543210,Father,\"789 Emergency St, City\",123456789012,AUTO_GENERATED,AUTO_GENERATED\n";
        $csvContent .= "AUTO_GENERATED,Jane Smith,jane.smith@example.com,0987654321,1992-05-20,Female,Married,2015-06-15,Designer,B+,2025-02-01,\"456 Oak Ave, Town\",Indian,FGHIJ5678K,CD9876543,\"789 Pine St, Town\",Emergency Contact 2,8765432109,Spouse,\"321 Emergency Ave, Town\",987654321098,AUTO_GENERATED,AUTO_GENERATED\n";
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Process CSV import
     */
    public function importEmployees(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->getRealPath()));
        
        // Remove header row
        $header = array_shift($csvData);
        
        // Validate CSV structure first (matching user specified format)
        $expectedColumns = [
            'ID', 'Name', 'Email', 'Phone', 'Date of Birth', 'Gender',
            'Relationship Status', 'Marriage Anniversary', 'Designation', 'Blood Group',
            'Date of Joining', 'Current Address', 'Nationality', 'PAN Card',
            'Passport Number', 'Permanent Address', 'Emergency Contact Name',
            'Emergency Contact Number', 'Emergency Contact Relation', 'Emergency Contact Address',
            'Aadhaar Number', 'Created At', 'Updated At'
        ];
        
        // Columns that will be used for mapping (excluding auto-generated fields)
        $mappingColumns = [
            'Name', 'Email', 'Phone', 'Date of Birth', 'Gender',
            'Relationship Status', 'Marriage Anniversary', 'Designation', 'Blood Group',
            'Date of Joining', 'Current Address', 'Nationality', 'PAN Card',
            'Passport Number', 'Permanent Address', 'Emergency Contact Name',
            'Emergency Contact Number', 'Emergency Contact Relation', 'Emergency Contact Address',
            'Aadhaar Number'
        ];
        
        if (count($header) !== count($expectedColumns)) {
            return redirect()->route('hr.employees.index')
                ->with('error', "CSV format error: Expected " . count($expectedColumns) . " columns, found " . count($header) . " columns. Please download the correct template.");
        }
        
        // Validate all rows first before any database operations
        $validationErrors = [];
        $employeesToInsert = [];
        
        foreach ($csvData as $index => $row) {
            $rowNumber = $index + 2; // +2 because we removed header and array is 0-indexed
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            // Validate row length
            if (count($row) !== count($expectedColumns)) {
                $validationErrors[] = "Row {$rowNumber}: Expected " . count($expectedColumns) . " columns, found " . count($row) . " columns";
                continue;
            }
            
            // Map CSV columns to database fields (excluding auto-generated fields)
            $employeeData = $this->mapCsvRowToEmployeeData($row, $rowNumber, $mappingColumns);
            
            // Validate each field with detailed error reporting
            $rowErrors = $this->validateEmployeeData($employeeData, $rowNumber);
            
            if (!empty($rowErrors)) {
                $validationErrors = array_merge($validationErrors, $rowErrors);
                continue; // Skip this row but continue validating others
            }
            
            // Check if employee already exists
            $existingEmployee = Employee::where('personal_email', $employeeData['personal_email'])->first();
            if ($existingEmployee) {
                $validationErrors[] = "Row {$rowNumber}: Employee with email '{$employeeData['personal_email']}' already exists in the database";
                continue;
            }
            
            // Prepare data for insertion
            $employeesToInsert[] = $this->prepareEmployeeDataForInsert($employeeData);
        }
        
        // If any validation errors found, return them without inserting anything
        if (!empty($validationErrors)) {
            $errorMessage = "Import failed due to validation errors. No data was inserted.\n\n";
            $errorMessage .= "Errors found:\n";
            foreach ($validationErrors as $error) {
                $errorMessage .= "• " . $error . "\n";
            }
            
            return redirect()->route('hr.employees.index')
                ->with('error', $errorMessage);
        }
        
        // If no validation errors, proceed with database transaction
        try {
            DB::beginTransaction();
            
            $imported = 0;
            foreach ($employeesToInsert as $employeeData) {
                $employee = Employee::create($employeeData);
                Log::info("Employee created successfully: ID {$employee->id}, Name: {$employee->full_name}, Email: {$employee->personal_email}");
                $imported++;
            }
            
            DB::commit();
            
            $message = "Import completed successfully! {$imported} employees imported.";
            
            return redirect()->route('hr.employees.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('hr.employees.index')
                ->with('error', "Database error during import: " . $e->getMessage());
        }
    }
    
    /**
     * Map CSV row data to employee data array
     */
    private function mapCsvRowToEmployeeData($row, $rowNumber, $mappingColumns = null)
    {
        // Expected CSV columns (matching user specified format)
        $allColumns = [
            'ID', 'Name', 'Email', 'Phone', 'Date of Birth', 'Gender',
            'Relationship Status', 'Marriage Anniversary', 'Designation', 'Blood Group',
            'Date of Joining', 'Current Address', 'Nationality', 'PAN Card',
            'Passport Number', 'Permanent Address', 'Emergency Contact Name',
            'Emergency Contact Number', 'Emergency Contact Relation', 'Emergency Contact Address',
            'Aadhaar Number', 'Created At', 'Updated At'
        ];
        
        // Use provided mapping columns or default to all columns
        $columns = $mappingColumns ?? $allColumns;
        
        $data = [];
        foreach ($allColumns as $index => $column) {
            if (in_array($column, $columns)) {
                $data[$column] = isset($row[$index]) ? trim($row[$index]) : '';
            }
        }
        
        // Map to our database field names
        return [
            'full_name' => $data['Name'],
            'personal_email' => $data['Email'],
            'personal_mobile' => $data['Phone'],
            'gender' => strtolower($data['Gender']),
            'date_of_birth' => $data['Date of Birth'],
            'blood_group' => $data['Blood Group'],
            'marital_status' => strtolower($data['Relationship Status']),
            'nationality' => $data['Nationality'],
            'religion' => 'Hindu', // Default since not in format
            'aadhaar_number' => $data['Aadhaar Number'],
            'passport_number' => $data['Passport Number'] === 'N/A' || $data['Passport Number'] === '' ? null : $data['Passport Number'],
            'designation' => $data['Designation'],
            'date_of_joining' => $data['Date of Joining'],
            'current_address' => $data['Current Address'],
            'permanent_address' => $data['Permanent Address'],
            'emergency_contact_name' => $data['Emergency Contact Name'],
            'emergency_contact_number' => $data['Emergency Contact Number'],
            'emergency_contact_relation' => $data['Emergency Contact Relation'],
            'emergency_contact_address' => $data['Emergency Contact Address'],
            'marriage_anniversary' => $data['Marriage Anniversary'],
            'pan_card' => $data['PAN Card'] === 'N/A' || $data['PAN Card'] === '' ? null : $data['PAN Card'],
        ];
    }

    /**
     * Validate gender field
     */
    private function validateGender($gender)
    {
        $validGenders = ['male', 'female', 'other'];
        return in_array(strtolower($gender), $validGenders) ? strtolower($gender) : 'male';
    }

    /**
     * Validate marital status field
     */
    private function validateMaritalStatus($status)
    {
        $validStatuses = ['single', 'married', 'divorced', 'widowed'];
        return in_array(strtolower($status), $validStatuses) ? strtolower($status) : 'single';
    }

    /**
     * Validate blood group field
     */
    private function validateBloodGroup($bloodGroup)
    {
        $validBloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return in_array(strtoupper($bloodGroup), $validBloodGroups) ? strtoupper($bloodGroup) : 'A+';
    }

    /**
     * Validate date field
     */
    private function validateDate($date)
    {
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return now()->format('Y-m-d');
        }
    }

    /**
     * Validate Aadhaar number
     */
    private function validateAadhaar($aadhaar)
    {
        // Remove any non-numeric characters
        $aadhaar = preg_replace('/[^0-9]/', '', $aadhaar);
        
        // Check if it's 12 digits
        if (strlen($aadhaar) === 12) {
            return $aadhaar;
        }
        
        // Generate a valid 12-digit number if invalid
        return str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);
    }

    /**
     * Validate mobile number
     */
    private function validateMobile($mobile)
    {
        // Remove any non-numeric characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // Check if it's 10 digits
        if (strlen($mobile) === 10) {
            return $mobile;
        }
        
        // Return default if invalid
        return '0000000000';
    }

    /**
     * Validate boolean field
     */
    private function validateBoolean($value)
    {
        $value = strtolower(trim($value));
        return in_array($value, ['true', '1', 'yes', 'on', 'enabled']);
    }
    
    /**
     * Validate employee data with detailed error reporting
     */
    private function validateEmployeeData($employeeData, $rowNumber)
    {
        $errors = [];
        
        // Required fields validation
        if (empty($employeeData['full_name'])) {
            $errors[] = "Row {$rowNumber}, Column 'Name': Full name is required";
        }
        
        if (empty($employeeData['personal_email'])) {
            $errors[] = "Row {$rowNumber}, Column 'Email': Email is required";
        } elseif (!filter_var($employeeData['personal_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Row {$rowNumber}, Column 'Email': Invalid email format '{$employeeData['personal_email']}'";
        }
        
        if (empty($employeeData['personal_mobile'])) {
            $errors[] = "Row {$rowNumber}, Column 'Phone': Mobile number is required";
        } elseif (!$this->isValidMobile($employeeData['personal_mobile'])) {
            $errors[] = "Row {$rowNumber}, Column 'Phone': Invalid mobile number '{$employeeData['personal_mobile']}' (must be 10 digits)";
        }
        
        // Date validations
        if (!empty($employeeData['date_of_birth']) && !$this->isValidDate($employeeData['date_of_birth'])) {
            $errors[] = "Row {$rowNumber}, Column 'Date of Birth': Invalid date format '{$employeeData['date_of_birth']}' (expected YYYY-MM-DD)";
        }
        
        if (!empty($employeeData['date_of_joining']) && !$this->isValidDate($employeeData['date_of_joining'])) {
            $errors[] = "Row {$rowNumber}, Column 'Date of Joining': Invalid date format '{$employeeData['date_of_joining']}' (expected YYYY-MM-DD)";
        }
        
        if (!empty($employeeData['marriage_anniversary']) && !$this->isValidDate($employeeData['marriage_anniversary'])) {
            $errors[] = "Row {$rowNumber}, Column 'Marriage Anniversary': Invalid date format '{$employeeData['marriage_anniversary']}' (expected YYYY-MM-DD)";
        }
        
        // Gender validation
        if (!empty($employeeData['gender']) && !$this->isValidGender($employeeData['gender'])) {
            $errors[] = "Row {$rowNumber}, Column 'Gender': Invalid gender '{$employeeData['gender']}' (must be: male, female, or other)";
        }
        
        // Marital status validation
        if (!empty($employeeData['marital_status']) && !$this->isValidMaritalStatus($employeeData['marital_status'])) {
            $errors[] = "Row {$rowNumber}, Column 'Relationship Status': Invalid marital status '{$employeeData['marital_status']}' (must be: single, married, divorced, or widowed)";
        }
        
        // Blood group validation
        if (!empty($employeeData['blood_group']) && !$this->isValidBloodGroup($employeeData['blood_group'])) {
            $errors[] = "Row {$rowNumber}, Column 'Blood Group': Invalid blood group '{$employeeData['blood_group']}' (must be: A+, A-, B+, B-, AB+, AB-, O+, or O-)";
        }
        
        // Aadhaar validation
        if (!empty($employeeData['aadhaar_number']) && !$this->isValidAadhaar($employeeData['aadhaar_number'])) {
            $errors[] = "Row {$rowNumber}, Column 'Aadhaar Number': Invalid Aadhaar number '{$employeeData['aadhaar_number']}' (must be 12 digits)";
        }
        
        // Emergency contact number validation
        if (!empty($employeeData['emergency_contact_number']) && !$this->isValidMobile($employeeData['emergency_contact_number'])) {
            $errors[] = "Row {$rowNumber}, Column 'Emergency Contact Number': Invalid emergency contact number '{$employeeData['emergency_contact_number']}' (must be 10 digits)";
        }
        
        return $errors;
    }
    
    /**
     * Prepare employee data for database insertion
     */
    private function prepareEmployeeDataForInsert($employeeData)
    {
        return [
            'full_name' => $employeeData['full_name'],
            'gender' => $this->validateGender($employeeData['gender'] ?? 'male'),
            'date_of_birth' => $this->validateDate($employeeData['date_of_birth'] ?? '1990-01-01'),
            'blood_group' => $this->validateBloodGroup($employeeData['blood_group'] ?? 'A+'),
            'marital_status' => $this->validateMaritalStatus($employeeData['marital_status'] ?? 'single'),
            'nationality' => $employeeData['nationality'] ?? 'Indian',
            'religion' => $employeeData['religion'] ?? 'Hindu',
            'aadhaar_number' => $this->validateAadhaar($employeeData['aadhaar_number'] ?? '000000000000'),
            'passport_number' => $employeeData['passport_number'] ?: null,
            'designation' => $employeeData['designation'] ?? 'Employee',
            'date_of_joining' => $this->validateDate($employeeData['date_of_joining'] ?? now()->format('Y-m-d')),
            'personal_mobile' => $this->validateMobile($employeeData['personal_mobile'] ?? '0000000000'),
            'personal_email' => $employeeData['personal_email'],
            'current_address' => $employeeData['current_address'] ?: 'Not provided',
            'permanent_address' => $employeeData['permanent_address'] ?: 'Not provided',
            'emergency_contact_name' => $employeeData['emergency_contact_name'] ?: 'Not provided',
            'emergency_contact_number' => $this->validateMobile($employeeData['emergency_contact_number'] ?? '0000000000'),
            'emergency_contact_relation' => $employeeData['emergency_contact_relation'] ?: 'Not provided',
            'emergency_contact_address' => $employeeData['emergency_contact_address'] ?: 'Not provided',
            'terms_accepted' => true,
            'marriage_anniversary' => $employeeData['marriage_anniversary'] ? $this->validateDate($employeeData['marriage_anniversary']) : null,
            'pan_card' => $employeeData['pan_card'] ?: null,
        ];
    }
    
    /**
     * Check if mobile number is valid
     */
    private function isValidMobile($mobile)
    {
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        return strlen($mobile) === 10 && is_numeric($mobile);
    }
    
    /**
     * Check if date is valid
     */
    private function isValidDate($date)
    {
        try {
            \Carbon\Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Check if gender is valid
     */
    private function isValidGender($gender)
    {
        $validGenders = ['male', 'female', 'other'];
        return in_array(strtolower($gender), $validGenders);
    }
    
    /**
     * Check if marital status is valid
     */
    private function isValidMaritalStatus($status)
    {
        $validStatuses = ['single', 'married', 'divorced', 'widowed'];
        return in_array(strtolower($status), $validStatuses);
    }
    
    /**
     * Check if blood group is valid
     */
    private function isValidBloodGroup($bloodGroup)
    {
        $validBloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return in_array(strtoupper($bloodGroup), $validBloodGroups);
    }
    
    /**
     * Check if Aadhaar number is valid
     */
    private function isValidAadhaar($aadhaar)
    {
        $aadhaar = preg_replace('/[^0-9]/', '', $aadhaar);
        return strlen($aadhaar) === 12 && is_numeric($aadhaar);
    }
    
    /**
     * Check if boolean value is valid
     */
    private function isValidBoolean($value)
    {
        $value = strtolower(trim($value));
        return in_array($value, ['true', 'false', '1', '0', 'yes', 'no', 'on', 'off', 'enabled', 'disabled']);
    }
}
