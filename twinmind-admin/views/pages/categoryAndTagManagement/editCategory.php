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
                            <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $category['description'] ?? '' ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Ana Kategori</label>
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">Ana Kategori</option>

                                <?php foreach ($mainCategories as $mainCategory): ?>
                                    <?php if ($mainCategory['id'] != $category['id']): ?>
                                        <option value="<?= $mainCategory['id'] ?>" <?= ($category['parent_id'] == $mainCategory['id']) ? 'selected' : '' ?>>
                                            <?= $mainCategory['name'] ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="subcategory_container" style="display:<?= $category['parent_id'] ? 'block' : 'none' ?>">
                            <label for="sub_parent_id">Alt Kategori</label>
                            <select class="form-control" id="sub_parent_id" name="sub_parent_id">
                                <option value="">Seçiniz</option>
                                <!-- Alt kategoriler JavaScript ile yüklenecek -->
                            </select>
                        </div>

                        <div class="form-group" id="subsubcategory_container" style="display:none">
                            <label for="subsub_parent_id">Alt Alt Kategori</label>
                            <select class="form-control" id="subsub_parent_id" name="subsub_parent_id">
                                <option value="">Seçiniz</option>
                                <!-- Alt alt kategoriler JavaScript ile yüklenecek -->
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
        const parentId = <?= $category['parent_id'] ? $category['parent_id'] : 'null' ?>;

        // Sayfa yüklendiğinde, eğer bir üst kategori seçili ise alt kategorileri getir
        if (parentId) {
            loadSubcategories(parentId);

            // Seçili alt kategorinin alt kategorilerini (alt alt kategorileri) kontrol et
            checkForSubSubCategories(parentId);
        }

        // Ana kategori değiştiğinde alt kategorileri getir
        parentSelect.addEventListener('change', function() {
            const selectedParentId = this.value;

            // Alt alt kategori panelini kapat
            subSubParentContainer.style.display = 'none';
            subSubParentSelect.innerHTML = '<option value="">Seçiniz</option>';

            if (selectedParentId === '') {
                subParentContainer.style.display = 'none';
                return;
            }

            loadSubcategories(selectedParentId);
        });

        // Alt kategori değiştiğinde alt alt kategorileri getir
        subParentSelect.addEventListener('change', function() {
            const selectedSubParentId = this.value;

            if (selectedSubParentId === '') {
                subSubParentContainer.style.display = 'none';
                return;
            }

            loadSubSubcategories(selectedSubParentId);
        });

        function loadSubcategories(parentId) {
            // Ana kategori seçildiğinde alt kategorileri getir
            fetch('/category-management/subcategories?parent_id=' + parentId)
                .then(response => response.json())
                .then(data => {
                    // Alt kategori seçim listesini temizle ve yeniden doldur
                    subParentSelect.innerHTML = '<option value="">Seçiniz</option>';

                    if (data.length > 0) {
                        data.forEach(subCategory => {
                            // Kendi ID'si ile aynı olanları listeleme (kendisini kendi altına ekleyemez)
                            if (subCategory.id != currentCategoryId) {
                                const option = document.createElement('option');
                                option.value = subCategory.id;
                                option.textContent = subCategory.name;
                                subParentSelect.appendChild(option);
                            }
                        });

                        subParentContainer.style.display = 'block';
                    } else {
                        subParentContainer.style.display = 'none';
                    }
                });
        }

        function loadSubSubcategories(subParentId) {
            // Alt kategori seçildiğinde alt alt kategorileri getir
            fetch('/category-management/subcategories?parent_id=' + subParentId)
                .then(response => response.json())
                .then(data => {
                    // Alt alt kategori seçim listesini temizle ve yeniden doldur
                    subSubParentSelect.innerHTML = '<option value="">Seçiniz</option>';

                    if (data.length > 0) {
                        data.forEach(subSubCategory => {
                            // Kendi ID'si ile aynı olanları listeleme (kendisini kendi altına ekleyemez)
                            if (subSubCategory.id != currentCategoryId) {
                                const option = document.createElement('option');
                                option.value = subSubCategory.id;
                                option.textContent = subSubCategory.name;
                                subSubParentSelect.appendChild(option);
                            }
                        });

                        subSubParentContainer.style.display = 'block';
                    } else {
                        subSubParentContainer.style.display = 'none';
                    }
                });
        }

        // Mevcut kategorinin alt alt kategori olup olmadığını kontrol et
        function checkForSubSubCategories(parentId) {
            fetch('/category-management/subcategories?parent_id=' + parentId)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Alt kategorinin ID'sini bul
                        let subCategoryId = null;

                        for (let i = 0; i < data.length; i++) {
                            if (data[i].id == currentCategoryId) {
                                // Bu kategori zaten bir alt kategori, işlem gerekmiyor
                                return;
                            }

                            // Alt kategorinin alt kategori listesini kontrol et
                            fetch('/category-management/subcategories?parent_id=' + data[i].id)
                                .then(subResponse => subResponse.json())
                                .then(subData => {
                                    if (subData.length > 0) {
                                        for (let j = 0; j < subData.length; j++) {
                                            if (subData[j].id == currentCategoryId) {
                                                // Bu bir alt alt kategori
                                                // Ana kategori ve alt kategori seçimlerini ayarla
                                                parentSelect.value = parentId;

                                                // Alt kategorileri yükle ve doğru alt kategoriyi seç
                                                loadSubcategories(parentId);

                                                // Biraz gecikme ile alt kategoriyi seç (yüklenmesini beklemek için)
                                                setTimeout(() => {
                                                    for (let option of subParentSelect.options) {
                                                        if (option.value == data[i].id) {
                                                            option.selected = true;
                                                            // Alt kategori değiştiğinde alt alt kategorileri yükle
                                                            subParentSelect.dispatchEvent(new Event('change'));
                                                            break;
                                                        }
                                                    }
                                                }, 500);

                                                return;
                                            }
                                        }
                                    }
                                });
                        }
                    }
                });
        }

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