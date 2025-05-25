<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    protected $authenticatedUser;
    protected $activityLogModel;
    public function __construct()
    {
        $this->authenticatedUser = Auth::user();
        $this->activityLogModel = ActivityLog::class;
    }

}
