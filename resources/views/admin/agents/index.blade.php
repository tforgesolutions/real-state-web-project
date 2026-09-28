@extends('admin.layouts.app')

@section('title', 'Agents')
@section('header', 'Manage Agents')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="text-xl font-semibold text-gray-800">Agents List</h2>
    <a href="{{ route('admin.agents.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
        <i class="fas fa-plus mr-2"></i> Add Agent
    </a>
</div>

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
    <form action="{{ route('admin.agents.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        
        <div class="lg:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Email, Phone..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Agency</label>
            <select name="agency" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All Agencies</option>
                @foreach($agencies as $agency)
                    <option value="{{ $agency }}" {{ request('agency') == $agency ? 'selected' : '' }}>{{ $agency }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>

        <div class="flex items-end space-x-2">
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none text-sm font-medium">
                Filter
            </button>
            <a href="{{ route('admin.agents.index') }}" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none text-sm font-medium">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent Info</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Properties</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($agents as $agent)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                                @if($agent->profile_photo)
                                    <img src="{{ Storage::url($agent->profile_photo) }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-500 font-bold bg-blue-100 text-blue-600">
                                        {{ substr($agent->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $agent->name }}</div>
                                <div class="text-xs text-gray-500">{{ $agent->agency ?? 'Independent' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $agent->email }}</div>
                        <div class="text-xs text-gray-500">{{ $agent->phone ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                            {{ $agent->properties_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-800',
                                'inactive' => 'bg-gray-100 text-gray-800',
                                'suspended' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full capitalize {{ $color }}">
                            {{ $agent->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button" onclick="toggleFeatured({{ $agent->id }}, this)" class="focus:outline-none">
                            <i class="fas fa-star text-lg {{ $agent->is_featured ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('admin.agents.show', $agent->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.agents.edit', $agent->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded"><i class="fas fa-edit"></i></a>
                        <button type="button" onclick="confirmDelete({{ $agent->id }})" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
                        
                        <form id="delete-form-{{ $agent->id }}" action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-user-tie text-4xl mb-3 text-gray-300"></i>
                        <p>No agents found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($agents->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $agents->links() }}
    </div>
    @endif
</div>

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
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Agent</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to delete this agent? This action cannot be undone. If they have properties assigned, you must reassign them first.</p>
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

    function toggleFeatured(id, btnElement) {
        fetch(`/admin/agents/${id}/featured`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const icon = btnElement.querySelector('i');
                if(data.is_featured) {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-gray-300');
                }
            }
        });
    }
</script>
@endsection
