@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
<!-- Header Row -->
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px">
    <div>
        <h1 style="font-size:32px;font-weight:700;color:#111;font-family:'Outfit',sans-serif">Category Management</h1>
        <p style="color:var(--text-m);margin-top:4px">Manage how recipes are grouped for users and organize taxomony.</p>
    </div>
</div>

<!-- Three Metric Cards -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;margin-bottom:28px">
    <!-- Active Categories -->
    <div class="white-card" style="padding:22px;border-radius:16px;background:#FF5A36;color:#FFF;display:flex;justify-content:space-between;align-items:center;border:none;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:rgba(255,255,255,0.85);letter-spacing:0.8px;">Active Categories</div>
            <div style="font-size:36px;font-weight:800;margin-top:4px;">{{ $categories->total() }}</div>
        </div>
        <div style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">
            <i class="fas fa-utensils"></i>
        </div>
    </div>

    <!-- Most Popular -->
    <div class="white-card" style="padding:22px;border-radius:16px;background:#F4F2EB;color:#333;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#777;letter-spacing:0.8px;">Most Popular</div>
            <div style="font-size:22px;font-weight:800;margin-top:8px;color:#111;">Indonesian Food</div>
        </div>
        <div style="width:48px;height:48px;background:#FFF;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);box-shadow:0 2px 8px rgba(0,0,0,0.04);">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>

    <!-- Pending Sync -->
    <div class="white-card" style="padding:22px;border-radius:16px;background:#E8F5E9;color:#2E7D32;display:flex;justify-content:space-between;align-items:center;border:1px solid #C8E6C9;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#558B2F;letter-spacing:0.8px;">Pending Sync</div>
            <div style="font-size:36px;font-weight:800;margin-top:4px;">0</div>
        </div>
        <div style="width:48px;height:48px;background:#FFF;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#2E7D32;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
</div>

<!-- Section Header -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <div>
        <h2 style="font-size:20px;font-weight:700;color:#111">Live Categories</h2>
        <p style="color:var(--text-m);font-size:13px;margin-top:2px;">Manage how recipes are grouped for users.</p>
    </div>
    <a href="#category-form-section" class="btn btn-primary" style="font-size:13px;background:#A03010;border:none;"><i class="fas fa-plus"></i> New Category</a>
</div>

<!-- Live Categories Grid -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;margin-bottom:32px">
    @forelse($categories as $cat)
    <div class="white-card" style="border-radius:16px;padding:24px;display:flex;flex-direction:column;justify-content:space-between;position:relative;min-height:190px;">
        <!-- Card top menu and icon -->
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div style="width:42px;height:42px;background:#FFF0EC;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;">
                {{ $cat->icon ?? '🍔' }}
            </div>
            
            <!-- Actions buttons inline -->
            <div style="display:flex;gap:6px;">
                <button onclick="scrollToEdit({{ $cat->toJson() }})" style="border:none;background:#E3F2FD;color:#1565C0;width:26px;height:26px;border-radius:50%;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Edit Kategori">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button style="border:none;background:#FFEBEE;color:#C62828;width:26px;height:26px;border-radius:50%;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;" title="Hapus Kategori">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Name and Description -->
        <div style="margin-top:14px;flex:1;">
            <h4 style="font-size:16px;font-weight:700;color:#111;">{{ $cat->name }}</h4>
            <p style="font-size:12px;color:var(--text-m);margin-top:6px;line-height:1.4;">{{ Str::limit($cat->description ?? 'No description provided.', 80) }}</p>
        </div>

        <!-- Recipes Count & Status -->
        <div style="display:flex;justify-content:space-between;align-items:center;border-top:1px solid #F8F9FA;padding-top:12px;margin-top:14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">
            <span style="color:#777;">Recipes: <strong style="color:#111;">{{ $cat->recipes_count }}</strong></span>
            <span style="display:flex;align-items:center;gap:4px;color:#2E7D32;">
                <span style="width:6px;height:6px;background:#2E7D32;border-radius:50%"></span> Active
            </span>
        </div>
    </div>
    @empty
    @endforelse

    <!-- Add Category Dotted Card -->
    <a href="#category-form-section" style="border:2px dashed #DDD;background:#F8F9FA;border-radius:16px;padding:24px;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:190px;cursor:pointer;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='#FFF';this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#F8F9FA';this.style.borderColor='#DDD';">
        <div style="width:42px;height:42px;background:#EEE;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;color:#666;margin-bottom:12px;">
            <i class="fas fa-plus"></i>
        </div>
        <div style="font-size:14px;font-weight:700;color:#555;">Add Category</div>
    </a>
</div>

<!-- PAGINATION -->
<div style="margin-bottom:36px;">
    {{ $categories->links() }}
</div>

