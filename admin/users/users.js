/**
 * users.js — DT Brand's & Jai Hanuman Tex Admin Security & Roles Client Controller
 * Section 34: Admin Users / Roles / Permissions
 */

function dtOpenModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function dtCloseModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function dtShowToast(msg, type) {
    type = type || 'success';
    var toast = document.createElement('div');
    toast.className = 'dt-sec-toast';
    toast.style.cssText = 'position:fixed; bottom:24px; right:24px; z-index:9999999; padding:12px 20px; border-radius:8px; font-weight:700; font-size:13px; box-shadow:0 10px 25px rgba(0,0,0,0.15); display:flex; align-items:center; gap:8px; animation:fadeIn 0.3s ease;';
    if (type === 'success') {
        toast.style.background = '#15803D';
        toast.style.color = '#FFFFFF';
    } else if (type === 'error') {
        toast.style.background = '#DC2626';
        toast.style.color = '#FFFFFF';
    } else {
        toast.style.background = '#1E293B';
        toast.style.color = '#FFFFFF';
    }
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.4s ease';
        setTimeout(function() { toast.remove(); }, 400);
    }, 3200);
}

// ── USER MANAGEMENT ──
function dtSubmitCreateUser(event) {
    event.preventDefault();
    var form = event.target;
    var data = new FormData(form);
    data.append('action', 'create_user');

    var btn = form.querySelector('button[type="submit"]');
    var originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Creating...';

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        btn.disabled = false;
        btn.textContent = originalText;
        if (res.success) {
            dtShowToast(res.message, 'success');
            dtCloseModal('modalCreateUser');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to create user', 'error');
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        btn.textContent = originalText;
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtOpenEditUser(id, name, email, phone, role) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone || '';
    document.getElementById('edit_role').value = role;
    dtOpenModal('modalEditUser');
}

function dtSubmitEditUser(event) {
    event.preventDefault();
    var form = event.target;
    var data = new FormData(form);
    data.append('action', 'update_user');

    var btn = form.querySelector('button[type="submit"]');
    var originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Saving...';

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        btn.disabled = false;
        btn.textContent = originalText;
        if (res.success) {
            dtShowToast(res.message, 'success');
            dtCloseModal('modalEditUser');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to update user', 'error');
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        btn.textContent = originalText;
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtToggleUserStatus(id) {
    if (!confirm('Are you sure you want to toggle the active status of this account?')) return;
    var data = new FormData();
    data.append('action', 'toggle_user_status');
    data.append('id', id);

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res.success) {
            dtShowToast(res.message, 'success');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to toggle status', 'error');
        }
    })
    .catch(function(err) {
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtOpenResetPassword(id, name) {
    document.getElementById('reset_user_id').value = id;
    document.getElementById('reset_user_name_label').textContent = name;
    document.getElementById('reset_password').value = '';
    dtOpenModal('modalResetPassword');
}

function dtSubmitResetPassword(event) {
    event.preventDefault();
    var form = event.target;
    var data = new FormData(form);
    data.append('action', 'reset_password');

    var btn = form.querySelector('button[type="submit"]');
    var originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Resetting...';

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        btn.disabled = false;
        btn.textContent = originalText;
        if (res.success) {
            dtShowToast(res.message, 'success');
            dtCloseModal('modalResetPassword');
        } else {
            dtShowToast(res.message || 'Failed to reset password', 'error');
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        btn.textContent = originalText;
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtDeleteUser(id, name) {
    if (!confirm('CAUTION: Are you sure you want to permanently remove administrator account "' + name + '"?')) return;
    var data = new FormData();
    data.append('action', 'delete_user');
    data.append('id', id);

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res.success) {
            dtShowToast(res.message, 'success');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to delete account', 'error');
        }
    })
    .catch(function(err) {
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

// ── ACTIVE SESSIONS ──
function dtRevokeSession(sessionId) {
    if (!confirm('Are you sure you want to terminate this administrative session? The user will be immediately logged out.')) return;
    var data = new FormData();
    data.append('action', 'revoke_session');
    data.append('session_id', sessionId);

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res.success) {
            dtShowToast(res.message, 'success');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to revoke session', 'error');
        }
    })
    .catch(function(err) {
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtRevokeAllOtherSessions() {
    if (!confirm('Are you sure you want to terminate all other active admin sessions except your current one?')) return;
    var data = new FormData();
    data.append('action', 'revoke_all_other_sessions');

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res.success) {
            dtShowToast(res.message, 'success');
            setTimeout(function() { location.reload(); }, 600);
        } else {
            dtShowToast(res.message || 'Failed to revoke sessions', 'error');
        }
    })
    .catch(function(err) {
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

// ── PERMISSIONS MATRIX ──
function dtSavePermissionsMatrix(roleSlug) {
    var checkboxes = document.querySelectorAll('.dt-perm-checkbox:checked');
    var matrix = {};
    checkboxes.forEach(function(cb) {
        var mod = cb.getAttribute('data-module');
        var act = cb.getAttribute('data-action');
        if (!matrix[mod]) matrix[mod] = [];
        matrix[mod].push(act);
    });

    var data = new FormData();
    data.append('action', 'save_permissions');
    data.append('role', roleSlug);
    data.append('permissions', JSON.stringify(matrix));

    var btn = document.getElementById('btnSavePerms');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Saving Matrix...';
    }

    fetch('/api/admin_security.php', {
        method: 'POST',
        body: data
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Save Permission Matrix';
        }
        if (res.success) {
            dtShowToast(res.message, 'success');
        } else {
            dtShowToast(res.message || 'Failed to save permissions', 'error');
        }
    })
    .catch(function(err) {
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Save Permission Matrix';
        }
        dtShowToast('Network error: ' + err.message, 'error');
    });
}

function dtToggleAllPermissions(check) {
    document.querySelectorAll('.dt-perm-checkbox:not(:disabled)').forEach(function(cb) {
        cb.checked = check;
    });
}
