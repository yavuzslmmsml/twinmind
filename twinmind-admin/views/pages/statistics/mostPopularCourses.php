<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
  
    <?php
// Statik kurs verisi
$courses = [
  ['title' => 'Mastering JavaScript', 'students' => 1523, 'rating' => 4.8, 'category' => 'Programming'],
  ['title' => 'Python for Data Science', 'students' => 1280, 'rating' => 4.7, 'category' => 'Data Science'],
  ['title' => 'React Bootcamp', 'students' => 980, 'rating' => 4.9, 'category' => 'Programming'],
  ['title' => 'UI/UX Design Fundamentals', 'students' => 870, 'rating' => 4.6, 'category' => 'Design'],
  ['title' => 'Machine Learning A-Z', 'students' => 765, 'rating' => 4.5, 'category' => 'Data Science'],
];

// Form verileri
$search = strtolower($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';

// Filtreleme
$filteredCourses = array_filter($courses, function ($course) use ($search, $category) {
  $titleMatch = empty($search) || strpos(strtolower($course['title']), $search) !== false;
  $categoryMatch = empty($category) || $course['category'] === $category;
  return $titleMatch && $categoryMatch;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Most Popular Courses</title>
  <link href="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" />
  <link href="https://preview.keenthemes.com/html/metronic/assets/css/style.bundle.css" rel="stylesheet" />
</head>
<body>
<div class="container-xxl py-10">
  <h2 class="fs-1 fw-bold mb-10 text-gray-800">Most Popular Courses</h2>

  <!-- Filter Form -->
  <form method="get" class="row mb-10 g-5 align-items-end" id="filterForm">
    <div class="col-md-5">
      <label class="form-label fw-semibold">Search</label>
      <input type="text" name="search" class="form-control form-control-solid" placeholder="Search courses..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label fw-semibold">Category</label>
      <select name="category" class="form-select form-select-solid" id="categorySelect" data-control="select2">
        <option value="" <?= $category === '' ? 'selected' : '' ?>>All Categories</option>
        <option value="Programming" <?= $category === 'Programming' ? 'selected' : '' ?>>Programming</option>
        <option value="Data Science" <?= $category === 'Data Science' ? 'selected' : '' ?>>Data Science</option>
        <option value="Design" <?= $category === 'Design' ? 'selected' : '' ?>>Design</option>
      </select>
    </div>
    <div class="col-md-3 d-grid">
      <button type="submit" class="btn btn-primary fw-bold">
        <i class="ki-duotone ki-filter fs-2"></i> Filter
      </button>
    </div>
  </form>

  <!-- Course Cards -->
  <div class="row g-6">
    <?php if (empty($filteredCourses)): ?>
      <div class="col-12">
        <div class="alert alert-warning d-flex align-items-center p-5">
          <i class="ki-duotone ki-information fs-2hx text-warning me-4"></i>
          <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">No courses found</h4>
            <span>Try changing your search or category.</span>
          </div>
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($filteredCourses as $course): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card card-flush h-100">
            <div class="card-header">
              <h3 class="card-title text-gray-800 fw-bold"><?= htmlspecialchars($course['title']) ?></h3>
            </div>
            <div class="card-body">
              <div class="mb-2 text-muted">👥 <?= number_format($course['students']) ?> students</div>
              <div class="mb-2 text-warning fw-semibold">⭐ <?= $course['rating'] ?> / 5.0</div>
              <div class="mb-4 text-gray-600">📚 <?= $course['category'] ?></div>
              <a href="#" class="btn btn-sm btn-light-primary">
                <i class="ki-duotone ki-arrow-right fs-4 me-1"></i>View Course
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- JS -->
<script src="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.js"></script>
<script src="https://preview.keenthemes.com/html/metronic/assets/js/scripts.bundle.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const selectElement = $('#categorySelect');

    // select2 başlat - allowClear kaldırıldı ve placeholder yerine varsayılan seçenek kullanıldı
    selectElement.select2();

    // kategori değiştiğinde formu otomatik gönder
    selectElement.on('change', function () {
      document.getElementById('filterForm').submit();
    });
  });
</script>
</body>
</html>
    </div>
    <!--end::Content container-->
</div>