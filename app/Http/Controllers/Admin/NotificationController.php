<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function markRead(Notification $notification)
    {
        if ($notification->notifiable_id === Auth::guard('admin')->id() && $notification->notifiable_type === 'App\Models\Admin') {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->back();
    }

    public function markAllRead()
    {
        Auth::guard('admin')->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);

        return redirect()->back();
    }
}
