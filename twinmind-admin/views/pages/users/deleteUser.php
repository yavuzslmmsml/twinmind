<!-- Actions Dropdown (Her kullanıcı satırında olacak) -->
<div class="dropdown">
  <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Actions
  </button>
  <ul class="dropdown-menu dropdown-menu-end shadow-sm">
    <!-- Edit User -->
    <li>
      <a class="dropdown-item text-primary" href="edit_user.php?id=USER_ID">
        <i class="bi bi-pencil me-2"></i>Edit User
      </a>
    </li>

    <!-- Ban User -->
    <li>
      <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#banUserModal" data-user-id="USER_ID" data-user-name="John Doe">
        <i class="bi bi-shield-exclamation me-2"></i>Ban User
      </button>
    </li>

    <!-- Delete User -->
    <li>
      <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="USER_ID" data-user-name="John Doe">
        <i class="bi bi-trash me-2"></i>Delete User
      </button>
    </li>
  </ul>
</div>
