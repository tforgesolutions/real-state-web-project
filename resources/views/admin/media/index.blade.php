@extends('admin.layouts.app')

@section('title', 'Media Library')
@section('header', 'Media Library')

@section('content')

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded shadow-sm">
    <div class="flex">
        <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
        <div>
            <h3 class="text-sm font-medium text-red-800">Error!</h3>
            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Top Controls: Upload, Filter, Sync -->
<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..." class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
        
        <select name="type" class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Types</option>
            <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Images Only</option>
            <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Documents</option>
        </select>

        <select name="sort" class="border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="largest" {{ request('sort') == 'largest' ? 'selected' : '' }}>Largest</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
        </select>

        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
            Filter
        </button>
        @if(request()->hasAny(['search', 'type', 'sort']))
            <a href="{{ route('admin.media.index') }}" class="text-sm text-gray-500 hover:text-blue-600">Clear</a>
        @endif
    </form>

    <div class="flex items-center gap-2">
        <form action="{{ route('admin.media.sync') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center" title="Sync existing files from storage that are not in the DB">
                <i class="fas fa-sync-alt mr-2"></i> Sync Files
            </button>
        </form>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center">
            <i class="fas fa-upload mr-2"></i> Upload Media
        </button>
    </div>
</div>

<!-- Media Grid -->
@if($media->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
        @foreach($media as $item)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow transition-shadow group relative flex flex-col">
                <div class="aspect-w-1 aspect-h-1 bg-gray-100 cursor-pointer overflow-hidden flex items-center justify-center relative" onclick="openPreview({{ $item->id }})">
                    @if($item->is_image)
                        <img src="{{ $item->url }}" alt="{{ $item->original_name }}" class="object-cover w-full h-32 group-hover:scale-105 transition-transform duration-300">
                    @else
                        <i class="fas fa-file-alt text-4xl text-gray-400 h-32 flex items-center justify-center w-full"></i>
                    @endif
                </div>
                
                <div class="p-3 bg-white flex-grow flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-900 truncate" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                        <p class="text-[10px] text-gray-500 mt-1">{{ $item->format_size }} • {{ strtoupper(pathinfo($item->original_name, PATHINFO_EXTENSION)) }}</p>
                    </div>
                </div>

                @if(count($item->usage) > 0)
                    <div class="absolute top-2 left-2 bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-yellow-200" title="{{ count($item->usage) }} references">
                        In Use
                    </div>
                @endif
            </div>

            <!-- Preview Modal per item -->
            <div id="previewModal-{{ $item->id }}" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePreview({{ $item->id }})"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                        <div class="bg-white flex flex-col md:flex-row">
                            <!-- Image / File Preview Side -->
                            <div class="w-full md:w-2/3 bg-gray-100 p-4 flex items-center justify-center min-h-[300px] md:min-h-[500px]">
                                @if($item->is_image)
                                    <img src="{{ $item->url }}" alt="{{ $item->original_name }}" class="max-w-full max-h-[500px] object-contain shadow-sm border border-gray-200">
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-file-alt text-6xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-500">Preview not available for this file type.</p>
                                        <a href="{{ $item->url }}" target="_blank" class="mt-4 inline-block text-blue-600 hover:underline">Download File</a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Details Side -->
                            <div class="w-full md:w-1/3 p-6 flex flex-col bg-white">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 break-words pr-4" id="modal-title">{{ $item->original_name }}</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closePreview({{ $item->id }})">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                                
                                <div class="space-y-4 flex-grow">
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">Uploaded On</p>
                                        <p class="font-medium">{{ $item->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">File Type</p>
                                        <p class="font-medium">{{ $item->mime_type }}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">File Size</p>
                                        <p class="font-medium">{{ $item->format_size }}</p>
                                    </div>
                                    @if($item->width && $item->height)
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">Dimensions</p>
                                        <p class="font-medium">{{ $item->width }} x {{ $item->height }} pixels</p>
                                    </div>
                                    @endif
                                    
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">File URL</p>
                                        <div class="flex mt-1">
                                            <input type="text" readonly value="{{ $item->url }}" id="url-{{ $item->id }}" class="block w-full border border-gray-300 rounded-l-md shadow-sm py-1.5 px-2 text-xs bg-gray-50 focus:outline-none">
                                            <button type="button" onclick="copyUrl({{ $item->id }})" class="bg-gray-100 hover:bg-gray-200 border border-l-0 border-gray-300 rounded-r-md px-3 text-xs font-medium text-gray-700 transition-colors">
                                                Copy
                                            </button>
                                        </div>
                                    </div>

                                    @if(count($item->usage) > 0)
                                        <div class="mt-4 p-3 bg-yellow-50 rounded border border-yellow-200">
                                            <p class="text-xs font-bold text-yellow-800 mb-2 uppercase tracking-wider"><i class="fas fa-link mr-1"></i> File is in use ({{ count($item->usage) }})</p>
                                            <ul class="text-xs text-yellow-700 list-disc list-inside space-y-1">
                                                @foreach(array_slice($item->usage, 0, 5) as $u)
                                                    <li class="truncate">{{ $u }}</li>
                                                @endforeach
                                                @if(count($item->usage) > 5)
                                                    <li>...and {{ count($item->usage) - 5 }} more.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-6 pt-4 border-t border-gray-100 text-right">
                                    <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirmDelete(event, {{ count($item->usage) }});">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $media->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
        <i class="fas fa-images text-5xl text-gray-300 mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No media found</h3>
        <p class="text-gray-500 mb-4">You haven't uploaded any files yet, or none match your search.</p>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center">
            <i class="fas fa-upload mr-2"></i> Upload Media
        </button>
    </div>
@endif

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('uploadModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Upload Media</h3>
                            <div class="mt-4">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center" id="dropzone">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-blue-500 mb-3"></i>
                                    <p class="text-sm text-gray-600 mb-2">Drag and drop files here, or click to browse</p>
                                    <p class="text-xs text-gray-400 mb-4">Supported: JPG, PNG, WEBP (Max 10MB per file)</p>
                                    <input type="file" name="files[]" id="fileInput" multiple accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                </div>
                                <div id="fileList" class="mt-4 space-y-2 max-h-32 overflow-y-auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" id="uploadBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Upload Files
                    </button>
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPreview(id) {
        document.getElementById('previewModal-' + id).classList.remove('hidden');
    }
    
    function closePreview(id) {
        document.getElementById('previewModal-' + id).classList.add('hidden');
    }
    
    function copyUrl(id) {
        var copyText = document.getElementById("url-" + id);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        // Show temp tooltip or change text
        const btn = copyText.nextElementSibling;
        const originalText = btn.innerText;
        btn.innerText = 'Copied!';
        setTimeout(() => { btn.innerText = originalText; }, 2000);
    }
    
    function confirmDelete(e, usageCount) {
        if(usageCount > 0) {
            e.preventDefault();
            alert('Cannot delete this file. It is currently being used by ' + usageCount + ' record(s) on the website. You must remove the reference from those records first.');
            return false;
        }
        return confirm('Are you sure you want to permanently delete this file? This action cannot be undone.');
    }

    // Simple file input preview
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';
        
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const size = (file.size / (1024*1024)).toFixed(2);
            fileList.innerHTML += `
                <div class="flex justify-between items-center bg-gray-50 p-2 rounded border border-gray-100">
                    <span class="text-xs text-gray-700 truncate mr-2">${file.name}</span>
                    <span class="text-xs text-gray-500 whitespace-nowrap">${size} MB</span>
                </div>
            `;
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function() {
        const btn = document.getElementById('uploadBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
</script>
@endsection
