@extends('admin.layouts.app')

@section('title', 'Inquiries & Leads')
@section('header', 'Manage Inquiries')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="text-xl font-semibold text-gray-800">Inquiries List</h2>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
    <form action="{{ route('admin.inquiries.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        
        <div class="lg:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Email, Phone, ID..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All Statuses</option>
                @foreach(['New', 'Contacted', 'In Progress', 'Follow Up', 'Converted', 'Closed', 'Spam'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
            <select name="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All Priorities</option>
                @foreach(['Low', 'Medium', 'High', 'Urgent'] as $priority)
                <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Agent</label>
            <select name="agent_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All Agents</option>
                @foreach($agents as $agent)
                <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none text-sm font-medium">
                Filter
            </button>
            <a href="{{ route('admin.inquiries.index') }}" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none text-sm font-medium">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table Area -->
<form id="bulk-action-form" action="{{ route('admin.inquiries.bulk') }}" method="POST">
    @csrf
    
    <div class="mb-4 flex items-center space-x-4 bg-white p-3 rounded-lg shadow-sm border border-gray-100">
        <span class="text-sm text-gray-600 font-medium">Bulk Actions:</span>
        <select name="action" id="bulk-action" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-1.5" required>
            <option value="">Select Action</option>
            <option value="mark_contacted">Mark as Contacted</option>
            <option value="mark_spam">Mark as Spam</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="button" onclick="confirmBulkAction()" class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-md hover:bg-gray-200 text-sm font-medium border border-gray-200">
            Apply
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inquiry Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Agent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status & Priority</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <input type="checkbox" name="inquiry_ids[]" value="{{ $inquiry->id }}" class="inquiry-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">ID: #{{ $inquiry->id }}</div>
                            <div class="text-xs text-gray-500">{{ $inquiry->inquiry_type }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $inquiry->created_at->format('M d, Y h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $inquiry->name }}</div>
                            <div class="text-xs text-blue-600"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
                            <div class="text-xs text-gray-500">{{ $inquiry->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($inquiry->agent)
                                <div class="flex items-center">
                                    <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 text-xs font-bold mr-2">
                                        {{ substr($inquiry->agent->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $inquiry->agent->name }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'New' => 'bg-blue-100 text-blue-800',
                                    'Contacted' => 'bg-yellow-100 text-yellow-800',
                                    'In Progress' => 'bg-indigo-100 text-indigo-800',
                                    'Follow Up' => 'bg-purple-100 text-purple-800',
                                    'Converted' => 'bg-green-100 text-green-800',
                                    'Closed' => 'bg-gray-100 text-gray-800',
                                    'Spam' => 'bg-red-100 text-red-800',
                                ];
                                $priorityColors = [
                                    'Low' => 'text-gray-500',
                                    'Medium' => 'text-blue-500',
                                    'High' => 'text-orange-500',
                                    'Urgent' => 'text-red-600 font-bold',
                                ];
                            @endphp
                            <div class="mb-1">
                                <select onchange="updateStatus({{ $inquiry->id }}, this.value)" class="text-xs font-semibold rounded-full capitalize {{ $statusColors[$inquiry->status] ?? 'bg-gray-100 text-gray-800' }} border-none cursor-pointer focus:ring-0 py-1 pl-3 pr-6">
                                    @foreach(['New', 'Contacted', 'In Progress', 'Follow Up', 'Converted', 'Closed', 'Spam'] as $status)
                                        <option value="{{ $status }}" {{ $inquiry->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-xs {{ $priorityColors[$inquiry->priority] ?? 'text-gray-500' }} flex items-center ml-1">
                                <i class="fas fa-flag mr-1"></i> {{ $inquiry->priority }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded" title="View"><i class="fas fa-eye"></i></a>
                            
                            <button type="button" onclick="confirmDelete({{ $inquiry->id }})" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded" title="Delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>No inquiries found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($inquiries->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $inquiries->links() }}
        </div>
        @endif
    </div>
</form>

<!-- Forms for individual actions -->
@foreach($inquiries as $inquiry)
<form id="delete-form-{{ $inquiry->id }}" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

<!-- Delete Modal -->
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
    // Delete Modal Logic
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

    // Bulk Action Logic
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.inquiry-checkbox');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
    
    function confirmBulkAction() {
        let action = document.getElementById('bulk-action').value;
        if (!action) {
            alert('Please select an action first.');
            return;
        }
        
        let checked = document.querySelectorAll('.inquiry-checkbox:checked').length;
        if (checked === 0) {
            alert('Please select at least one inquiry.');
            return;
        }
        
        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checked} selected inquiries?`)) {
                return;
            }
        }
        
        document.getElementById('bulk-action-form').submit();
    }
    
    // AJAX Status Update
    function updateStatus(id, status) {
        fetch(`/admin/inquiries/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Optionally show a small toast, but reloading keeps colors fresh
                window.location.reload();
            }
        });
    }
</script>
@endsection
