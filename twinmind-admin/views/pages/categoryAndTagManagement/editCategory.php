<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kategori Düzenle</h4>
                    <a href="/category-management" class="btn btn-secondary">Geri Dön</a>
                </div>
                <div class="card-body">
                    <form action="/category-management/update" method="POST">
                        <input type="hidden" name="id" value="<?= $category['id'] ?>">

                        <div class="form-group">
                            <label for="name">Kategori Adı</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= $category['name'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3"><?= $category['description'] ?? '' ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Ana Kategori</label>
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">Ana Kategori</option>
                                <?php foreach ($mainCategories as $mainCategory): ?>
                                <?php if ($mainCategory['id'] != $category['id']): ?>
                                <option value="<?= $mainCategory['id'] ?>"
                                    <?= ($category['parent_id'] == $mainCategory['id']) ? 'selected' : '' ?>>
                                    <?= $mainCategory['name'] ?>
                                </option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="subcategory_container" style="display:none">
                            <label for="sub_parent_id">Alt Kategori</label>
                            <select class="form-control" id="sub_parent_id" name="sub_parent_id">
                                <option value="">Seçiniz</option>
                            </select>
                        </div>

                        <div class="form-group" id="subsubcategory_container" style="display:none">
                            <label for="subsub_parent_id">Alt Alt Kategori</label>
                            <select class="form-control" id="subsub_parent_id" name="subsub_parent_id">
                                <option value="">Seçiniz</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const parentSelect = document.getElementById('parent_id');
    const subParentContainer = document.getElementById('subcategory_container');
    const subParentSelect = document.getElementById('sub_parent_id');
    const subSubParentContainer = document.getElementById('subsubcategory_container');
    const subSubParentSelect = document.getElementById('subsub_parent_id');
    const currentCategoryId = <?= $category['id'] ?>;
    const currentParentId = <?= $category['parent_id'] ? $category['parent_id'] : 'null' ?>;

    // Function to load subcategories
    function loadSubcategories(parentId, targetSelect) {
        fetch('/category-management/subcategories?parent_id=' + parentId)
            .then(response => response.json())
            .then(data => {
                targetSelect.innerHTML = '<option value="">Seçiniz</option>';

                data.forEach(subCategory => {
                    if (subCategory.id != currentCategoryId) {
                        const option = document.createElement('option');
                        option.value = subCategory.id;
                        option.textContent = subCategory.name;
                        targetSelect.appendChild(option);
                    }
                });
            });
    }

    // Function to get category path
    function getCategoryPath(categoryId) {
        return fetch('/category-management/get-category-path?id=' + categoryId)
            .then(response => response.json());
    }

    // Function to initialize category hierarchy
    async function initializeCategoryHierarchy() {
        if (!currentParentId) return;

        try {
            const path = await getCategoryPath(currentCategoryId);
            if (path.length > 0) {
                // Set main category
                parentSelect.value = path[0].id;

                // Load and set subcategory if exists
                if (path.length > 1) {
                    subParentContainer.style.display = 'block';
                    await loadSubcategories(path[0].id, subParentSelect);
                    subParentSelect.value = path[1].id;
                }
            }
        } catch (error) {
            console.error('Error initializing category hierarchy:', error);
        }
    }

    // Initialize category hierarchy on page load
    initializeCategoryHierarchy();

    // Handle main category change
    parentSelect.addEventListener('change', function() {
        const selectedParentId = this.value;

        // Reset subcategory container
        subParentContainer.style.display = 'none';
        subParentSelect.innerHTML = '<option value="">Seçiniz</option>';

        if (selectedParentId) {
            subParentContainer.style.display = 'block';
            loadSubcategories(selectedParentId, subParentSelect);
        }
    });

    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Determine the final parent_id based on selections
        let finalParentId = '';
        if (subParentSelect.value) {
            finalParentId = subParentSelect.value;
        } else if (parentSelect.value) {
            finalParentId = parentSelect.value;
        }

        // Update the parent_id field
        const parentIdInput = document.createElement('input');
        parentIdInput.type = 'hidden';
        parentIdInput.name = 'parent_id';
        parentIdInput.value = finalParentId;
        this.appendChild(parentIdInput);

        // Submit the form
        this.submit();
    });
});
</script>