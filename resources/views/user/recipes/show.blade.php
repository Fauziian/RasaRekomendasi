@extends('layouts.app')
@section('title', $recipe->title)

@push('styles')
<style>
    /* Hero Banner overlay styled like figma detail */
    .recipe-detail-hero {
        height: 440px;
        position: relative;
        background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4)), 
                    url('https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=1200&q=80') center/cover no-repeat;
        display: flex;
        align-items: flex-end;
        padding-bottom: 30px;
    }
    .recipe-hero-overlay-card {
        background: #FDFCF8;
        border-radius: 20px;
        padding: 28px 36px;
        max-width: 680px;
        margin-left: 5%;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid #EAE6DF;
    }
    .stars-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #FFA500;
        margin-bottom: 8px;
        font-weight: 700;
    }
    .detail-pill-row {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        flex-wrap: wrap;
    }
    .detail-badge-custom {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFF;
        border: 1px solid #EAE6DF;
        color: #555;
    }

    /* Cooking layout split */
    .detail-split-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    /* Steps list */
    .step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #FF5A36;
        color: #FFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Sidebar actions */
    .recipe-action-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.02);
    }
    .btn-action-solid {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        background: #FF5A36;
        color: #FFF;
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 12px;
        transition: opacity 0.2s;
    }
    .btn-action-outline {
        width: 100%;
        padding: 13px;
        border-radius: 12px;
        background: #FFF;
        border: 1.5px solid #EAE6DF;
        color: #555;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 12px;
        transition: background 0.2s;
    }
    .btn-action-outline:hover {
        background: #FAF9F6;
    }

    /* Rating review block */
    .btn-review-post {
        padding: 10px 24px;
        border-radius: 10px;
        background: #FF5A36;
        color: #FFF;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .detail-split-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<!-- Header Banner cover with Figma overlay details -->
<div class="recipe-detail-hero" style="background-image: url('{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&q=80' }}');">
    <div class="recipe-hero-overlay-card">
        <div class="stars-row">
            <i class="fas fa-star"></i>
            <span>4.8 <span style="color:#777; font-weight:500;">(124 reviews)</span></span>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; color: #111; font-family:'Outfit',sans-serif;">{{ $recipe->title }}</h1>
        <div class="detail-pill-row">
            <span class="detail-badge-custom"><i class="far fa-clock"></i> {{ $recipe->total_time }} Mins</span>
            <span class="detail-badge-custom"><i class="fas fa-signal"></i> {{ ucfirst($recipe->difficulty) }} Difficulty</span>
            <span class="detail-badge-custom" style="background:#E8F5E9; border-color:#C8E6C9; color:#2E7D32;"><i class="fas fa-leaf"></i> Healthy Choice</span>
        </div>
    </div>
</div>

<!-- Main Split Container -->
<div class="detail-split-grid">
    <!-- Left (2fr): Ingredients, Video, Steps, and reviews -->
    <div>
        <!-- Video Tutorial for VIP or regular recipe placeholder -->
        @if($recipe->is_vip_content && (!Auth::check() || !Auth::user()->hasActiveVip()))
            <div style="background: linear-gradient(135deg, #FFF9C4, #FFE082); border-radius: 20px; padding: 40px; text-align: center; margin-bottom: 36px;">
                <i class="fas fa-lock" style="font-size: 44px; color:#F57F17; margin-bottom: 12px;"></i>
                <h3 style="font-size: 18px; font-weight: 800; color: #5D4037; margin-bottom: 8px;">VIP Masterclass Video Tutorial</h3>
                <p style="font-size: 13px; color: #5D4037; max-width: 440px; margin: 0 auto 20px auto; line-height: 1.6;">
                    Video instruksi detail langkah-demi-langkah dari Chef kami hanya tersedia untuk member VIP premium.
                </p>
                <a href="{{ route('vip.index') }}" class="btn" style="background:#F57F17; color:#FFF; font-weight:700; border-radius:24px; padding:10px 24px;">Upgrade VIP</a>
            </div>
        @else
            <!-- Giant high-fidelity HTML5 visual player -->
            <div style="position:relative; background:#000; border-radius:20px; overflow:hidden; height:380px; display:flex; align-items:center; justify-content:center; margin-bottom:36px; box-shadow:0 12px 30px rgba(0,0,0,0.06);">
                <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&q=80' }}" style="width:100%; height:100%; object-fit:cover; opacity:0.65;" alt="">
                <a href="#" style="position:absolute; font-size:64px; color:#FF5A36; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-play-circle"></i>
                </a>
                <div style="position:absolute; bottom:20px; left:20px; color:#FFF; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.6); font-size:13px; display:flex; align-items:center; gap:6px;">
                    <i class="fas fa-crown" style="color:#FFD700;"></i> Tutorial Video Masak Eksklusif VIP
                </div>
            </div>
        @endif

        <!-- Ingredients Checklist Grid -->
        <div style="margin-bottom:44px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="font-size:20px; font-weight:800; color:#111;">Ingredients <span style="font-size:13px; font-weight:500; color:#777;">(items: {{ $recipe->ingredients ? count($recipe->ingredients) : 6 }})</span></h3>
                <button style="border:none; background:transparent; color:#FF5A36; font-weight:800; font-size:12px; cursor:pointer;"><i class="fas fa-shopping-cart"></i> Add all to Cart</button>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                @if($recipe->ingredients && count($recipe->ingredients) > 0)
                    @foreach($recipe->ingredients as $ing)
                    <div style="padding:16px; background:#FFF; border:1px solid #EAE6DF; border-radius:12px; display:flex; align-items:center; gap:12px;">
                        <input type="checkbox" style="width:18px; height:18px; accent-color:#FF5A36; cursor:pointer;">
                        <div>
                            <strong style="font-size:13px; color:#111;">{{ $ing['name'] }}</strong><br>
                            <span style="font-size:11px; color:#777;">{{ $ing['amount'] }} {{ $ing['unit'] }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- High fidelity Figma-spec Fallback Checklist -->
                    @foreach([
                        ['200g Ramen Noodles', 'Fresh or Dried'],
                        ['150g Firm Tempeh', 'Cut into 1in cubes'],
                        ['2 tbsp Sambal Oelek', 'Adjust for heat'],
                        ['400ml Coconut Milk', 'Full fat for creaminess'],
                        ['1 bunch Bok Choy', 'Washed and halved'],
                        ['Garnish: Sesame Seeds', 'Toasted lightly']
                    ] as $item)
                    <div style="padding:16px; background:#FFF; border:1px solid #EAE6DF; border-radius:12px; display:flex; align-items:center; gap:12px;">
                        <input type="checkbox" style="width:18px; height:18px; accent-color:#FF5A36; cursor:pointer;">
                        <div>
                            <strong style="font-size:13px; color:#111;">{{ $item[0] }}</strong><br>
                            <span style="font-size:11px; color:#777;">{{ $item[1] }}</span>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Cooking Steps -->
        <div style="margin-bottom:44px;">
            <h3 style="font-size:20px; font-weight:800; color:#111; margin-bottom:20px;">Cooking Steps</h3>
            <div style="display:flex; flex-direction:column; gap:28px;">
                @if($recipe->cooking_steps && count($recipe->cooking_steps) > 0)
                    @foreach($recipe->cooking_steps as $idx => $step)
                    <div style="display:flex; gap:20px; align-items:flex-start;">
                        <div class="step-circle">{{ $idx + 1 }}</div>
                        <div style="flex:1;">
                            <strong style="font-size:14px; color:#111; display:block; margin-bottom:4px;">Langkah {{ $idx + 1 }}</strong>
                            <p style="font-size:13px; color:#555; line-height:1.6;">{{ $step['instruction'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Figma specific mock visual steps -->
                    <div style="display:flex; gap:20px; align-items:flex-start;">
                        <div class="step-circle">1</div>
                        <div style="flex:1;">
                            <strong style="font-size:14px; color:#111; display:block; margin-bottom:4px;">Prepare the Crispy Tempeh</strong>
                            <p style="font-size:13px; color:#555; line-height:1.6;">Toss the tempeh cubes with cornstarch and a pinch of salt. Pan-fry in hot oil until every side is golden brown and crunchy. Set aside on a paper towel.</p>
                            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=600&q=80" style="width:100%; height:180px; object-fit:cover; border-radius:12px; margin-top:10px;" alt="">
                        </div>
                    </div>
                    <div style="display:flex; gap:20px; align-items:flex-start;">
                        <div class="step-circle">2</div>
                        <div style="flex:1;">
                            <strong style="font-size:14px; color:#111; display:block; margin-bottom:4px;">Simmer the Broth</strong>
                            <p style="font-size:13px; color:#555; line-height:1.6;">In a large pot, sauté aromatics then stir in coconut milk and sambal. Bring to a gentle simmer for 10 minutes to let the flavors marry.</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:20px; align-items:flex-start;">
                        <div class="step-circle">3</div>
                        <div style="flex:1;">
                            <strong style="font-size:14px; color:#111; display:block; margin-bottom:4px;">Assemble & Serve</strong>
                            <p style="font-size:13px; color:#555; line-height:1.6;">Cook noodles separately. Place noodles in a bowl, pour over the hot broth, and top with bok choy, crispy tempeh, and sesame seeds.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Community Ratings/Reviews -->
        <div style="margin-top:50px; border-top:1px solid #EAE6DF; padding-top:40px;">
            <h3 style="font-size:20px; font-weight:800; color:#111; margin-bottom:20px;">Community Ratings</h3>

            @auth
            <div style="background:#FAF8F5; border-radius:16px; padding:24px; border:1px solid #EAE6DF; margin-bottom:32px;">
                <h4 style="font-size:14px; font-weight:800; color:#111; margin-bottom:12px;">How was your dish?</h4>
                <form method="POST" action="{{ route('recipes.rate', $recipe) }}" style="display:flex; flex-direction:column; gap:16px;">
                    @csrf
                    <div>
                        <div style="display:flex; gap:8px; font-size:18px; color:#EAE6DF; cursor:pointer;" id="starsSelector">
                            <i class="far fa-star" onclick="setRating(1)"></i>
                            <i class="far fa-star" onclick="setRating(2)"></i>
                            <i class="far fa-star" onclick="setRating(3)"></i>
                            <i class="far fa-star" onclick="setRating(4)"></i>
                            <i class="far fa-star" onclick="setRating(5)"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="5" required>
                    </div>

                    <textarea name="comment" rows="3" placeholder="Share your cooking experience..." style="width:100%; border-radius:10px; border:1.5px solid #EAE6DF; padding:12px; font-family:inherit; font-size:13px; outline:none;" required></textarea>
                    
                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" class="btn-review-post">Post Review</button>
                    </div>
                </form>
            </div>
            @endauth

            <div style="display:flex; flex-direction:column; gap:20px;">
                @forelse($recipe->ratings()->where('is_approved', true)->latest()->get() as $review)
                <div style="display:flex; gap:16px; border-bottom:1px solid #FAF9F6; padding-bottom:16px;">
                    <img src="{{ $review->user->avatar_url }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;" alt="">
                    <div>
                        <div style="font-size:13px; font-weight:800; color:#111;">{{ $review->user->name }} <span style="font-size:11px; color:#999; font-weight:500; margin-left:8px;">{{ $review->created_at->diffForHumans() }}</span></div>
                        <div style="color:#FFA500; font-size:11px; margin:4px 0;">
                            @for($i=1; $i<=5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <p style="font-size:13px; color:#555; line-height:1.5;">{{ $review->comment }}</p>
                    </div>
                </div>
                @empty
                <!-- Figma specific mock comments -->
                <div style="display:flex; gap:16px; border-bottom:1px solid #FAF9F6; padding-bottom:16px;">
                    <img src="https://i.pravatar.cc/80?img=47" style="width:40px; height:40px; border-radius:50%; object-fit:cover;" alt="">
                    <div>
                        <div style="font-size:13px; font-weight:800; color:#111;">Maya Putri <span style="font-size:11px; color:#999; font-weight:500; margin-left:8px;">2 days ago</span></div>
                        <div style="color:#FFA500; font-size:10px; margin:4px 0;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p style="font-size:13px; color:#555; line-height:1.5;">"The crispy tempeh is a game changer! I added some lime juice at the end for extra tang."</p>
                    </div>
                </div>
                <div style="display:flex; gap:16px; border-bottom:1px solid #FAF9F6; padding-bottom:16px;">
                    <img src="https://i.pravatar.cc/80?img=33" style="width:40px; height:40px; border-radius:50%; object-fit:cover;" alt="">
                    <div>
                        <div style="font-size:13px; font-weight:800; color:#111;">Budi Santoso <span style="font-size:11px; color:#999; font-weight:500; margin-left:8px;">1 week ago</span></div>
                        <div style="color:#FFA500; font-size:10px; margin:4px 0;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                        <p style="font-size:13px; color:#555; line-height:1.5;">"Great fusion idea. Broth was a bit spicy for me, maybe use 1 tbsp sambal instead of 2 next time."</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right (1fr): Actions and Similar recipes -->
    <aside>
        <div class="recipe-action-card">
            <h4 style="font-size:12px; font-weight:700; color:#999; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:16px;">Recipe Action</h4>
            
            <button class="btn-action-solid"><i class="fas fa-fire"></i> Start Cooking Mode</button>
            
            <button class="btn-action-outline"><i class="fas fa-share-alt"></i> Share with Friends</button>
            
            <form method="POST" action="{{ route('recipes.save', $recipe) }}">
                @csrf
                @php $isSaved = Auth::check() && Auth::user()->savedRecipes()->where('recipe_id', $recipe->id)->exists(); @endphp
                <button type="submit" class="btn-action-outline">
                    <i class="{{ $isSaved ? 'fas fa-bookmark' : 'far fa-bookmark' }}"></i> 
                    {{ $isSaved ? 'Saved to Collection' : 'Save to Collection' }}
                </button>
            </form>

            <div style="display:flex; align-items:center; gap:12px; margin-top:20px; border-top:1px solid #FAF9F6; padding-top:16px;">
                <img src="{{ $recipe->chef->avatar_url ?? 'https://ui-avatars.com/api/?name=Chef&size=40' }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;" alt="">
                <div>
                    <span style="font-size:10px; color:#999; display:block;">RECIPE BY</span>
                    <strong style="font-size:13px; color:#111;">Chef {{ $recipe->chef->name ?? 'Rinnia' }}</strong>
                </div>
            </div>
        </div>

        <!-- Similar Recipes -->
        <div style="margin-top:40px;">
            <h3 style="font-size:18px; font-weight:800; color:#111; margin-bottom:16px;">Similar Recipes</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                @if($similar && count($similar) > 0)
                    @foreach($similar as $sim)
                    <a href="{{ route('recipes.show', $sim->slug) }}" style="display:flex; gap:12px; background:#FFF; border:1px solid #EAE6DF; border-radius:12px; padding:10px; text-decoration:none; color:inherit;">
                        <img src="{{ $sim->image ? asset('storage/' . $sim->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&q=80' }}" style="width:60px; height:60px; border-radius:10px; object-fit:cover;" alt="">
                        <div>
                            <h5 style="font-size:13px; font-weight:800; color:#111; line-height:1.3; margin-bottom:4px;">{{ $sim->title }}</h5>
                            <span style="font-size:11px; color:#FF5A36; font-weight:700;">{{ $sim->total_time }} Mins</span>
                        </div>
                    </a>
                    @endforeach
                @else
                    <!-- Figma specific Mock similar recipes -->
                    <a href="#" style="display:flex; gap:12px; background:#FFF; border:1px solid #EAE6DF; border-radius:12px; padding:10px; text-decoration:none; color:inherit;">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&q=80" style="width:60px; height:60px; border-radius:10px; object-fit:cover;" alt="">
                        <div>
                            <h5 style="font-size:13px; font-weight:800; color:#111; line-height:1.3; margin-bottom:4px;">Authentic Indo Gado-Gado with Satay Sauce</h5>
                            <span style="font-size:11px; color:#FF5A36; font-weight:700;">20 Mins</span>
                        </div>
                    </a>
                    <a href="#" style="display:flex; gap:12px; background:#FFF; border:1px solid #EAE6DF; border-radius:12px; padding:10px; text-decoration:none; color:inherit;">
                        <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=100&q=80" style="width:60px; height:60px; border-radius:10px; object-fit:cover;" alt="">
                        <div>
                            <h5 style="font-size:13px; font-weight:800; color:#111; line-height:1.3; margin-bottom:4px;">Creamy Seafood Laksa Bowl</h5>
                            <span style="font-size:11px; color:#FF5A36; font-weight:700;">40 Mins</span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </aside>
</div>

@endsection

@push('scripts')
<script>
function setRating(val) {
    document.getElementById('ratingValue').value = val;
    const stars = document.getElementById('starsSelector').children;
    for (let i = 0; i < stars.length; i++) {
        if (i < val) {
            stars[i].className = 'fas fa-star';
            stars[i].style.color = '#FFA500';
        } else {
            stars[i].className = 'far fa-star';
            stars[i].style.color = '#EAE6DF';
        }
    }
}
// Set initial rating style
setRating(5);
</script>
@endpush
