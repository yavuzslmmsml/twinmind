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

        // Ana kategori değiştiğinde alt kategorileri getir
        parentSelect.addEventListener('change', function() {
            const parentId = this.value;

            // Alt alt kategori panelini kapat
            subSubParentContainer.style.display = 'none';
            subSubParentSelect.innerHTML = '<option value="">Seçiniz</option>';

            if (parentId === '') {
                subParentContainer.style.display = 'none';
                return;
            }

            // Ana kategori seçildiğinde alt kategorileri getir
            fetch('/category-management/subcategories?parent_id=' + parentId)
                .then(response => response.json())
                .then(data => {
                    // Alt kategori seçim listesini temizle ve yeniden doldur
                    subParentSelect.innerHTML = '<option value="">Seçiniz</option>';

                    if (data.length > 0) {
                        data.forEach(subCategory => {
                            const option = document.createElement('option');
                            option.value = subCategory.id;
                            option.textContent = subCategory.name;
                            subParentSelect.appendChild(option);
                        });

                        subParentContainer.style.display = 'block';
                    } else {
                        subParentContainer.style.display = 'none';
                    }
                });
        });

        // Alt kategori değiştiğinde alt alt kategorileri getir
        subParentSelect.addEventListener('change', function() {
            const subParentId = this.value;

            if (subParentId === '') {
                subSubParentContainer.style.display = 'none';
                return;
            }

            // Alt kategori seçildiğinde alt alt kategorileri getir
            fetch('/category-management/subcategories?parent_id=' + subParentId)
                .then(response => response.json())
                .then(data => {
                    // Alt alt kategori seçim listesini temizle ve yeniden doldur
                    subSubParentSelect.innerHTML = '<option value="">Seçiniz</option>';

                    if (data.length > 0) {
                        data.forEach(subSubCategory => {
                            const option = document.createElement('option');
                            option.value = subSubCategory.id;
                            option.textContent = subSubCategory.name;
                            subSubParentSelect.appendChild(option);
                        });

                        subSubParentContainer.style.display = 'block';
                    } else {
                        subSubParentContainer.style.display = 'none';
                    }
                });
        });

        // Form gönderilmeden önce seçilen kategoriyi parent_id'ye ata
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Eğer alt alt kategori seçildiyse
            if (subSubParentSelect.value !== '') {
                parentSelect.value = subSubParentSelect.value;
            }
            // Eğer alt kategori seçildiyse ve alt alt kategori seçilmediyse
            else if (subParentSelect.value !== '') {
                parentSelect.value = subParentSelect.value;
            }

            this.submit();
        });
    });
</script>