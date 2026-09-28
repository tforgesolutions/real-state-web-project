@props(['media' => []])

@php
    // If no media passed, provide some demo data that includes various types
    if (empty($media)) {
        $media = [
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1740&auto=format&fit=crop',
                'thumbnail' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=400&auto=format&fit=crop',
                'title' => 'Main View'
            ],
            [
                'type' => 'video',
                'url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                'thumbnail' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=400&auto=format&fit=crop',
                'title' => 'Property Video Tour'
            ],
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1740&auto=format&fit=crop',
                'thumbnail' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=400&auto=format&fit=crop',
                'title' => 'Living Room'
            ],
            [
                'type' => 'virtual_tour',
                'url' => '#',
                'thumbnail' => 'https://images.unsplash.com/photo-1556912167-f556f1f39fdf?q=80&w=400&auto=format&fit=crop',
                'title' => '360° Virtual Tour'
            ],
            [
                'type' => 'floor_plan',
                'url' => 'https://images.unsplash.com/photo-1600607688969-a5bfcd64bd19?q=80&w=1740&auto=format&fit=crop',
                'thumbnail' => 'https://images.unsplash.com/photo-1600607688969-a5bfcd64bd19?q=80&w=400&auto=format&fit=crop',
                'title' => 'Main Floor Plan'
            ],
            [
                'type' => 'image',
                'url' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?q=80&w=1740&auto=format&fit=crop',
                'thumbnail' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?q=80&w=400&auto=format&fit=crop',
                'title' => 'Bedroom'
            ],
        ];
    }
    
    $hasImages = collect($media)->contains('type', 'image');
    $hasVideos = collect($media)->contains('type', 'video');
    $hasFloorPlans = collect($media)->contains('type', 'floor_plan');
    $hasVirtualTour = collect($media)->contains('type', 'virtual_tour');
@endphp

