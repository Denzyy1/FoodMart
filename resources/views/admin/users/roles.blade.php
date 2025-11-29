<x-admin-layout>
    <x-slot name="content">
        <section class="py-5">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Role Management</h2>
                        <p class="text-muted mb-0">Assign roles to users and admins</p>
                    </div>
                    <div>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                            <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8z"/>
                                <path d="M11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                            </svg>
                            Manage Users
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
                    </div>
                </div>

                {{-- Role Legend --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Role Descriptions</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <span class="badge bg-info me-2">User</span>
                                <small class="text-muted">Can browse products and make purchases</small>
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-warning text-dark me-2">Admin</span>
                                <small class="text-muted">Can manage products and categories</small>
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-danger me-2">Super Admin</span>
                                <small class="text-muted">Full access including user management</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bulk Actions --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Bulk Role Assignment</h6>
                        <form id="bulkRoleForm" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Select Role</label>
                                <select id="bulkRole" class="form-select">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" id="bulkUpdateBtn" disabled>
                                    <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg>
                                    Apply to Selected (<span id="selectedCount">0</span>)
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Alert Container --}}
                <div id="alertContainer"></div>

                {{-- Users Table --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Current Role</th>
                                        <th>Change Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr data-user-id="{{ $user->id }}">
                                            <td>
                                                @if($user->id !== auth()->id())
                                                <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                                                @else
                                                <span class="text-muted" title="You cannot change your own role">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-{{ $user->hasRole('superadmin') ? 'danger' : ($user->hasRole('admin') ? 'warning' : 'info') }} text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->id === auth()->id())
                                                        <span class="badge bg-secondary ms-1">You</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="current-role-badge badge {{ $user->hasRole('superadmin') ? 'bg-danger' : ($user->hasRole('admin') ? 'bg-warning text-dark' : 'bg-info') }}">
                                                    {{ ucfirst($user->roles->first()->name ?? 'user') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($user->id !== auth()->id())
                                                <select class="form-select form-select-sm role-select" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" style="width: 140px;">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                            {{ ucfirst($role->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <span class="text-muted">Cannot change</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- JavaScript for Role Management --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Show alert message
            function showAlert(message, type = 'success') {
                const alertContainer = document.getElementById('alertContainer');
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show`;
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                alertContainer.prepend(alert);
                setTimeout(() => alert.remove(), 5000);
            }

            // Update role badge
            function updateRoleBadge(row, role) {
                const badge = row.querySelector('.current-role-badge');
                badge.textContent = role.charAt(0).toUpperCase() + role.slice(1);
                badge.className = 'current-role-badge badge ' + 
                    (role === 'superadmin' ? 'bg-danger' : (role === 'admin' ? 'bg-warning text-dark' : 'bg-info'));
                
                const avatar = row.querySelector('.avatar');
                avatar.className = 'avatar text-white rounded-circle d-flex align-items-center justify-content-center me-2 bg-' +
                    (role === 'superadmin' ? 'danger' : (role === 'admin' ? 'warning' : 'info'));
            }

            // Single role change
            document.querySelectorAll('.role-select').forEach(select => {
                select.addEventListener('change', async function() {
                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;
                    const newRole = this.value;
                    const row = this.closest('tr');

                    if (!confirm(`Change ${userName}'s role to ${newRole}?`)) {
                        // Reset to previous value
                        const currentBadge = row.querySelector('.current-role-badge');
                        this.value = currentBadge.textContent.toLowerCase();
                        return;
                    }

                    try {
                        const response = await fetch(`/admin/users/${userId}/role`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ role: newRole })
                        });

                        const data = await response.json();

                        if (data.success) {
                            updateRoleBadge(row, newRole);
                            showAlert(data.message, 'success');
                        } else {
                            showAlert(data.message, 'danger');
                            // Reset select
                            const currentBadge = row.querySelector('.current-role-badge');
                            this.value = currentBadge.textContent.toLowerCase();
                        }
                    } catch (error) {
                        showAlert('Error updating role. Please try again.', 'danger');
                    }
                });
            });

            // Select all checkbox
            const selectAll = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
            const selectedCount = document.getElementById('selectedCount');

            function updateSelectedCount() {
                const checked = document.querySelectorAll('.user-checkbox:checked').length;
                selectedCount.textContent = checked;
                bulkUpdateBtn.disabled = checked === 0;
            }

            selectAll.addEventListener('change', function() {
                userCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            });

            userCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectedCount);
            });

            // Bulk role update
            document.getElementById('bulkRoleForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
                const newRole = document.getElementById('bulkRole').value;

                if (selectedUsers.length === 0) {
                    showAlert('Please select at least one user.', 'warning');
                    return;
                }

                if (!confirm(`Change ${selectedUsers.length} user(s) to ${newRole}?`)) {
                    return;
                }

                try {
                    const response = await fetch('/admin/users/bulk-roles', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            users: selectedUsers,
                            role: newRole
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showAlert(data.message, 'success');
                        // Update UI for each selected user
                        selectedUsers.forEach(userId => {
                            const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                            if (row) {
                                updateRoleBadge(row, newRole);
                                const select = row.querySelector('.role-select');
                                if (select) select.value = newRole;
                            }
                        });
                        // Uncheck all
                        selectAll.checked = false;
                        userCheckboxes.forEach(cb => cb.checked = false);
                        updateSelectedCount();
                    } else {
                        showAlert(data.message, 'danger');
                    }
                } catch (error) {
                    showAlert('Error updating roles. Please try again.', 'danger');
                }
            });
        });
        </script>
    </x-slot>
</x-admin-layout>