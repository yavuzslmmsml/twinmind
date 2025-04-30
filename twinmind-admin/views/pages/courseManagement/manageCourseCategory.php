<?php
require_once '../../config/database.php';
require_once '../../config/functions.php';

// Get all categories with their hierarchy
$query = "SELECT c.*, p.name as parent_name 
          FROM course_categories c 
          LEFT JOIN course_categories p ON c.parent_id = p.id 
          ORDER BY c.parent_id, c.name";
$categories = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

// Function to build category tree
function buildCategoryTree($categories, $parentId = null) {
    $tree = [];
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parentId) {
            $children = buildCategoryTree($categories, $category['id']);
            if ($children) {
                $category['children'] = $children;
            }
            $tree[] = $category;
        }
    }
    return $tree;
}

$categoryTree = buildCategoryTree($categories);
?>

<div class="container mt-5 mb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold">Course Category Management</h2>
      <p class="text-muted mb-0">Create and organize categories by hierarchy</p>
    </div>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add Category</button>
  </div>

  <!-- Category Tree -->
  <div class="card mb-5">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Existing Categories</h5>
    </div>
    <div class="card-body">
      <ul class="list-group">
        <?php
        function renderCategoryTree($categories, $level = 0) {
            foreach ($categories as $category) {
                $margin = $level * 20;
                ?>
                <li class="list-group-item" style="margin-left: <?php echo $margin; ?>px">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                            <?php if ($category['parent_name']) { ?>
                                <small class="text-muted">(→ <?php echo htmlspecialchars($category['parent_name']); ?>)</small>
                            <?php } ?>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary" onclick="editCategory(<?php echo $category['id']; ?>)">Edit</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(<?php echo $category['id']; ?>)">Delete</button>
                        </div>
                    </div>
                    <?php if (isset($category['children'])) { ?>
                        <ul class="list-group mt-2">
                            <?php renderCategoryTree($category['children'], $level + 1); ?>
                        </ul>
                    <?php } ?>
                </li>
                <?php
            }
        }
        renderCategoryTree($categoryTree);
        ?>
      </ul>
    </div>
  </div>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="addCategoryForm" action="add_category_process.php" method="POST">
            <div class="mb-3">
              <label class="form-label">Category Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Parent Category</label>
              <select name="parent_id" class="form-select">
                <option value="">-- No Parent (Ana Kategori) --</option>
                <?php
                foreach ($categories as $category) {
                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="addCategoryForm" class="btn btn-primary">Add Category</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function editCategory(id) {
    // Implement edit functionality
    window.location.href = `edit_category.php?id=${id}`;
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        window.location.href = `delete_category.php?id=${id}`;
    }
}
</script>
