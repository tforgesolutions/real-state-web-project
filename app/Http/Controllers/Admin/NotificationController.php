<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        if (isset($notification->data['inquiry_id'])) {
            return redirect()->route('admin.inquiries.show', $notification->data['inquiry_id']);
        }
        
        return back();
    }

    public function markAsUnread($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsUnread();
        
        return back()->with('success', 'Notification marked as unread.');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read.');
    }
}
