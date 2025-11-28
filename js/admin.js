// Sidebar menu management
const menuItems = document.querySelectorAll('.menu li');

menuItems.forEach((li) =>
  li.addEventListener('click', (e) => {
    e.preventDefault();
    menuItems.forEach((item) => item.classList.remove('active'));
    const targetLi = e.currentTarget;
    targetLi.classList.add('active');
    const target = targetLi.getAttribute('data-target');
    document.querySelectorAll('.page').forEach((page) => {
      const pageId = page.getAttribute('id');
      if (pageId === target) {
        page.classList.remove('d-none');
      } else {
        page.classList.add('d-none');
      }
    });
  })
);

// Toggle sidebar
document.querySelector('aside .asideToggle')?.addEventListener('click', (e) => {
  const aside = document.querySelector('aside');
  aside.classList.toggle('translateX-aside');
  e.target.classList.toggle('rotateToggle');
});

// Load users from backend
let users = [];

fetch("php/get_users.php")
  .then(res => res.json())
  .then(data => {
    users = data;
    console.log("✅ Users loaded:", users);
    loadUsers(); 
  })
  .catch(err => console.error("❌ Error loading users:", err));

// Load users into table
function loadUsers() {
  const tbody = document.getElementById('usersTableBody');
  tbody.innerHTML = '';
  
  users.forEach(user => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.department}</td>
      <td>
        <span class="role-badge ${user.role}">${user.role === 'admin' ? 'Admin' : 'User'}</span>
      </td>
      <td>
        <div class="action-buttons">
          <button class="btn-sm btn-edit" onclick="editUser(${user.id})">
            <i class="bi bi-pencil"></i> Edit
          </button>
          <button class="btn-sm btn-delete" onclick="deleteUser(${user.id})">
            <i class="bi bi-trash"></i> Delete
          </button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Edit user (open modal)
function editUser(id) {
  // Normalize id param to number if possible
  const searchId = isNaN(Number(id)) ? id : Number(id);

  const user = users.find(u => {
    // try numeric compare first, fallback to string compare
    if (!isNaN(Number(u.id)) && !isNaN(Number(searchId))) {
      return Number(u.id) === Number(searchId);
    }
    return String(u.id) === String(searchId);
  });

  if (!user) {
    console.error("editUser: user not found for id =", id, "users:", users);
    return;
  }

  document.getElementById('editUserId').value = user.id;
  document.getElementById('editUserName').value = user.name;
  document.getElementById('editUserEmail').value = user.email;
  document.getElementById('editUserDept').value = user.department;
  document.getElementById('editUserRole').value = user.role;

  const modalEl = document.getElementById('editUserModal');
  if (!modalEl) {
    console.error("editUser: modal element with id 'editUserModal' not found.");
    return;
  }
  const modal = new bootstrap.Modal(modalEl);
  modal.show();
}


// Save updated user → PHP (update)
// function saveUser() {
//   const id = parseInt(document.getElementById('editUserId').value);
//   const name = document.getElementById('editUserName').value;
//   const email = document.getElementById('editUserEmail').value;
//   const department = document.getElementById('editUserDept').value;
//   const role = document.getElementById('editUserRole').value;

//   fetch('php/edit_delete_user.php?action=update', {
//     method: 'POST',
//     headers: { "Content-Type": "application/json" },
//     body: JSON.stringify({ id, name, email, department, role })
//   })
//     .then(res => res.json())
//     .then(response => {
//       if (response.success) {
//         const index = users.findIndex(u => u.id === id);
//         if (index !== -1) {
//           users[index] = { id, name, email, department, role };
//           loadUsers();
//         }

//         const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
//         modal.hide();

//         alert("User updated successfully");
//       } else {
//         alert("Error updating user");
//       }
//     })
//     .catch(err => console.error("Update error:", err));
// }
async function saveUser() {
  try {
    // عناصر الصفحة
    const idEl = document.getElementById('editUserId');
    const nameEl = document.getElementById('editUserName');
    const emailEl = document.getElementById('editUserEmail');
    const deptEl = document.getElementById('editUserDept');
    const roleEl = document.getElementById('editUserRole');
    const saveBtn = document.getElementById('saveUserBtn'); // اختياري: لو زرّ الحفظ له id

    if (!idEl || !nameEl || !emailEl || !deptEl || !roleEl) {
      console.error('saveUser: Required input elements not found.');
      return;
    }

    // منع ضغطات متكررة
    if (saveBtn) {
      saveBtn.disabled = true;
      saveBtn.dataset.origText = saveBtn.innerHTML;
      saveBtn.innerHTML = 'Saving...';
    }

    // قراءة القيم
    const id = Number(idEl.value);
    const name = nameEl.value.trim();
    const email = emailEl.value.trim();
    const department = deptEl.value.trim();
    const role = roleEl.value.trim();

    // validation بسيط
    if (!id || !name || !email) {
      alert('Please fill name, email and make sure a user is selected.');
      if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = saveBtn.dataset.origText || 'Save'; }
      return;
    }

    // إرسال للباك إند (نستخدم JSON body كما اتفقنا)
    const res = await fetch('php/edit_delete_user.php?action=update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, name, email, department, role })
    });

    const json = await res.json();
    console.log('update response:', json);

    // دعم أشكال استجابة مختلفة (success أو status)
    const ok = (json.success === true) || (json.status && (json.status === 'success' || json.status === 'ok'));

    if (ok) {
      // حدّث القائمة محليًا
      const idx = users.findIndex(u => Number(u.id) === Number(id));
      if (idx !== -1) {
        users[idx] = { id, name, email, department, role };
        loadUsers();
      }

      // اغلاق المودال بأمان
      const modalEl = document.getElementById('editUserModal');
      let modalInstance = bootstrap.Modal.getInstance(modalEl);
      if (!modalInstance) modalInstance = new bootstrap.Modal(modalEl);
      modalInstance.hide();

      alert('User updated successfully');
    } else {
      const msg = json.message || json.msg || JSON.stringify(json);
      alert('Update failed: ' + msg);
    }

  } catch (err) {
    console.error('saveUser error:', err);
    alert('An error occurred while updating the user. Check console/network.');
  } finally {
    // استعادة حالة الزر
    const saveBtn = document.getElementById('saveUserBtn');
    if (saveBtn) {
      saveBtn.disabled = false;
      saveBtn.innerHTML = saveBtn.dataset.origText || 'Save';
    }
  }
}


// Delete user → PHP (delete)
function deleteUser(id) {
  if (!confirm("Are you sure you want to delete this user?")) return;

  fetch(`php/edit_delete_user.php?action=delete&id=${id}`)
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        users = users.filter(u => u.id !== id);
        loadUsers();
        alert("User deleted successfully");
      } else {
        alert("Error deleting user");
      }
    })
    .catch(err => console.error("Delete error:", err));
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
  loadUsers();
});
