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
      padding-left: 2.5rem;
      padding-right: 2.5rem;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card mb-4">
      <div class="card-body">
        <form id="filter-form" class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="mainCategory" class="col-form-label">Main Category:</label>
          </div>
          <div class="col-auto">
            <select class="form-select" id="mainCategory" name="mainCategory">
              <option value="">All</option>
              <option value="Software">Software</option>
              <option value="Music">Music</option>
              <option value="Sports">Sports</option>
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filter</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">All Categories</h2>
        <a href="#" class="btn btn-primary">+ Add New Category</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="id-col">ID</th>
                <th>Category Path</th>
                <th>Status</th>
                <th class="actions-col text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="id-col">1</td>
                <td>Software / Web Development / JavaScript</td>
                <td><span class="badge bg-success">Active</span></td>
                <td class="actions-col text-end">
                  <a href="#" class="btn btn-sm btn-light-primary me-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-light-danger"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td class="id-col">2</td>
                <td>Software / Mobile / Flutter</td>
                <td><span class="badge bg-secondary">Passive</span></td>
                <td class="actions-col text-end">
                  <a href="#" class="btn btn-sm btn-light-primary me-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-light-danger"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <!-- PHP foreach ile buraya döngü gelecek -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>