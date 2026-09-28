@extends('admin.layouts.app')

@section('title', 'View Inquiry')
@section('header', 'Inquiry Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.inquiries.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Inquiries
    </a>
    <div class="space-x-2 flex">
        <button type="button" onclick="confirmDelete({{ $inquiry->id }})" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
            <i class="fas fa-trash mr-2"></i> Delete
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Customer Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="h-16 w-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold mr-4">
                        {{ substr($inquiry->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $inquiry->name }}</h2>
                        <p class="text-sm text-gray-500">Submitted on {{ $inquiry->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 mr-3">{{ $inquiry->email }}</p>
                            <a href="mailto:{{ $inquiry->email }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-envelope mr-1"></i> Email</a>
                        </div>
                    </div>
                    
                    @if($inquiry->phone)
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Phone</p>
                        <div class="flex items-center">
                            <p class="text-gray-900 mr-3">{{ $inquiry->phone }}</p>
                            <a href="tel:{{ $inquiry->phone }}" class="text-green-600 hover:text-green-800 bg-green-50 px-2 py-1 rounded text-xs"><i class="fas fa-phone mr-1"></i> Call</a>
                            @if($inquiry->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->whatsapp) }}" target="_blank" class="text-green-600 hover:text-green-800 bg-green-50 px-2 py-1 rounded text-xs ml-2"><i class="fab fa-whatsapp mr-1"></i> WhatsApp</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Inquiry Details</h3>
                <span class="text-xs font-medium bg-gray-200 text-gray-800 px-2.5 py-0.5 rounded-full">{{ $inquiry->inquiry_type }}</span>
            </div>
            <div class="p-6">
                <p class="text-sm font-medium text-gray-500 mb-2">Message</p>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-gray-800 whitespace-pre-line text-sm leading-relaxed">
                    {{ $inquiry->message ?: 'No message provided.' }}
                </div>
                
                @if($inquiry->property || $inquiry->project)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-sm font-medium text-gray-500 mb-3">Interested In</p>
                    @if($inquiry->property)
                        <div class="flex items-center bg-blue-50 p-3 rounded border border-blue-100">
                            <div class="h-10 w-10 bg-blue-200 rounded flex items-center justify-center text-blue-600 mr-3">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900">{{ $inquiry->property->title }}</p>
                                <p class="text-xs text-gray-500">Property • {{ $inquiry->property->city }}</p>
                            </div>
                            <a href="{{ route('admin.properties.show', $inquiry->property->id) }}" class="text-blue-600 text-sm hover:underline">View Property</a>
                        </div>
                    @endif
                    
                    @if($inquiry->project)
                        <div class="flex items-center bg-indigo-50 p-3 rounded border border-indigo-100 mt-3">
                            <div class="h-10 w-10 bg-indigo-200 rounded flex items-center justify-center text-indigo-600 mr-3">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900">{{ $inquiry->project->title }}</p>
                                <p class="text-xs text-gray-500">Project • {{ $inquiry->project->developer }}</p>
                            </div>
                            <a href="{{ route('admin.projects.show', $inquiry->project->id) }}" class="text-indigo-600 text-sm hover:underline">View Project</a>
                        </div>
                    @endif
                </div>
                @endif
                
                @if($inquiry->source)
                <div class="mt-4 text-xs text-gray-400">
                    <i class="fas fa-link mr-1"></i> Source: {{ $inquiry->source }}
                </div>
                @endif
            </div>
        </div>
        
    </div>

    <!-- Right Column: Controls -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- Status & Priority -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Management</h3>
            
            <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST" class="mb-4">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="flex space-x-2">
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        @foreach(['New', 'Contacted', 'In Progress', 'Follow Up', 'Converted', 'Closed', 'Spam'] as $status)
                            <option value="{{ $status }}" {{ $inquiry->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-gray-100 px-3 rounded border border-gray-300 text-sm font-medium hover:bg-gray-200">Save</button>
                </div>
            </form>

            <form action="{{ route('admin.inquiries.priority', $inquiry->id) }}" method="POST" class="mb-6">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <div class="flex space-x-2">
                    <select name="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        @foreach(['Low', 'Medium', 'High', 'Urgent'] as $priority)
                            <option value="{{ $priority }}" {{ $inquiry->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-gray-100 px-3 rounded border border-gray-300 text-sm font-medium hover:bg-gray-200">Save</button>
                </div>
            </form>
            
            <hr class="border-gray-100 my-4">
            
            <form action="{{ route('admin.inquiries.assign', $inquiry->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Agent</label>
                <select name="agent_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2 mb-2">
                    <option value="">-- Unassigned --</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ $inquiry->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }} ({{ $agent->role }})</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white px-3 py-2 rounded text-sm font-medium hover:bg-blue-700">Assign</button>
            </form>
        </div>

        <!-- Follow up -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Follow-up</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.inquiries.follow-up', $inquiry->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                        <input type="date" name="follow_up_date" value="{{ $inquiry->follow_up_date ? $inquiry->follow_up_date->format('Y-m-d') : '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="follow_up_note" rows="3" placeholder="Add notes about your contact with the customer..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">{{ $inquiry->follow_up_note }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-gray-800 text-white px-3 py-2 rounded text-sm font-medium hover:bg-gray-700">Save Follow-up Info</button>
                </form>
            </div>
        </div>

    </div>
</div>

<form id="delete-form-{{ $inquiry->id }}" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Inquiry</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to delete this inquiry? This action cannot be undone.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
          Delete
        </button>
        <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<script>
    let deleteId = null;
    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        deleteId = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if(deleteId) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    });
</script>
@endsection
