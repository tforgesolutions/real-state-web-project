<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::with(['property', 'project', 'agent']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }
        if ($request->filled('inquiry_type')) {
            $query->where('inquiry_type', $request->inquiry_type);
        }

        $inquiries = $query->latest()->paginate(15);
        
        $agents = User::whereIn('role', ['agent', 'admin'])->get();

        return view('admin.inquiries.index', compact('inquiries', 'agents'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['property', 'project', 'agent']);
        $agents = User::whereIn('role', ['agent', 'admin'])->get();
        return view('admin.inquiries.show', compact('inquiry', 'agents'));
    }
    
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:New,Contacted,In Progress,Follow Up,Converted,Closed,Spam',
        ]);
        
        $inquiry->status = $request->status;
        $inquiry->save();
        
        if($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }
        
        return back()->with('success', 'Inquiry status updated successfully.');
    }
    
    public function updatePriority(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);
        
        $inquiry->priority = $request->priority;
        $inquiry->save();
        
        if($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
        }
        
        return back()->with('success', 'Inquiry priority updated successfully.');
    }
    
    public function assignAgent(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'agent_id' => 'nullable|exists:users,id',
        ]);
        
        $inquiry->agent_id = $request->agent_id;
        $inquiry->save();
        
        return back()->with('success', 'Agent assigned successfully.');
    }
    
    public function updateFollowUp(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'follow_up_note' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);
        
        $inquiry->follow_up_note = $request->follow_up_note;
        $inquiry->follow_up_date = $request->follow_up_date;
        $inquiry->save();
        
        return back()->with('success', 'Follow-up details updated successfully.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'inquiry_ids' => 'required|array',
            'inquiry_ids.*' => 'exists:inquiries,id'
        ]);
        
        $ids = $request->inquiry_ids;
        $action = $request->action;
        
        switch ($action) {
            case 'delete':
                Inquiry::whereIn('id', $ids)->delete();
                $message = count($ids) . ' inquiries deleted successfully.';
                break;
            case 'mark_contacted':
                Inquiry::whereIn('id', $ids)->update(['status' => 'Contacted']);
                $message = count($ids) . ' inquiries marked as contacted.';
                break;
            case 'mark_spam':
                Inquiry::whereIn('id', $ids)->update(['status' => 'Spam']);
                $message = count($ids) . ' inquiries marked as spam.';
                break;
            default:
                return back()->with('error', 'Invalid action selected.');
        }
        
        return back()->with('success', $message);
    }
}