<!-- ADVANCED PROPERTY MEDIA GALLERY -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 animate-fade-up-scroll" id="property-gallery-container" style="animation-delay: 0.1s;">
    
    <!-- Gallery Filters -->
    <div class="flex flex-wrap gap-2 mb-4">
        <button onclick="filterGallery('all')" class="gallery-filter-btn active px-4 py-1.5 rounded-full text-sm font-semibold bg-[var(--color-primary)] text-white transition-colors">All Media</button>
        @if($hasImages)
            <button onclick="filterGallery('image')" class="gallery-filter-btn px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Photos</button>
        @endif
        @if($hasVideos)
            <button onclick="filterGallery('video')" class="gallery-filter-btn px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Videos</button>
        @endif
        @if($hasVirtualTour)
            <button onclick="filterGallery('virtual_tour')" class="gallery-filter-btn px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Virtual Tour</button>
        @endif
        @if($hasFloorPlans)
            <button onclick="filterGallery('floor_plan')" class="gallery-filter-btn px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">Floor Plans</button>
        @endif
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 h-[400px] md:h-[550px] rounded-2xl overflow-hidden shadow-lg relative group bg-gray-100">
        
        <!-- Main Large Area (Primary Image) -->
        <div class="md:col-span-3 h-full relative cursor-pointer overflow-hidden group/main" onclick="openLightbox(0)">
            <img src="{{ $media[0]['url'] }}" class="w-full h-full object-cover group-hover/main:scale-105 transition-transform duration-700" alt="{{ $media[0]['title'] }}" loading="eager">
            <div class="absolute inset-0 bg-black/10 group-hover/main:bg-black/0 transition-colors duration-500"></div>
            @if($media[0]['type'] === 'video')
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center text-[var(--color-primary)] shadow-lg shadow-black/20">
                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            @endif
            
            <div class="absolute bottom-4 left-4 flex gap-2">
                <span class="bg-black/60 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-lg flex items-center shadow-lg">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ count($media) }} Media
                </span>
            </div>
        </div>
        
        <!-- Thumbnails Column -->
        <div class="hidden md:flex flex-col gap-4 h-full overflow-hidden">
            @foreach(array_slice($media, 1, 3) as $index => $item)
                <div class="h-1/3 relative cursor-pointer overflow-hidden rounded-r-none group/thumb" onclick="openLightbox({{ $index + 1 }})">
                    <img src="{{ $item['thumbnail'] }}" class="w-full h-full object-cover group-hover/thumb:scale-110 transition-transform duration-500" alt="{{ $item['title'] }}" loading="lazy">
                    <div class="absolute inset-0 bg-black/20 group-hover/thumb:bg-black/0 transition-colors"></div>
                    
                    @if($item['type'] === 'video')
                        <div class="absolute bottom-2 left-2 bg-black/60 text-white p-1.5 rounded-full shadow-lg">
                            <svg class="w-3 h-3 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                        </div>
                    @elseif($item['type'] === 'virtual_tour')
                        <div class="absolute bottom-2 left-2 bg-black/60 text-white p-1.5 rounded-full shadow-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        </div>
                    @endif
                    
                    @if($loop->last && count($media) > 4)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center hover:bg-black/40 transition-colors">
                            <span class="text-white font-bold text-lg">+{{ count($media) - 4 }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Mobile View Button -->
        <button class="md:hidden absolute bottom-4 right-4 bg-white/95 backdrop-blur-md text-[var(--color-primary)] font-semibold px-4 py-2.5 rounded-lg shadow-xl flex items-center text-sm z-10" onclick="openLightbox(0)">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            View Gallery
        </button>
    </div>
</div>

<!-- ADVANCED LIGHTBOX UI -->
<div id="advancedLightbox" class="fixed inset-0 z-[200] bg-black hidden flex-col transition-opacity duration-300 opacity-0" aria-modal="true" role="dialog">
    
    <!-- Header -->
    <div class="flex justify-between items-center p-4 text-white absolute top-0 w-full z-20 bg-gradient-to-b from-black/80 to-transparent">
        <div class="flex items-center gap-4">
            <button id="lightboxCloseBtn" onclick="closeLightbox()" class="p-2 hover:bg-white/20 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-white/50" aria-label="Close Lightbox">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="font-medium text-base md:text-lg hidden md:block">Property Media</div>
            <div id="lightboxCounter" class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold tracking-widest">1 / {{ count($media) }}</div>
            <div id="lightboxTypeBadge" class="bg-[var(--color-accent)] text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider hidden md:block">Image</div>
        </div>
        
        <div class="flex items-center gap-2">
            <button id="lightboxZoomBtn" onclick="toggleZoom()" class="p-2 hover:bg-white/20 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-white/50 hidden md:block" aria-label="Zoom Image">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
            </button>
        </div>
    </div>
    
    <!-- Prev Button -->
    <button onclick="prevMedia()" class="absolute left-2 md:left-6 top-1/2 transform -translate-y-1/2 p-3 bg-black/60 hover:bg-black/90 text-white rounded-full transition-colors focus:outline-none z-20" aria-label="Previous Media">
        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    
    <!-- Main Media Area -->
    <div id="lightboxMainArea" class="flex-1 flex items-center justify-center p-0 md:p-12 h-full w-full relative overflow-hidden">
        <!-- Media Elements will be injected here by JS -->
    </div>
    
    <!-- Next Button -->
    <button onclick="nextMedia()" class="absolute right-2 md:right-6 top-1/2 transform -translate-y-1/2 p-3 bg-black/60 hover:bg-black/90 text-white rounded-full transition-colors focus:outline-none z-20" aria-label="Next Media">
        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <!-- Thumbnail Strip -->
    <div class="absolute bottom-0 w-full bg-black/80 backdrop-blur-md p-4 hidden md:flex gap-3 overflow-x-auto z-20 scrollbar-hide" id="lightboxThumbnails">
        @foreach($media as $index => $item)
            <button onclick="goToMedia({{ $index }})" class="relative h-16 w-24 flex-shrink-0 rounded-md overflow-hidden border-2 {{ $index === 0 ? 'border-[var(--color-accent)]' : 'border-transparent opacity-50 hover:opacity-100' }} transition-all lb-thumb" id="lb-thumb-{{ $index }}">
                <img src="{{ $item['thumbnail'] }}" class="w-full h-full object-cover" alt="Thumbnail {{ $index + 1 }}">
                @if($item['type'] === 'video')
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-black/60 rounded-full p-1"><svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg></div>
                    </div>
                @endif
            </button>
        @endforeach
    </div>
</div>

<script>
    // Property Media Data
    const propertyMedia = @json($media);
    let currentMediaIndex = 0;
    let isZoomed = false;
    let activeFilter = 'all';
    
    // Elements
    const lightbox = document.getElementById('advancedLightbox');
    const lightboxMainArea = document.getElementById('lightboxMainArea');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const lightboxTypeBadge = document.getElementById('lightboxTypeBadge');
    let currentVideo = null;

    // Filter Logic
    window.filterGallery = function(type) {
        activeFilter = type;
        
        // Update Filter Buttons
        document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
            btn.classList.remove('bg-[var(--color-primary)]', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-600');
        });
        event.target.classList.remove('bg-gray-100', 'text-gray-600');
        event.target.classList.add('bg-[var(--color-primary)]', 'text-white');
        
        // Find first image matching type to open it
        const firstMatchIndex = propertyMedia.findIndex(m => type === 'all' || m.type === type);
        if (firstMatchIndex !== -1) {
            openLightbox(firstMatchIndex);
        }
    };

    // Lightbox Logic
    window.openLightbox = function(index) {
        currentMediaIndex = index;
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // prevent scroll
        
        // Accessibility Focus
        document.getElementById('lightboxCloseBtn').focus();
        
        setTimeout(() => { lightbox.classList.remove('opacity-0'); }, 10);
        renderMedia();
    };

    window.closeLightbox = function() {
        if (currentVideo) {
            currentVideo.pause();
        }
        lightbox.classList.add('opacity-0');
        setTimeout(() => {
            lightbox.classList.add('hidden');
            document.body.style.overflow = '';
            lightboxMainArea.innerHTML = '';
        }, 300);
    };

    window.nextMedia = function() {
        currentMediaIndex = (currentMediaIndex + 1) % propertyMedia.length;
        // Skip based on filter if needed
        if (activeFilter !== 'all') {
            while (propertyMedia[currentMediaIndex].type !== activeFilter) {
                currentMediaIndex = (currentMediaIndex + 1) % propertyMedia.length;
            }
        }
        renderMedia();
    };

    window.prevMedia = function() {
        currentMediaIndex = (currentMediaIndex - 1 + propertyMedia.length) % propertyMedia.length;
        if (activeFilter !== 'all') {
            while (propertyMedia[currentMediaIndex].type !== activeFilter) {
                currentMediaIndex = (currentMediaIndex - 1 + propertyMedia.length) % propertyMedia.length;
            }
        }
        renderMedia();
    };

    window.goToMedia = function(index) {
        currentMediaIndex = index;
        renderMedia();
    };

    window.toggleZoom = function() {
        const img = document.getElementById('lightboxImageElement');
        if (!img) return;
        
        isZoomed = !isZoomed;
        if (isZoomed) {
            img.style.transform = 'scale(2)';
            img.style.cursor = 'zoom-out';
        } else {
            img.style.transform = 'scale(1)';
            img.style.cursor = 'zoom-in';
            img.style.left = '0';
            img.style.top = '0';
        }
    };

    function renderMedia() {
        const media = propertyMedia[currentMediaIndex];
        lightboxCounter.innerText = `${currentMediaIndex + 1} / ${propertyMedia.length}`;
        lightboxTypeBadge.innerText = media.type.replace('_', ' ');
        isZoomed = false;
        
        // Stop prev video
        if (currentVideo) {
            currentVideo.pause();
            currentVideo = null;
        }

        // Update active thumb
        document.querySelectorAll('.lb-thumb').forEach((thumb, idx) => {
            if (idx === currentMediaIndex) {
                thumb.classList.remove('border-transparent', 'opacity-50');
                thumb.classList.add('border-[var(--color-accent)]', 'opacity-100');
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.add('border-transparent', 'opacity-50');
                thumb.classList.remove('border-[var(--color-accent)]', 'opacity-100');
            }
        });

        // Render Media
        lightboxMainArea.innerHTML = '';
        
        if (media.type === 'image' || media.type === 'floor_plan') {
            const img = document.createElement('img');
            img.id = 'lightboxImageElement';
            img.src = media.url;
            img.alt = media.title;
            img.className = 'max-h-full max-w-full object-contain transition-transform duration-300 ease-out cursor-zoom-in';
            img.onclick = toggleZoom;
            
            // Drag support for zoomed image
            let isDragging = false;
            let startX, startY, currentX = 0, currentY = 0;
            
            img.addEventListener('mousedown', (e) => {
                if(!isZoomed) return;
                isDragging = true;
                startX = e.clientX - currentX;
                startY = e.clientY - currentY;
                img.style.cursor = 'grabbing';
            });
            window.addEventListener('mousemove', (e) => {
                if(!isDragging || !isZoomed) return;
                e.preventDefault();
                currentX = e.clientX - startX;
                currentY = e.clientY - startY;
                img.style.transform = `scale(2) translate(${currentX/2}px, ${currentY/2}px)`;
            });
            window.addEventListener('mouseup', () => {
                isDragging = false;
                if(isZoomed) img.style.cursor = 'zoom-out';
            });
            
            lightboxMainArea.appendChild(img);
            document.getElementById('lightboxZoomBtn').classList.remove('hidden');
        } 
        else if (media.type === 'video') {
            const video = document.createElement('video');
            video.src = media.url;
            video.poster = media.thumbnail;
            video.controls = true;
            video.autoplay = false;
            video.className = 'max-h-full max-w-full outline-none shadow-2xl';
            lightboxMainArea.appendChild(video);
            currentVideo = video;
            document.getElementById('lightboxZoomBtn').classList.add('hidden');
        }
        else if (media.type === 'virtual_tour') {
            const container = document.createElement('div');
            container.className = 'flex flex-col items-center justify-center text-center text-white space-y-4 max-w-md';
            container.innerHTML = `
                <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center border border-white/20 mb-4">
                    <svg class="w-12 h-12 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                </div>
                <h3 class="text-3xl font-bold font-heading">360° Virtual Tour</h3>
                <p class="text-gray-400">The virtual tour is currently being processed and will be available shortly.</p>
                <button onclick="closeLightbox()" class="mt-4 px-6 py-2 border border-white/30 rounded-lg hover:bg-white/10 transition-colors">Return to Gallery</button>
            `;
            lightboxMainArea.appendChild(container);
            document.getElementById('lightboxZoomBtn').classList.add('hidden');
        }
    }

    // Keyboard bindings
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextMedia();
            if (e.key === 'ArrowLeft') prevMedia();
        }
    });
    
    // Swipe Support for mobile
    let touchstartX = 0;
    let touchendX = 0;
    
    lightboxMainArea.addEventListener('touchstart', e => {
        touchstartX = e.changedTouches[0].screenX;
    }, {passive: true});
    
    lightboxMainArea.addEventListener('touchend', e => {
        touchendX = e.changedTouches[0].screenX;
        handleSwipe();
    }, {passive: true});
    
    function handleSwipe() {
        if (isZoomed) return;
        const threshold = 50;
        if (touchendX < touchstartX - threshold) nextMedia();
        if (touchendX > touchstartX + threshold) prevMedia();
    }
</script>
