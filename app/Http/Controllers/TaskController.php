<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Only allow HR Manager and Admin users to access task management
            if (!Auth::user()->isHRManager() && Auth::user()->role !== 'admin') {
                abort(403, 'Access denied. Only HR Managers and Administrators can manage tasks.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Task::with('creator');

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get task statistics
        $stats = [
            'total' => Task::count(),
            'pending' => Task::byStatus('pending')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'completed' => Task::byStatus('completed')->count(),
            'overdue' => Task::overdue()->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priorities = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];

        return view('tasks.create', compact('priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string'
        ]);

        $task = Task::create([
            'created_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('tasks.index')
                        ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('creator');
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $priorities = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];

        $statuses = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return view('tasks.edit', compact('task', 'priorities', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ];

        // If status is being changed to completed, set completed_at
        if ($request->status === 'completed' && $task->status !== 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($request->status !== 'completed') {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);

        return redirect()->route('tasks.index')
                        ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                        ->with('success', 'Task deleted successfully!');
    }

    /**
     * Update task status (AJAX)
     */
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'completed') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);

        return response()->json([
            'success' => true,
            'status' => $task->status,
            'status_display' => $task->getStatusDisplayName(),
            'status_badge_class' => $task->getStatusBadgeClass()
        ]);
    }

    /**
     * Get task statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total' => Task::count(),
            'pending' => Task::byStatus('pending')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'completed' => Task::byStatus('completed')->count(),
            'overdue' => Task::overdue()->count(),
            'completion_rate' => Task::count() > 0 ? round((Task::byStatus('completed')->count() / Task::count()) * 100, 1) : 0
        ];

        return response()->json($stats);
    }
}