@extends('layouts.admin')
@section('title', 'User Management')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:26px">
    <div>
        <h1 style="font-size:28px;font-weight:700;color:#111">Users</h1>
        <p style="color:var(--text-m);margin-top:4px">Manage system users, chefs, and their permissions.</p>
    </div>
    <div style="display:flex;gap:10px">
        <form method="GET" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="form-control" style="width:200px;padding:8px 12px;">
            <select name="role" class="form-control" style="width:130px;padding:8px 12px;">
                <option value="">All Roles</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="chef" {{ request('role') == 'chef' ? 'selected' : '' }}>Chef</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button class="btn btn-white btn-sm" type="submit">Search</button>
        </form>
    </div>
</div>

<div class="white-card">
    <table>
        <thead>
            <tr>
                <th style="width:280px;">Profile</th>
                <th style="width:140px;">Role</th>
                <th style="width:160px;">VIP Status</th>
                <th style="width:160px;">Joined Date</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="td-img">
                        <img src="{{ $user->avatar_url }}" alt="">
                        <div>
                            <h4>{{ $user->name }}</h4>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge {{ $user->role == 'admin' ? 'badge-pub' : ($user->role == 'chef' ? 'badge-pending' : 'badge-active') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    @if($user->is_vip)
                        <span class="badge" style="background:#FFF9C4;color:#7c5b00;"><i class="fas fa-crown"></i> VIP Member</span>
                    @else
                        <span class="badge" style="background:#eee;color:#777;">Regular</span>
                    @endif
                </td>
                <td style="color:var(--text-m);">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="td-acts">
                        <button class="tact tact-edit" onclick="openEditUserModal({{ $user->toJson() }})"><i class="fas fa-pencil"></i></button>
                        @if($user->id !== Auth::id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="tact tact-del"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-m)">User tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $users->links() }}
    </div>
</div>

<!-- Edit User Modal -->
<div id="userModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center;">
    <div class="white-card" style="width:100%;max-width:400px;margin:20px;position:relative;">
        <h3 style="margin-bottom:20px;">Edit User Status & Role</h3>
        <form id="userForm" method="POST" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" id="userRole" class="form-control">
                    <option value="user">User</option>
                    <option value="chef">Chef</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:10px;padding:10px 0;">
                <input type="checkbox" name="is_vip" id="userVip" value="1" style="width:18px;height:18px;">
                <label for="userVip" style="font-weight:600;margin:0;"><i class="fas fa-crown" style="color:#FFD700"></i> VIP Member</label>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                <button type="button" class="btn btn-white btn-sm" onclick="closeUserModal()">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditUserModal(user) {
    document.getElementById('userForm').action = "/admin/users/" + user.id;
    document.getElementById('userRole').value = user.role;
    document.getElementById('userVip').checked = user.is_vip ? true : false;
    document.getElementById('userModal').style.display = 'flex';
}
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}
</script>
@endpush
@endsection
