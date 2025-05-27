<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kategori Ekle</h4>
                    <a href="/category-management" class="btn btn-secondary">Geri Dön</a>
                </div>
                <div class="card-body">
                    <form action="/category-management/save" method="POST">
                        <div class="form-group">
                            <label for="name">Kategori Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Ana Kategori</label>
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">Ana Kategori</option>
                                <?php foreach ($mainCategories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
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

                        <button type="submit" class="btn btn-primary">Kaydet</button>
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

        // Function to load subcategories
        function loadSubcategories(parentId, targetSelect) {
            fetch('/category-management/subcategories?parent_id=' + parentId)
                .then(response => response.json())
                .then(data => {
                    targetSelect.innerHTML = '<option value="">Seçiniz</option>';

                    data.forEach(subCategory => {
                        const option = document.createElement('option');
                        option.value = subCategory.id;
                        option.textContent = subCategory.name;
                        targetSelect.appendChild(option);
                    });
                });
        }

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

            // Get form data
            const formData = new FormData(this);

            // Determine the final parent_id based on selections
            if (subParentSelect.value) {
                formData.set('parent_id', subParentSelect.value);
            } else if (parentSelect.value) {
                formData.set('parent_id', parentSelect.value);
            } else {
                formData.set('parent_id', '');
            }

            // Submit the form using fetch
            fetch('/category-management/save', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.text();
                    }
                })
                .then(data => {
                    if (data) {
                        console.error('Error:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>