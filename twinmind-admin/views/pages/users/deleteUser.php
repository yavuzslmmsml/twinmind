<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">User Management</h2>

    <!-- Arama Kutusu -->
    <div class="mb-3">
        <input type="text" id="userSearch" class="form-control" placeholder="Search by name, email or role...">
    </div>

    <!-- Kullanıcı Tablosu -->
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="userTable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ömer Eren Acar</td>
                    <td>omer@example.com</td>
                    <td>Instructor</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>2025-04-10</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editUserModal"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#banUserModal"><i class="bi bi-shield-exclamation"></i></button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" value="Ömer Eren Acar">
          </div>
          <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" value="omer@example.com">
          </div>
          <div class="mb-3">
              <label class="form-label">Role</label>
              <select class="form-select">
                  <option>Student</option>
                  <option selected>Instructor</option>
                  <option>Admin</option>
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-select">
                  <option selected>Active</option>
                  <option>Banned</option>
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" type="submit">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Ban Modal -->
<div class="modal fade" id="banUserModal" tabindex="-1" aria-labelledby="banUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Ban User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to <strong>ban</strong> user <strong>Ömer Eren Acar</strong>?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-warning" type="submit">Ban User</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>This action cannot be undone. Are you sure you want to <strong>permanently delete</strong> user <strong>Ömer Eren Acar</strong>?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" type="submit">Delete User</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS + Arama Scripti -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Arama kutusu filtreleme
    document.getElementById("userSearch").addEventListener("keyup", function () {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });
</script>

</body>
</html>

    </div>
    <!--end::Content container-->
</div>