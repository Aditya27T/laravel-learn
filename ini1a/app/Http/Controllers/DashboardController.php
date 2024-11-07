<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('role', 'user')->count(),
            'adminUsers' => User::where('role', 'admin')->count(),
            'newUsersToday' => User::whereDate('created_at', today())->count()
        ];

        if (Auth::user()->role === 'admin') {
            $recentUsers = User::latest()->take(5)->get();
        } else {
            $recentUsers = User::where('id', Auth::id())->get();
        }

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}