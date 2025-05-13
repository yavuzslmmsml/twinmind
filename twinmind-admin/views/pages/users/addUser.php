<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::FAQ card-->
        <div class="card">
  <div class="card-body">
    <h3 class="mb-4">Add New User</h3>
    <form  method="POST">
      
      <!-- Full Name -->
      <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="e.g. John Doe" required>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="e.g. user@example.com" required>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
      </div>

      <!-- Role -->
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
          <option value="student">Student</option>
          <option value="instructor">Instructor</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <!-- Status -->
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="active">Active</option>
          <option value="locked">Locked</option>
        </select>
      </div>

      <!-- Submit Button -->
      <button type="button" class="btn btn-primary">Create User</button>
    </form>
  </div>
</div>

        <!--end::FAQ card-->
    </div>
    <!--end::Content container-->
</div>