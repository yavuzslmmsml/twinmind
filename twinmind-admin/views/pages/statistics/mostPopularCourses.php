<?php
// AJAX isteği geldiyse sadece kurs listesini döndür
if (isset($_GET['ajax'])) {
    $courses = [
        ['title' => 'Mastering JavaScript', 'students' => 1523, 'rating' => 4.8, 'category' => 'Programming'],
        ['title' => 'Python for Data Science', 'students' => 1280, 'rating' => 4.7, 'category' => 'Data Science'],
        ['title' => 'React Bootcamp', 'students' => 980, 'rating' => 4.9, 'category' => 'Programming'],
        ['title' => 'UI/UX Design Fundamentals', 'students' => 870, 'rating' => 4.6, 'category' => 'Design'],
        ['title' => 'Machine Learning A-Z', 'students' => 765, 'rating' => 4.5, 'category' => 'Data Science'],
    ];

    $search = strtolower($_GET['search'] ?? '');
    $category = $_GET['category'] ?? '';

    $filtered = array_filter($courses, function($c) use ($search, $category) {
        return (empty($search) || strpos(strtolower($c['title']), $search) !== false)
            && (empty($category) || $c['category'] === $category);
    });

    if (empty($filtered)) {
        echo '<div class="col-12"><div class="alert alert-warning">No courses found.</div></div>';
    } else {
        foreach ($filtered as $course) {
            echo '<div class="col-md-6 col-lg-4">
                <div class="course-card h-100">
                    <h5>' . htmlspecialchars($course['title']) . '</h5>
                    <p class="mb-1">👥 ' . number_format($course['students']) . ' students</p>
                    <p class="rating">⭐ ' . $course['rating'] . ' / 5.0</p>
                    <p class="text-muted">📚 ' . $course['category'] . '</p>
                    <button class="btn btn-sm btn-primary mt-2">View Course</button>
                </div>
            </div>';
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Most Popular Courses</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .course-card {
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      border-radius: 12px;
      padding: 20px;
      background: #fff;
      transition: 0.2s;
    }
    .course-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .rating {
      font-weight: bold;
      color: #f39c12;
    }
  </style>
</head>
<body>
<div id="kt_app_content" class="app-content flex-column-fluid">
  <div id="kt_app_content_container" class="app-container container-xxl py-5">
    <h2 class="mb-4">Most Popular Courses</h2>

    <!-- Arama ve Filtre -->
    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
      </div>
      <div class="col-md-6">
        <select id="categorySelect" class="form-select">
          <option value="">All Categories</option>
          <option>Programming</option>
          <option>Data Science</option>
          <option>Design</option>
        </select>
      </div>
    </div>

    <!-- Kurs Kartları -->
    <div class="row g-4" id="coursesContainer"></div>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    $('#categorySelect').select2({
      placeholder: "Select category",
      allowClear: true
    });

    const searchInput = document.getElementById("searchInput");
    const categorySelect = document.getElementById("categorySelect");
    const coursesContainer = document.getElementById("coursesContainer");

    async function fetchCourses() {
      const search = searchInput.value;
      const category = categorySelect.value;
      const currentFile = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);

      const response = await fetch(`${currentFile}?ajax=1&search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}`);
      const html = await response.text();
      coursesContainer.innerHTML = html;
    }

    searchInput.addEventListener("input", fetchCourses);
    categorySelect.addEventListener("change", fetchCourses);
    fetchCourses(); // Sayfa açılırken yükle
  });
</script>
</body>
</html>
