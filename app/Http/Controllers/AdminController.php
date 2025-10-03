<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Task statistics
        $taskStats = [
            'total' => Task::count(),
            'pending' => Task::byStatus('pending')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'completed' => Task::byStatus('completed')->count(),
            'overdue' => Task::overdue()->count(),
        ];
        
        return view('admin.dashboard', compact('taskStats'));
    }
}