<!-- SPA Bottom Form Card: Create / Edit Category -->
<div id="category-form-section" class="white-card" style="border-radius:16px;padding:28px;margin-bottom:28px;">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px">
        <div style="width:36px;height:36px;background:#FFF0EC;border-radius:8px;color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:16px;">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h3 id="form-title" style="font-size:18px;font-weight:700;color:#111">Create New Category</h3>
            <p id="form-desc" style="font-size:12px;color:var(--text-m);margin-top:2px;">Fill in the details to add a new classification.</p>
        </div>
    </div>

    <form id="spaCatForm" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <input type="hidden" name="icon" id="formIconInput" value="🍕">

        <div style="display:grid;grid-template-columns:1fr 1.2fr;gap:32px;">
            <!-- Left inputs side -->
            <div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Category Name</label>
                    <input type="text" name="name" id="formCatName" class="form-control" placeholder="e.g. Street Food" style="padding:11px 14px;" required>
                </div>
                <div class="form-group" style="margin-top:20px;">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;">Description</label>
                    <textarea name="description" id="formCatDesc" class="form-control" placeholder="Briefly describe what goes in here..." rows="4" style="padding:11px 14px;resize:none;"></textarea>
                </div>
            </div>

            <!-- Right pick icon side -->
            <div style="display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#333;margin-bottom:8px;display:block;">Pick an Icon</label>
                    <!-- Emojis selection grid -->
                    <div style="display:grid;grid-template-columns:repeat(5, 1fr);gap:12px;background:#F8F9FA;padding:16px;border-radius:12px;border:1px solid #EEE;">
                        @php
                            $pickerEmojis = ['🍕', '🍰', '🥗', '🍱', '☕', '🍞', '🍤', '🍔', '🍳', '🍩'];
                        @endphp
                        @foreach($pickerEmojis as $idx => $emoji)
                        <div onclick="selectPickerEmoji('{{ $emoji }}', this)" class="emoji-picker-btn" style="height:44px;background:#FFF;border:1px solid #E2E8F0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:22px;cursor:pointer;transition:all 0.15s; {{ $emoji == '🍕' ? 'border-color:var(--primary);box-shadow:0 0 0 2px var(--primary-bg);background:#FFF0EC;' : '' }}" title="Select {{ $emoji }}">
                            {{ $emoji }}
                        </div>
                        @endforeach
                    </div>
                    <span style="font-size:11px;color:var(--text-m);margin-top:8px;display:inline-block;">Select an icon that best represents the food group.</span>
                </div>

                <!-- Form actions buttons -->
                <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:20px;">
                    <button type="button" onclick="discardForm()" class="btn btn-white" style="font-size:13px;border-color:transparent;color:#777;background:transparent;">Discard</button>
                    <button type="submit" id="formSubmitBtn" class="btn btn-primary" style="font-size:13px;background:#A03010;border:none;">Save Category</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// SPA interaction functions
function selectPickerEmoji(emoji, element) {
    document.getElementById('formIconInput').value = emoji;
    
    // Clear all outlines
    const btns = document.querySelectorAll('.emoji-picker-btn');
    btns.forEach(btn => {
        btn.style.borderColor = '#E2E8F0';
        btn.style.boxShadow = 'none';
        btn.style.background = '#FFF';
    });
    
    // Apply highlight to current
    element.style.borderColor = 'var(--primary)';
    element.style.boxShadow = '0 0 0 2px var(--primary-bg)';
    element.style.background = '#FFF0EC';
}

function scrollToEdit(cat) {
    // Scroll smoothly to bottom form
    const formSection = document.getElementById('category-form-section');
    formSection.scrollIntoView({ behavior: 'smooth' });
    
    // Transform bottom form into Edit state
    document.getElementById('form-title').innerText = 'Edit Category';
    document.getElementById('form-desc').innerText = 'Make changes to your existing classification.';
    document.getElementById('spaCatForm').action = "/admin/categories/" + cat.id;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('formSubmitBtn').innerText = 'Save Changes';
    
    // Populate inputs
    document.getElementById('formCatName').value = cat.name;
    document.getElementById('formCatDesc').value = cat.description || '';
    
    const emoji = cat.icon || '🍕';
    document.getElementById('formIconInput').value = emoji;
    
    // Highlight emoji in grid
    const pickerBtns = document.querySelectorAll('.emoji-picker-btn');
    pickerBtns.forEach(btn => {
        if(btn.innerText.trim() === emoji) {
            selectPickerEmoji(emoji, btn);
        }
    });
}

function discardForm() {
    // Reset to Create state
    document.getElementById('form-title').innerText = 'Create New Category';
    document.getElementById('form-desc').innerText = 'Fill in the details to add a new classification.';
    document.getElementById('spaCatForm').action = "{{ route('admin.categories.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('formSubmitBtn').innerText = 'Save Category';
    
    // Reset inputs
    document.getElementById('formCatName').value = '';
    document.getElementById('formCatDesc').value = '';
    document.getElementById('formIconInput').value = '🍕';
    
    // Highlight first emoji
    const pickerBtns = document.querySelectorAll('.emoji-picker-btn');
    if (pickerBtns.length > 0) {
        selectPickerEmoji('🍕', pickerBtns[0]);
    }
}
</script>
@endpush
@endsection
