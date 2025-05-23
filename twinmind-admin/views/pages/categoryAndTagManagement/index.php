<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kategori Yönetimi</h4>
                    <a href="/category-management/add" class="btn btn-primary">Yeni Kategori Ekle</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori Adı</th>
                                    <th>Alt Kategoriler</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($mainCategories)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Henüz kategori eklenmemiş</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($mainCategories as $category): ?>
                                        <tr>
                                            <td><?= $category['id'] ?></td>
                                            <td><?= $category['name'] ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-info show-subcategories" data-id="<?= $category['id'] ?>">Alt Kategorileri Göster</button>
                                            </td>
                                            <td>
                                                <a href="/category-management/edit/<?= $category['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                                                <a href="/category-management/delete/<?= $category['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Alt kategorileri de silinecektir.')">Sil</a>
                                            </td>
                                        </tr>
                                        <tr class="subcategory-row" id="subcategory-<?= $category['id'] ?>" style="display:none">
                                            <td colspan="4">
                                                <div class="subcategory-container">
                                                    <div class="subcategory-loading">Yükleniyor...</div>
                                                    <div class="subcategory-content"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showButtons = document.querySelectorAll('.show-subcategories');

        showButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const subRow = document.getElementById('subcategory-' + categoryId);
                const subContent = subRow.querySelector('.subcategory-content');
                const loadingDiv = subRow.querySelector('.subcategory-loading');

                if (subRow.style.display === 'none') {
                    subRow.style.display = 'table-row';

                    // Veri yüklenmediyse yükle
                    if (subContent.innerHTML === '') {
                        loadingDiv.style.display = 'block';

                        fetch('/category-management/subcategories?parent_id=' + categoryId)
                            .then(response => response.json())
                            .then(data => {
                                loadingDiv.style.display = 'none';

                                if (data.length === 0) {
                                    subContent.innerHTML = '<div class="alert alert-info">Bu kategorinin alt kategorisi bulunmamaktadır.</div>';
                                    return;
                                }

                                let table = '<table class="table table-bordered table-sm">';
                                table += '<thead><tr><th>ID</th><th>Alt Kategori Adı</th><th>Alt Alt Kategoriler</th><th>İşlemler</th></tr></thead>';
                                table += '<tbody>';

                                data.forEach(subCategory => {
                                    table += `<tr>
                                <td>${subCategory.id}</td>
                                <td>${subCategory.name}</td>
                                <td>
                                    <button class="btn btn-sm btn-info show-subsubcategories" data-id="${subCategory.id}">Alt Kategorileri Göster</button>
                                </td>
                                <td>
                                    <a href="/category-management/edit/${subCategory.id}" class="btn btn-sm btn-warning">Düzenle</a>
                                    <a href="/category-management/delete/${subCategory.id}" class="btn btn-sm btn-danger" onclick="return confirm('Bu alt kategoriyi silmek istediğinize emin misiniz?')">Sil</a>
                                </td>
                            </tr>
                            <tr class="subsubcategory-row" id="subsubcategory-${subCategory.id}" style="display:none">
                                <td colspan="4">
                                    <div class="subsubcategory-container">
                                        <div class="subsubcategory-loading">Yükleniyor...</div>
                                        <div class="subsubcategory-content"></div>
                                    </div>
                                </td>
                            </tr>`;
                                });

                                table += '</tbody></table>';
                                subContent.innerHTML = table;

                                // Alt alt kategoriler için event listener'lar ekle
                                const subShowButtons = subContent.querySelectorAll('.show-subsubcategories');
                                subShowButtons.forEach(subButton => {
                                    subButton.addEventListener('click', function() {
                                        const subCategoryId = this.getAttribute('data-id');
                                        const subSubRow = document.getElementById('subsubcategory-' + subCategoryId);
                                        const subSubContent = subSubRow.querySelector('.subsubcategory-content');
                                        const subLoadingDiv = subSubRow.querySelector('.subsubcategory-loading');

                                        if (subSubRow.style.display === 'none') {
                                            subSubRow.style.display = 'table-row';

                                            // Veri yüklenmediyse yükle
                                            if (subSubContent.innerHTML === '') {
                                                subLoadingDiv.style.display = 'block';

                                                fetch('/category-management/subcategories?parent_id=' + subCategoryId)
                                                    .then(response => response.json())
                                                    .then(subData => {
                                                        subLoadingDiv.style.display = 'none';

                                                        if (subData.length === 0) {
                                                            subSubContent.innerHTML = '<div class="alert alert-info">Bu alt kategorinin alt kategorisi bulunmamaktadır.</div>';
                                                            return;
                                                        }

                                                        let subTable = '<table class="table table-bordered table-sm">';
                                                        subTable += '<thead><tr><th>ID</th><th>Alt Alt Kategori Adı</th><th>İşlemler</th></tr></thead>';
                                                        subTable += '<tbody>';

                                                        subData.forEach(subSubCategory => {
                                                            subTable += `<tr>
                                                    <td>${subSubCategory.id}</td>
                                                    <td>${subSubCategory.name}</td>
                                                    <td>
                                                        <a href="/category-management/edit/${subSubCategory.id}" class="btn btn-sm btn-warning">Düzenle</a>
                                                        <a href="/category-management/delete/${subSubCategory.id}" class="btn btn-sm btn-danger" onclick="return confirm('Bu alt alt kategoriyi silmek istediğinize emin misiniz?')">Sil</a>
                                                    </td>
                                                </tr>`;
                                                        });

                                                        subTable += '</tbody></table>';
                                                        subSubContent.innerHTML = subTable;
                                                    });
                                            } else {
                                                // Zaten yüklendiyse sadece göster
                                                subLoadingDiv.style.display = 'none';
                                            }
                                        } else {
                                            subSubRow.style.display = 'none';
                                        }
                                    });
                                });
                            });
                    } else {
                        // Zaten yüklendiyse sadece göster
                        loadingDiv.style.display = 'none';
                    }
                } else {
                    subRow.style.display = 'none';
                }
            });
        });
    });
</script>