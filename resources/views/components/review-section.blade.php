@props(['type', 'id', 'title' => 'Reviews & Ratings'])

@php
    $allReviews = \App\Models\Review::where('reviewable_type', $type)
                    ->where('reviewable_id', $id)
                    ->where('status', 'published')
                    ->latest()
                    ->get();
    
    $sort = request('sort', 'recent');
    if ($sort === 'highest') {
        $allReviews = $allReviews->sortByDesc('rating')->values();
    } elseif ($sort === 'lowest') {
        $allReviews = $allReviews->sortBy('rating')->values();
    }

    $totalReviews = $allReviews->count();
    $averageRating = $totalReviews > 0 ? round($allReviews->avg('rating'), 1) : 0;
    
    $distribution = [
        5 => ['count' => $allReviews->where('rating', 5)->count(), 'percent' => $totalReviews > 0 ? round(($allReviews->where('rating', 5)->count() / $totalReviews) * 100) : 0],
        4 => ['count' => $allReviews->where('rating', 4)->count(), 'percent' => $totalReviews > 0 ? round(($allReviews->where('rating', 4)->count() / $totalReviews) * 100) : 0],
        3 => ['count' => $allReviews->where('rating', 3)->count(), 'percent' => $totalReviews > 0 ? round(($allReviews->where('rating', 3)->count() / $totalReviews) * 100) : 0],
        2 => ['count' => $allReviews->where('rating', 2)->count(), 'percent' => $totalReviews > 0 ? round(($allReviews->where('rating', 2)->count() / $totalReviews) * 100) : 0],
        1 => ['count' => $allReviews->where('rating', 1)->count(), 'percent' => $totalReviews > 0 ? round(($allReviews->where('rating', 1)->count() / $totalReviews) * 100) : 0],
    ];

    $page = request('page', 1);
    $perPage = 5;
    $reviews = new \Illuminate\Pagination\LengthAwarePaginator(
        $allReviews->forPage($page, $perPage),
        $allReviews->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $userReview = auth()->check() ? \App\Models\Review::where('user_id', auth()->id())->where('reviewable_type', $type)->where('reviewable_id', $id)->first() : null;
@endphp

<div id="reviews-section" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <h2 class="font-heading text-2xl font-bold text-[var(--color-primary)]">{{ $title }}</h2>
        @if(!auth()->check() || !$userReview)
            <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" class="btn-primary py-2 px-6 rounded-lg font-bold shadow-sm whitespace-nowrap">Write a Review</button>
        @endif
    </div>

    @if(session('review_success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 border border-green-100 flex items-center animate-fade-up-scroll">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('review_success') }}
        </div>
    @endif
    @if(session('review_error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-8 border border-red-100 flex items-center animate-fade-up-scroll">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('review_error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-8 border border-red-100 flex items-center animate-fade-up-scroll">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($totalReviews > 0)
        <!-- Rating Summary -->
        <div class="flex flex-col md:flex-row gap-8 mb-10 pb-10 border-b border-gray-100">
            <div class="w-full md:w-1/3 flex flex-col items-center justify-center bg-gray-50 rounded-2xl p-6">
                <span class="text-5xl font-heading font-bold text-[var(--color-primary)]">{{ number_format($averageRating, 1) }}</span>
                <div class="flex items-center mt-2 mb-1 text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @else
                            <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <p class="text-sm text-gray-500 font-medium">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
            </div>
            
            <div class="w-full md:w-2/3 flex flex-col justify-center space-y-3">
                @foreach([5,4,3,2,1] as $star)
                    <div class="flex items-center text-sm">
                        <span class="w-12 text-gray-600 font-medium">{{ $star }} stars</span>
                        <div class="flex-grow mx-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $distribution[$star]['percent'] }}%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-500">{{ $distribution[$star]['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sort -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-heading text-xl font-bold text-[var(--color-primary)]">All Reviews</h3>
            <form method="GET" action="{{ url()->current() }}#reviews-section" class="flex items-center">
                <label for="sort" class="text-sm text-gray-500 mr-2">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-[var(--color-accent)] focus:border-[var(--color-accent)] p-2">
                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Most Recent</option>
                    <option value="highest" {{ request('sort') === 'highest' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="lowest" {{ request('sort') === 'lowest' ? 'selected' : '' }}>Lowest Rated</option>
                </select>
            </form>
        </div>

        <!-- Review List -->
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="border-b border-gray-100 pb-6 last:border-0">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h4>
                                <div class="flex items-center text-xs text-gray-500 mt-0.5">
                                    <span class="mr-2">{{ $review->created_at->format('M d, Y') }}</span>
                                    @if($review->review_context)
                                        <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $review->review_context }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(auth()->check() && auth()->id() === $review->user_id)
                            <div class="flex items-center space-x-2">
                                <button onclick="editReview({{ $review->id }}, {{ $review->rating }}, {{ json_encode($review->title) }}, {{ json_encode($review->body) }}, {{ json_encode($review->review_context) }})" class="text-xs font-medium text-gray-500 hover:text-[var(--color-primary)]">Edit</button>
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Are you sure you want to delete your review?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex text-yellow-400 mb-2 mt-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    
                    @if($review->title)
                        <h5 class="font-bold text-gray-900 mb-1">{{ $review->title }}</h5>
                    @endif
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $review->body }}</p>
                </div>
            @endforeach
        </div>

        @if($reviews->hasPages())
            <div class="mt-8 pt-6 border-t border-gray-100">
                {{ $reviews->links() }}
            </div>
        @endif

    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-[var(--color-primary)]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </div>
            <h3 class="font-heading text-xl font-bold text-gray-900 mb-2">No reviews yet</h3>
            <p class="text-gray-500 mb-6">Be the first to share your experience.</p>
            @if(auth()->check())
                <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" class="btn-primary py-2 px-6 rounded-lg font-bold shadow-sm">Write a Review</button>
            @endif
        </div>
    @endif
</div>

<!-- Review Modal (Create / Edit) -->
<div id="reviewModal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeReviewModal()"></div>
    
    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 id="reviewModalTitle" class="font-heading text-xl font-bold text-[var(--color-primary)]">Write a Review</h3>
            <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            @if(!auth()->check())
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">You must be signed in to write a review.</p>
                    <a href="{{ route('login') }}" class="btn-primary py-2 px-6 rounded-lg inline-block">Sign In</a>
                </div>
            @else
                <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="reviewMethod" value="POST">
                    <input type="hidden" name="reviewable_type" value="{{ $type }}">
                    <input type="hidden" name="reviewable_id" value="{{ $id }}">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Your Rating *</label>
                        <div class="flex items-center" id="starRatingContainer">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-btn text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors" data-rating="{{ $i }}">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required value="0">
                        <p id="ratingError" class="text-red-500 text-xs mt-1 hidden">Please select a rating.</p>
                    </div>
                    
                    <div class="mb-5">
                        <label for="review_context" class="block text-sm font-semibold text-gray-700 mb-2">Review Type <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <select id="review_context" name="review_context" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]">
                            <option value="">Select context...</option>
                            <option value="Property Experience">Property Experience</option>
                            <option value="Agent Experience">Agent Experience</option>
                            <option value="Agency Experience">Agency Experience</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="review_title" class="block text-sm font-semibold text-gray-700 mb-2">Review Title <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="text" id="review_title" name="title" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)]" placeholder="Summarize your experience">
                    </div>
                    
                    <div class="mb-6">
                        <label for="review_body" class="block text-sm font-semibold text-gray-700 mb-2">Review *</label>
                        <textarea id="review_body" name="body" rows="4" required minlength="10" maxlength="2000" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] resize-none" placeholder="Tell us about your experience..."></textarea>
                        <p class="text-xs text-gray-500 mt-1 text-right">Min 10 chars</p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="closeReviewModal()" class="px-6 py-2.5 rounded-lg border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">Cancel</button>
                        <button type="submit" class="btn-primary px-6 py-2.5 rounded-lg shadow-md font-bold">Submit Review</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('ratingInput');
        
        if (stars.length > 0) {
            stars.forEach(star => {
                // Hover effect
                star.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('data-rating');
                    updateStars(rating, true);
                });
                
                // Mouse leave effect
                star.addEventListener('mouseleave', function() {
                    updateStars(ratingInput.value, false);
                });
                
                // Click effect
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    updateStars(rating, false);
                    document.getElementById('ratingError').classList.add('hidden');
                });
            });
            
            function updateStars(rating, isHover) {
                stars.forEach(s => {
                    const starRating = s.getAttribute('data-rating');
                    if (starRating <= rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            }
        }
        
        // Form validation
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                if (ratingInput.value == 0 || ratingInput.value == "") {
                    e.preventDefault();
                    document.getElementById('ratingError').classList.remove('hidden');
                }
            });
        }
    });
    
    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        // Reset form for create state
        const form = document.getElementById('reviewForm');
        if (form) {
            form.reset();
            form.action = "{{ route('reviews.store') }}";
            document.getElementById('reviewMethod').value = "POST";
            document.getElementById('reviewModalTitle').innerText = "Write a Review";
            document.getElementById('ratingInput').value = "0";
            document.getElementById('review_context').value = "";
            
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach(s => {
                s.classList.add('text-gray-300');
                s.classList.remove('text-yellow-400');
            });
        }
    }
    
    function editReview(id, rating, title, body, context) {
        document.getElementById('reviewModal').classList.remove('hidden');
        document.getElementById('reviewModalTitle').innerText = "Edit Review";
        
        const form = document.getElementById('reviewForm');
        form.action = "/reviews/" + id;
        document.getElementById('reviewMethod').value = "PUT";
        
        document.getElementById('ratingInput').value = rating;
        document.getElementById('review_title').value = title || "";
        document.getElementById('review_body').value = body || "";
        document.getElementById('review_context').value = context || "";
        
        // Update stars visually
        const stars = document.querySelectorAll('.star-btn');
        stars.forEach(s => {
            if (s.getAttribute('data-rating') <= rating) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.add('text-gray-300');
                s.classList.remove('text-yellow-400');
            }
        });
    }
</script>
