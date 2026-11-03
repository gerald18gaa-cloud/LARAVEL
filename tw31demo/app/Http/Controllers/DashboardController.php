<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();

        $activeMembers = Member::where('status', 'Active')->count();

        $inactiveMembers = Member::where('status', 'Inactive')->count();

        $totalCategories = MembershipCategory::count();

        $totalLevels = MembershipLevel::count();

        $pendingTransactions = MembershipTransaction::where(
            'status',
            'Pending'
        )->count();

        $collectedPayments = Payment::sum('amount');

        return view('dashboard', compact(
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'totalCategories',
            'totalLevels',
            'pendingTransactions',
            'collectedPayments'
        ));
    }
}