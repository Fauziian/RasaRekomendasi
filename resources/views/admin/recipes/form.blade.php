@extends('layouts.admin')
@section('title', isset($recipe) ? 'Edit Recipe' : 'Add Recipe')

@section('content')
<!-- Header Row -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px">
    <h1 style="font-size:28px;font-weight:800;color:#111;font-family:'Outfit',sans-serif">
        {{ isset($recipe) ? 'Edit Recipe' : 'Add New Recipe' }}
    </h1>
    <div style="display:flex;align-items:center;gap:20px">
        <a href="{{ route('admin.recipes.index') }}" style="color:#777;font-weight:600;font-size:14px;display:flex;align-items:center;gap:6px;text-decoration:none;">
            <i class="fas fa-times" style="font-size:16px;"></i> Cancel
        </a>
        <button type="submit" form="recipeForm" class="btn btn-primary" style="background:#A03010;border:none;font-size:14px;padding:10px 24px;border-radius:10px;">
            <i class="fas fa-upload" style="margin-right:6px"></i> {{ isset($recipe) ? 'Save Changes' : 'Publish' }}
        </button>
    </div>
</div>

<form id="recipeForm" method="POST" action="{{ isset($recipe) ? route('admin.recipes.update',$recipe) : route('admin.recipes.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($recipe)) @method('PUT') @endif

    <!-- Section 1: Basic Information -->
    <div class="white-card" style="border-radius:16px;padding:28px;margin-bottom:26px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:36px;height:36px;background:#FFF0EC;border-radius:50%;color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:16px;">
                <i class="fas fa-info"></i>
            </div>
            <h3 style="font-size:18px;font-weight:800;color:#111">Basic Information</h3>
        </div>

        <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:32px;">
            <!-- Left Side: Title & Description -->
            <div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Recipe Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Spicy Rendang Padang" value="{{ old('title',$recipe->title ?? '') }}" style="padding:12px 14px;" required>
                </div>
                <div class="form-group" style="margin-top:20px;">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Description</label>
                    <textarea name="description" class="form-control" placeholder="Briefly describe your recipe..." rows="4" style="padding:12px 14px;resize:none;">{{ old('description',$recipe->description ?? '') }}</textarea>
                </div>
            </div>

            <!-- Right Side: Hero Image Upload -->
            <div>
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;display:block;">Hero Image</label>
                <div id="imgContainer" onclick="document.getElementById('imgInput').click()" style="border:2px dashed #DDD;border-radius:16px;padding:32px 20px;text-align:center;background:#F8F9FA;cursor:pointer;position:relative;height:165px;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--primary)';this.style.background='#FFF';" onmouseout="this.style.borderColor='#DDD';this.style.background='#F8F9FA';">
                    @if(isset($recipe) && $recipe->image)
                        <img id="imgPreview" src="{{ $recipe->image_url }}" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;" alt="Hero Image">
                        <div style="position:absolute;background:rgba(0,0,0,0.5);color:#fff;padding:4px 8px;border-radius:4px;font-size:10px;font-weight:700;bottom:10px;">Change Photo</div>
                    @else
                        <div id="imgPlaceholder">
                            <div style="font-size:32px;color:var(--primary);margin-bottom:8px;"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div style="color:#111;font-size:13px;font-weight:700;">Click to upload photo</div>
                            <div style="color:#bbb;font-size:10px;margin-top:4px">Max size 5MB (PNG, JPG)</div>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" style="display:none" id="imgInput" onchange="previewImage(this)">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Recipe Details -->
    <div class="white-card" style="border-radius:16px;padding:28px;margin-bottom:26px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:36px;height:36px;background:#FFF9EF;border-radius:50%;color:#FF9800;display:flex;align-items:center;justify-content:center;font-size:16px;">
                <i class="fas fa-sliders-h"></i>
            </div>
            <h3 style="font-size:18px;font-weight:800;color:#111">Recipe Details</h3>
        </div>

        <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:20px;">
            <!-- Category -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Category</label>
                <select name="category_id" class="form-control" style="padding:11px 14px;cursor:pointer;" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id',($recipe->category_id ?? '')) == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Chef / Taste Profile (Chef selector used for business model) -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Chef / Provider</label>
                <select name="chef_id" class="form-control" style="padding:11px 14px;cursor:pointer;" required>
                    <option value="">Select Chef</option>
                    @foreach($chefs as $chef)
                        <option value="{{ $chef->id }}" {{ old('chef_id',($recipe->chef_id ?? '')) == $chef->id ? 'selected':'' }}>{{ $chef->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Difficulty (Custom Interactive Pills) -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;display:block;">Difficulty</label>
                <input type="hidden" name="difficulty" id="difficultyInput" value="{{ old('difficulty',$recipe->difficulty ?? 'easy') }}">
                <div style="display:flex;gap:6px;">
                    <button type="button" onclick="setDifficulty('easy', this)" class="difficulty-pill-btn" style="flex:1;height:42px;border-radius:10px;border:1px solid #FFD0C5;background:#FFF0EC;color:#FF5A36;font-weight:700;font-size:13px;cursor:pointer;transition:all 0.15s;">Easy</button>
                    <button type="button" onclick="setDifficulty('medium', this)" class="difficulty-pill-btn" style="flex:1;height:42px;border-radius:10px;border:1px solid #DDD;background:#FFF;color:#777;font-weight:600;font-size:13px;cursor:pointer;transition:all 0.15s;">Med</button>
                    <button type="button" onclick="setDifficulty('hard', this)" class="difficulty-pill-btn" style="flex:1;height:42px;border-radius:10px;border:1px solid #DDD;background:#FFF;color:#777;font-weight:600;font-size:13px;cursor:pointer;transition:all 0.15s;">Hard</button>
                </div>
            </div>

            <!-- Prep Time (Min) -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Prep Time (Min)</label>
                <div style="position:relative;display:flex;align-items:center;">
                    <input type="number" name="prep_time" class="form-control" value="{{ old('prep_time',$recipe->prep_time ?? '') }}" min="0" style="padding:11px 50px 11px 14px;" required>
                    <span style="position:absolute;right:14px;color:#aaa;font-weight:700;font-size:12px;pointer-events:none;">min</span>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(5, 1fr);gap:16px;margin-top:20px;padding-top:20px;border-top:1px solid #F8F9FA;">
            <!-- Cook Time (Min) -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Cook Time (Min)</label>
                <div style="position:relative;display:flex;align-items:center;">
                    <input type="number" name="cook_time" class="form-control" value="{{ old('cook_time',$recipe->cook_time ?? '') }}" min="0" style="padding:11px 50px 11px 14px;" required>
                    <span style="position:absolute;right:14px;color:#aaa;font-weight:700;font-size:12px;pointer-events:none;">min</span>
                </div>
            </div>

            <!-- Calories -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Calories</label>
                <input type="number" name="calories" class="form-control" value="{{ old('calories',$recipe->calories ?? '') }}" min="0" style="padding:11px 14px;">
            </div>

            <!-- Servings -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Servings</label>
                <input type="number" name="servings" class="form-control" value="{{ old('servings',$recipe->servings ?? 2) }}" min="1" style="padding:11px 14px;">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Status Resep</label>
                <select name="status" class="form-control" style="padding:11px 14px;cursor:pointer;" required>
                    <option value="published" {{ old('status', $recipe->status ?? 'published') == 'published' ? 'selected' : '' }}>✅ Published</option>
                    <option value="draft"     {{ old('status', $recipe->status ?? '') == 'draft'     ? 'selected' : '' }}>📝 Draft</option>
                </select>
            </div>

            <!-- VIP Content Access -->
            <div class="form-group">
                <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">VIP Content Access</label>
                <div style="display:flex;align-items:center;height:42px;gap:10px;background:#FFF9EF;padding:0 14px;border:1px solid #FFE0B2;border-radius:10px;">
                    <input type="checkbox" name="is_vip_content" id="vipCheck" value="1" style="accent-color:#FF9800;width:18px;height:18px;cursor:pointer;" {{ old('is_vip_content',($recipe->is_vip_content ?? false)) ? 'checked':'' }}>
                    <label for="vipCheck" style="font-size:13px;font-weight:700;cursor:pointer;color:#E65100;display:flex;align-items:center;gap:6px;"><i class="fas fa-crown"></i> VIP Exclusive</label>
                </div>
            </div>
        </div>

        {{-- YouTube Video URL --}}
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #F8F9FA;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <div style="width:28px;height:28px;background:#FFEBEE;border-radius:50%;color:#FF0000;display:flex;align-items:center;justify-content:center;font-size:12px;">
                    <i class="fab fa-youtube"></i>
                </div>
                <label style="font-size:11px;font-weight:700;color:#333;text-transform:uppercase;letter-spacing:0.5px;margin:0;">Link Video YouTube <span style="font-weight:400;color:#aaa;">(Opsional)</span></label>
            </div>
            <div style="position:relative;">
                <i class="fab fa-youtube" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FF0000;font-size:16px;pointer-events:none;"></i>
                <input type="url" name="video_url" class="form-control"
                    placeholder="https://www.youtube.com/watch?v=..."
                    value="{{ old('video_url', $recipe->video_url ?? '') }}"
                    style="padding:11px 14px 11px 42px;"
                    oninput="previewVideoUrl(this.value)">
            </div>
            <p style="font-size:11px;color:#aaa;margin-top:6px;margin-bottom:0;">Video ini akan ditampilkan sebagai tutorial memasak di halaman detail resep.</p>
            <div id="videoPreviewWrapper" style="display:none;margin-top:14px;border-radius:12px;overflow:hidden;background:#000;position:relative;padding-bottom:56.25%;height:0;">
                <iframe id="videoPreviewFrame" src="" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" allowfullscreen loading="lazy"></iframe>
            </div>
            @if(isset($recipe) && $recipe->video_url)
            <div style="margin-top:8px;font-size:11px;color:#2E7D32;font-weight:600;">
                <i class="fas fa-check-circle"></i> Video tersimpan. Edit link di atas untuk mengubahnya.
            </div>
            @endif
        </div>
    </div>

    <!-- Section 3: Ingredients -->
    <div class="white-card" style="border-radius:16px;padding:28px;margin-bottom:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:36px;height:36px;background:#E8F5E9;border-radius:50%;color:#2E7D32;display:flex;align-items:center;justify-content:center;font-size:16px;">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:#111">Ingredients</h3>
            </div>
            <button type="button" onclick="addIngredient()" style="border:none;background:transparent;color:var(--primary);font-weight:700;font-size:14px;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>

        <div id="ingredientsList" style="display:flex;flex-direction:column;gap:12px;">
            @if(isset($recipe) && $recipe->ingredients)
                @foreach($recipe->ingredients as $i => $ing)
                <div class="ingredient-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:center">
                    <input type="text" name="ingredients[{{ $i }}][name]" class="form-control" placeholder="Ingredient name (e.g. Garlic)" value="{{ $ing['name'] ?? '' }}" style="padding:11px 14px;">
                    <input type="text" name="ingredients[{{ $i }}][amount]" class="form-control" placeholder="Qty (e.g. 2 Cloves)" value="{{ $ing['amount'] ?? '' }}" style="padding:11px 14px;">
                    <button type="button" onclick="this.parentNode.remove()" style="border:none;background:#FFEBEE;color:#C62828;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                @endforeach
            @else
                <div class="ingredient-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:center">
                    <input type="text" name="ingredients[0][name]" class="form-control" placeholder="Ingredient name (e.g. Garlic)" style="padding:11px 14px;">
                    <input type="text" name="ingredients[0][amount]" class="form-control" placeholder="Qty (e.g. 2 Cloves)" style="padding:11px 14px;">
                    <button type="button" onclick="this.parentNode.remove()" style="border:none;background:#FFEBEE;color:#C62828;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Section 4: Cooking Steps -->
    <div class="white-card" style="border-radius:16px;padding:28px;margin-bottom:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:36px;height:36px;background:#E3F2FD;border-radius:50%;color:#1565C0;display:flex;align-items:center;justify-content:center;font-size:16px;">
                    <i class="fas fa-list-ol"></i>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:#111">Cooking Steps</h3>
            </div>
            <button type="button" onclick="addStep()" style="border:none;background:transparent;color:var(--primary);font-weight:700;font-size:14px;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-plus"></i> Add Step
            </button>
        </div>

        <div id="stepsList" style="display:flex;flex-direction:column;gap:18px;">
            @if(isset($recipe) && $recipe->cooking_steps)
                @foreach($recipe->cooking_steps as $i => $step)
                <div class="step-row" style="display:flex;gap:16px;align-items:flex-start;position:relative;">
                    <div style="width:32px;height:32px;background:#F0F4F8;color:#1A56B0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0;margin-top:10px;">
                        {{ $i+1 }}
                    </div>
                    <div style="flex:1;">
                        <textarea name="cooking_steps[{{ $i }}][instruction]" class="form-control" placeholder="Describe this cooking step..." rows="3" style="padding:11px 14px;resize:none;">{{ $step['instruction'] ?? '' }}</textarea>
                        <div style="display:flex;gap:10px;margin-top:10px;">
                            <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-image"></i> Add Photo</button>
                            <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-clock"></i> Add Timer</button>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentNode.remove(); reorderSteps();" style="border:none;background:#FFEBEE;color:#C62828;width:34px;height:34px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;margin-top:12px;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                @endforeach
            @else
                <div class="step-row" style="display:flex;gap:16px;align-items:flex-start;position:relative;">
                    <div class="step-badge" style="width:32px;height:32px;background:#F0F4F8;color:#1A56B0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0;margin-top:10px;">
                        1
                    </div>
                    <div style="flex:1;">
                        <textarea name="cooking_steps[0][instruction]" class="form-control" placeholder="Describe this cooking step..." rows="3" style="padding:11px 14px;resize:none;"></textarea>
                        <div style="display:flex;gap:10px;margin-top:10px;">
                            <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-image"></i> Add Photo</button>
                            <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-clock"></i> Add Timer</button>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentNode.remove(); reorderSteps();" style="border:none;background:#FFEBEE;color:#C62828;width:34px;height:34px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;margin-top:12px;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</form>

@push('scripts')
<script>
let ingCount = {{ isset($recipe) && $recipe->ingredients ? count($recipe->ingredients) : 1 }};
let stepCount = {{ isset($recipe) && $recipe->cooking_steps ? count($recipe->cooking_steps) : 1 }};

// Difficulty Selector interaction
function setDifficulty(level, element) {
    document.getElementById('difficultyInput').value = level;
    
    // Clear all outlines/backgrounds
    const btns = document.querySelectorAll('.difficulty-pill-btn');
    btns.forEach(btn => {
        btn.style.borderColor = '#DDD';
        btn.style.background = '#FFF';
        btn.style.color = '#777';
        btn.style.fontWeight = '600';
    });
    
    // Apply selected highlights
    element.style.borderColor = '#FFD0C5';
    element.style.background = '#FFF0EC';
    element.style.color = '#FF5A36';
    element.style.fontWeight = '700';
}

// Auto-run setDifficulty on load to match the initial prefilled value
document.addEventListener("DOMContentLoaded", function() {
    const initialDifficulty = document.getElementById('difficultyInput').value || 'easy';
    const btns = document.querySelectorAll('.difficulty-pill-btn');
    btns.forEach(btn => {
        if(btn.innerText.toLowerCase() === initialDifficulty.toLowerCase() || (initialDifficulty === 'medium' && btn.innerText === 'Med')) {
            setDifficulty(initialDifficulty, btn);
        }
    });
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('imgContainer');
            // Reset container padding
            container.style.padding = '0';
            container.style.background = 'transparent';
            // Hide placeholder if exists
            const placeholder = document.getElementById('imgPlaceholder');
            if (placeholder) placeholder.style.display = 'none';
            // Show or create preview img
            let img = document.getElementById('imgPreview');
            if (!img) {
                img = document.createElement('img');
                img.id = 'imgPreview';
                img.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;';
                img.alt = 'Hero Image';
                container.insertBefore(img, input);
                // Add change badge if not exists
                if (!container.querySelector('.preview-badge')) {
                    const badge = document.createElement('div');
                    badge.className = 'preview-badge';
                    badge.style.cssText = 'position:absolute;background:rgba(0,0,0,0.5);color:#fff;padding:4px 8px;border-radius:4px;font-size:10px;font-weight:700;bottom:10px;z-index:1;';
                    badge.textContent = 'Change Photo';
                    container.appendChild(badge);
                }
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function addIngredient() {
    document.getElementById('ingredientsList').insertAdjacentHTML('beforeend',
        `<div class="ingredient-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:center">
            <input type="text" name="ingredients[${ingCount}][name]" class="form-control" placeholder="Ingredient name" style="padding:11px 14px;">
            <input type="text" name="ingredients[${ingCount}][amount]" class="form-control" placeholder="Qty" style="padding:11px 14px;">
            <button type="button" onclick="this.parentNode.remove()" style="border:none;background:#FFEBEE;color:#C62828;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>`);
    ingCount++;
}

function addStep() {
    document.getElementById('stepsList').insertAdjacentHTML('beforeend',
        `<div class="step-row" style="display:flex;gap:16px;align-items:flex-start;position:relative;">
            <div class="step-badge" style="width:32px;height:32px;background:#F0F4F8;color:#1A56B0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0;margin-top:10px;">
                ${stepCount+1}
            </div>
            <div style="flex:1;">
                <textarea name="cooking_steps[${stepCount}][instruction]" class="form-control" placeholder="Describe this cooking step..." rows="3" style="padding:11px 14px;resize:none;"></textarea>
                <div style="display:flex;gap:10px;margin-top:10px;">
                    <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-image"></i> Add Photo</button>
                    <button type="button" class="btn btn-white btn-sm" style="font-size:12px;"><i class="far fa-clock"></i> Add Timer</button>
                </div>
            </div>
            <button type="button" onclick="this.parentNode.remove(); reorderSteps();" style="border:none;background:#FFEBEE;color:#C62828;width:34px;height:34px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;margin-top:12px;">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>`);
    stepCount++;
    reorderSteps();
}

function reorderSteps() {
    const badges = document.querySelectorAll('.step-row .step-badge');
    badges.forEach((badge, idx) => {
        badge.innerText = idx + 1;
    });
}

function previewVideoUrl(url) {
    const wrapper = document.getElementById('videoPreviewWrapper');
    const frame = document.getElementById('videoPreviewFrame');
    if (!url) { wrapper.style.display = 'none'; frame.src = ''; return; }
    const match = url.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|[^\/]+\?v=)|youtu\.be\/)([^"&?\/ ]{11})/i);
    if (match) {
        const timeMatch = url.match(/[?&]t=(\d+)s?/);
        const startParam = timeMatch ? '?start=' + timeMatch[1] : '';
        frame.src = 'https://www.youtube.com/embed/' + match[1] + startParam;
        wrapper.style.display = 'block';
    } else {
        wrapper.style.display = 'none';
        frame.src = '';
    }
}

// Auto-preview on load if editing and video_url exists
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.querySelector('input[name="video_url"]');
    if (urlInput && urlInput.value) previewVideoUrl(urlInput.value);
});
</script>
@endpush
@endsection
