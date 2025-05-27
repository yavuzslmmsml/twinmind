<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Kategori Yönetimi</h4>
                    <a href="/category-management/add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Yeni Kategori Ekle
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Kategori Adı</th>
                                    <th>Üst Kategori</th>
                                    <th style="width: 200px;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($mainCategories)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Henüz kategori eklenmemiş</td>
                                </tr>
                                <?php else: ?>
                                <?php
                                    // Ana kategorileri listele
                                    foreach ($mainCategories as $category):
                                        if ($category['parent_id'] === null):
                                    ?>
                                <tr class="main-category">
                                    <td class="text-center"><?= htmlspecialchars($category['id']) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($category['name']) ?></strong>
                                    </td>
                                    <td>Ana Kategori</td>
                                    <td class="text-center">
                                        <a href="/category-management/edit/<?= htmlspecialchars($category['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Düzenle
                                        </a>
                                        <a href="/category-management/delete/<?= htmlspecialchars($category['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Alt kategorileri de silinecektir.')">
                                            <i class="fas fa-trash"></i> Sil
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                            // Alt kategorileri listele
                                            $subQuery = "SELECT * FROM categories WHERE parent_id = '" . mysqli_real_escape_string($conn, $category['id']) . "' ORDER BY name";
                                            $subResult = mysqli_query($conn, $subQuery);
                                            if ($subResult && mysqli_num_rows($subResult) > 0):
                                            ?>
                                <tr class="subcategory-header"
                                    data-category-id="<?= htmlspecialchars($category['id']) ?>">
                                    <td colspan="4"
                                        style="padding-left: 30px; cursor: pointer; background-color: #f8f9fa;">
                                        <i class="fas fa-chevron-right"></i>
                                        <span class="text-primary">
                                            <i class="fas fa-folder"></i> Alt Kategoriler
                                            <small class="text-muted">(<?= mysqli_num_rows($subResult) ?>)</small>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="subcategory-content"
                                    id="subcategory-<?= htmlspecialchars($category['id']) ?>" style="display: none;">
                                    <td colspan="4" style="padding: 0;">
                                        <div style="padding-left: 30px;">
                                            <?php while ($subCategory = mysqli_fetch_assoc($subResult)): ?>
                                            <div class="subcategory-item">
                                                <div
                                                    class="d-flex justify-content-between align-items-center py-2 px-3">
                                                    <div>
                                                        <span class="badge badge-info mr-2">ID:
                                                            <?= htmlspecialchars($subCategory['id']) ?></span>
                                                        <span
                                                            class="subcategory-name"><?= htmlspecialchars($subCategory['name']) ?></span>
                                                    </div>
                                                    <div>
                                                        <a href="/category-management/edit/<?= htmlspecialchars($subCategory['id']) ?>"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i> Düzenle
                                                        </a>
                                                        <a href="/category-management/delete/<?= htmlspecialchars($subCategory['id']) ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Alt kategorileri de silinecektir.')">
                                                            <i class="fas fa-trash"></i> Sil
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                                    // Alt-alt kategorileri listele
                                                                    $subSubQuery = "SELECT * FROM categories WHERE parent_id = '" . mysqli_real_escape_string($conn, $subCategory['id']) . "' ORDER BY name";
                                                                    $subSubResult = mysqli_query($conn, $subSubQuery);
                                                                    if ($subSubResult && mysqli_num_rows($subSubResult) > 0):
                                                                    ?>
                                                <div class="subsubcategory-header"
                                                    data-subcategory-id="<?= htmlspecialchars($subCategory['id']) ?>">
                                                    <div
                                                        style="padding-left: 20px; cursor: pointer; background-color: #f8f9fa;">
                                                        <i class="fas fa-chevron-right"></i>
                                                        <span class="text-primary">
                                                            <i class="fas fa-folder"></i> Alt Kategoriler
                                                            <small
                                                                class="text-muted">(<?= mysqli_num_rows($subSubResult) ?>)</small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="subsubcategory-content"
                                                    id="subsubcategory-<?= htmlspecialchars($subCategory['id']) ?>"
                                                    style="display: none;">
                                                    <?php while ($subSubCategory = mysqli_fetch_assoc($subSubResult)): ?>
                                                    <div class="subsubcategory-item" style="padding-left: 40px;">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center py-2 px-3">
                                                            <div>
                                                                <span class="badge badge-info mr-2">ID:
                                                                    <?= htmlspecialchars($subSubCategory['id']) ?></span>
                                                                <span
                                                                    class="subsubcategory-name"><?= htmlspecialchars($subSubCategory['name']) ?></span>
                                                            </div>
                                                            <div>
                                                                <a href="/category-management/edit/<?= htmlspecialchars($subSubCategory['id']) ?>"
                                                                    class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-edit"></i> Düzenle
                                                                </a>
                                                                <a href="/category-management/delete/<?= htmlspecialchars($subSubCategory['id']) ?>"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Alt kategorileri de silinecektir.')">
                                                                    <i class="fas fa-trash"></i> Sil
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endwhile; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endwhile; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endif; ?>
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

<style>
.main-category {
    background-color: #fff;
}

.subcategory-header,
.subsubcategory-header {
    background-color: #f8f9fa;
    transition: background-color 0.2s;
}

.subcategory-header:hover,
.subsubcategory-header:hover {
    background-color: #e9ecef;
}

.subcategory-item,
.subsubcategory-item {
    border-bottom: 1px solid #dee2e6;
    background-color: #fff;
}

.subcategory-item:last-child,
.subsubcategory-item:last-child {
    border-bottom: none;
}

.fa-chevron-right,
.fa-chevron-down {
    transition: transform 0.2s;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.6em;
}

.btn {
    margin: 0 2px;
}

.subcategory-item,
.subsubcategory-item {
    transition: background-color 0.2s;
}

.subcategory-item:hover,
.subsubcategory-item:hover {
    background-color: #f8f9fa;
}

.text-primary {
    color: #007bff !important;
}

.text-muted {
    color: #6c757d !important;
}

.fa-folder {
    margin-right: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ana kategori alt kategorileri için
    document.querySelectorAll('.subcategory-header').forEach(header => {
        header.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            const content = document.getElementById('subcategory-' + categoryId);
            const icon = this.querySelector('i');

            if (content.style.display === 'none') {
                content.style.display = 'table-row';
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-down');
            } else {
                content.style.display = 'none';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-right');
            }
        });
    });

    // Alt kategori alt-alt kategorileri için
    document.querySelectorAll('.subsubcategory-header').forEach(header => {
        header.addEventListener('click', function() {
            const subcategoryId = this.getAttribute('data-subcategory-id');
            const content = document.getElementById('subsubcategory-' + subcategoryId);
            const icon = this.querySelector('i');

            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-down');
            } else {
                content.style.display = 'none';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-right');
            }
        });
    });
});
</script>