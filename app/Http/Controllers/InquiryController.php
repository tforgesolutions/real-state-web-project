<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string',
            'property_id' => 'nullable|exists:properties,id',
            'project_id' => 'nullable|exists:projects,id',
            'agent_id' => 'nullable|exists:users,id',
            'inquiry_type' => 'nullable|string|max:255',
        ]);

        $inquiry = new Inquiry();
        $inquiry->name = $request->name;
        $inquiry->email = $request->email;
        $inquiry->phone = $request->phone;
        
        // The frontend forms sometimes use contact_method or explicitly send whatsapp, but since we are preserving their exact HTML inputs, we'll try to map them if they exist.
        if ($request->has('contact_method') && $request->contact_method === 'WhatsApp') {
            $inquiry->whatsapp = $request->phone;
        }

        $inquiry->message = $request->message;
        $inquiry->property_id = $request->property_id;
        $inquiry->project_id = $request->project_id;
        if ($request->has('agent_id')) {
            $inquiry->agent_id = $request->agent_id;
        }
        
        $inquiry->inquiry_type = $request->inquiry_type ?? ($request->property_id ? 'Property Inquiry' : ($request->project_id ? 'Project Inquiry' : ($request->agent_id ? 'Agent Inquiry' : 'General Inquiry')));
        $inquiry->source = $request->headers->get('referer');
        
        if (Auth::check()) {
            $inquiry->user_id = Auth::id();
        }

        $inquiry->save();

        // Notify admins and assigned agents
        try {
            $notifiables = collect();
            
            // Notify admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            $notifiables = $notifiables->merge($admins);
            
            // Notify agent if assigned to a property
            if ($inquiry->property_id && $inquiry->property) {
                if ($inquiry->property->user_id) {
                    $agent = \App\Models\User::find($inquiry->property->user_id);
                    if ($agent) {
                        $notifiables->push($agent);
                        $inquiry->agent_id = $agent->id;
                        $inquiry->save();
                    }
                }
            }

            // Remove duplicates
            $notifiables = $notifiables->unique('id');

            // Send notification
            \Illuminate\Support\Facades\Notification::send($notifiables, new \App\Notifications\NewInquiryNotification($inquiry));
        } catch (\Exception $e) {
            // Silently ignore mail/notification errors to ensure form submission succeeds
            \Illuminate\Support\Facades\Log::error('Failed to send inquiry notification: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Inquiry submitted successfully!']);
        }

        return back()->with('success', 'Your inquiry has been submitted successfully. Our team will contact you shortly.');
    }
}
