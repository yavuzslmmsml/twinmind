<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List All Categories</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f8fa;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .badge {
      font-size: 0.9rem;
    }
    .btn-sm i {
      font-size: 1rem;
    }
    .table td {
      vertical-align: middle;
    }
    .table td.id-col,
    .table td.actions-col {
      padding-left: 3.5rem;
      padding-right: 3.5rem;
    }
    .filter-row select {
      min-width: 150px;
    }
    .modal-header {
      background-color: #f1f3f9;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <!-- Change Logo Section -->
    <div class="card mb-5">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Change Site Logo</h2>
      </div>
      <div class="card-body">
        <form id="changeLogoForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="logoUpload" class="form-label">Upload New Logo</label>
            <input class="form-control" type="file" id="logoUpload" accept="image/*">
          </div>
          <div class="mb-3">
            <label class="form-label">Preview:</label><br>
            <img id="logoPreview" src="#" alt="Logo Preview" style="max-height: 80px; display: none;">
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-success">Save Logo</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Existing Category Management Section -->
   
  </div>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addCategoryForm">
            <div class="mb-3">
              <label for="categoryPath" class="form-label">Category Path</label>
              <input type="text" class="form-control" id="categoryPath" placeholder="e.g. Software / Mobile / Flutter">
            </div>
            <div class="mb-3">
              <label for="categoryStatus" class="form-label">Status</label>
              <select class="form-select" id="categoryStatus">
                <option value="Active">Active</option>
                <option value="Passive">Passive</option>
              </select>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Category Modal -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editCategoryForm">
            <div class="mb-3">
              <label for="editCategoryPath" class="form-label">Category Path</label>
              <input type="text" class="form-control" id="editCategoryPath">
            </div>
            <div class="mb-3">
              <label for="editCategoryStatus" class="form-label">Status</label>
              <select class="form-select" id="editCategoryStatus">
                <option value="Active">Active</option>
                <option value="Passive">Passive</option>
              </select>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function applyFilter() {
      const category = document.getElementById('filterCategory').value.toLowerCase();
      const status = document.getElementById('filterStatus').value.toLowerCase();
      const rows = document.querySelectorAll('#categoryTableBody tr');

      rows.forEach(row => {
        const categoryText = row.children[1].textContent.toLowerCase();
        const statusText = row.children[2].textContent.toLowerCase();

        const matchCategory = !category || categoryText.includes(category);
        const matchStatus = !status || statusText.includes(status);

        row.style.display = matchCategory && matchStatus ? '' : 'none';
      });
    }

    document.getElementById('logoUpload').addEventListener('change', function (event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const logoPreview = document.getElementById('logoPreview');
          logoPreview.src = e.target.result;
          logoPreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>

    </div>
    <!--end::Content container-->
</div>



