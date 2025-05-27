<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
  <?php
// Statik kazanç verisi
$instructors = [
  ['name' => 'John Doe', 'courses' => 12, 'students' => 1540, 'earnings' => 12450.75, 'image' => '/twinmind-admin/public/assets/media/avatars/images.png', 'specialty' => 'Web Development', 'rating' => 4.9],
  ['name' => 'Jane Smith', 'courses' => 8, 'students' => 980, 'earnings' => 9870.00, 'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=80&h=80&fit=crop&crop=face', 'specialty' => 'Data Science', 'rating' => 4.8],
  ['name' => 'Michael Brown', 'courses' => 5, 'students' => 760, 'earnings' => 8650.25, 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop&crop=face', 'specialty' => 'Mobile Development', 'rating' => 4.7],
  ['name' => 'Emily White', 'courses' => 9, 'students' => 1320, 'earnings' => 11980.50, 'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&h=80&fit=crop&crop=face', 'specialty' => 'UI/UX Design', 'rating' => 4.9],
  ['name' => 'David Johnson', 'courses' => 6, 'students' => 890, 'earnings' => 7830.40, 'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=face', 'specialty' => 'Cloud Computing', 'rating' => 4.6],
];

$selectedRange = $_GET['range'] ?? '';

usort($instructors, function($a, $b) {
  return $b['earnings'] <=> $a['earnings'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Top Earning Instructors</title>
  <link href="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" />
  <link href="https://preview.keenthemes.com/html/metronic/assets/css/style.bundle.css" rel="stylesheet" />
  <style>
    .instructor-card {
      transition: all 0.3s ease;
      border: 1px solid #e4e6ef;
    }
    .instructor-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .instructor-avatar {
      width: 80px;
      height: 80px;
      border: 3px solid #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      object-fit: cover;
    }
    .rank-badge {
      position: absolute;
      top: -10px;
      left: -10px;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: white;
      font-size: 14px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .rank-1 { background: linear-gradient(135deg, #ffd700, #ffed4e); color: #1a1a1a; }
    .rank-2 { background: linear-gradient(135deg, #c0c0c0, #e8e8e8); color: #1a1a1a; }
    .rank-3 { background: linear-gradient(135deg, #cd7f32, #daa520); }
    .rank-other { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .stats-item {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 12px;
      margin: 4px 0;
      border-left: 4px solid #6366f1;
    }
    .earnings-highlight {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      border-radius: 12px;
      padding: 15px;
      text-align: center;
      margin: 15px 0;
    }
    .rating-stars {
      color: #fbbf24;
    }
  </style>
</head>
<body>
<div class="container-xxl py-10">
  <div class="d-flex align-items-center mb-10">
    <i class="ki-duotone ki-crown fs-1 text-warning me-3"></i>
    <h2 class="fs-1 fw-bold mb-0 text-gray-800">Top Earning Instructors</h2>
  </div>

  <!-- Filter Section -->
  <div class="card mb-10">
    <div class="card-body">
      <form method="get" class="row g-5 align-items-end">
        <div class="col-md-6">
          <label class="form-label fw-semibold fs-6">
            <i class="ki-duotone ki-calendar fs-5 me-2"></i>Time Range
          </label>
          <select class="form-select form-select-solid" name="range" data-control="select2">
            <option value="" <?= $selectedRange === '' ? 'selected' : '' ?>>All Time</option>
            <option value="1d" <?= $selectedRange === '1d' ? 'selected' : '' ?>>Last 24 Hours</option>
            <option value="1w" <?= $selectedRange === '1w' ? 'selected' : '' ?>>Last 7 Days</option>
            <option value="1m" <?= $selectedRange === '1m' ? 'selected' : '' ?>>Last 30 Days</option>
            <option value="1y" <?= $selectedRange === '1y' ? 'selected' : '' ?>>Last 12 Months</option>
          </select>
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary fw-bold w-100">
            <i class="ki-duotone ki-filter fs-5 me-2"></i>Apply Filter
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Cards -->
  <div class="row g-6">
    <?php foreach ($instructors as $index => $inst): ?>
      <div class="col-md-6 col-xl-4">
        <div class="card instructor-card h-100 position-relative">
          <!-- Rank Badge -->
          <div class="rank-badge rank-<?= $index < 3 ? ($index + 1) : 'other' ?>">
            <?= $index + 1 ?>
          </div>
          
          <div class="card-body text-center pt-8">
            <!-- Avatar -->
            <div class="mb-5">
              <img src="<?= htmlspecialchars($inst['image']) ?>" 
                   class="instructor-avatar rounded-circle mx-auto d-block" 
                   alt="<?= htmlspecialchars($inst['name']) ?>"
                   onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($inst['name']) ?>&background=6366f1&color=fff&size=80'">
            </div>

            <!-- Name and Specialty -->
            <h3 class="fs-4 fw-bold text-gray-800 mb-2">
              <?= htmlspecialchars($inst['name']) ?>
            </h3>
            <div class="text-muted mb-3 fs-6">
              <i class="ki-duotone ki-code fs-6 me-1"></i>
              <?= htmlspecialchars($inst['specialty']) ?>
            </div>

            <!-- Rating -->
            <div class="mb-4">
              <span class="rating-stars me-2">
                <?php for($i = 1; $i <= 5; $i++): ?>
                  <?= $i <= floor($inst['rating']) ? '★' : '☆' ?>
                <?php endfor; ?>
              </span>
              <span class="text-muted fs-7"><?= $inst['rating'] ?>/5.0</span>
            </div>

            <!-- Stats -->
            <div class="row g-2 mb-4">
              <div class="col-6">
                <div class="stats-item">
                  <div class="fs-7 text-muted">Courses</div>
                  <div class="fs-5 fw-bold text-gray-800"><?= $inst['courses'] ?></div>
                </div>
              </div>
              <div class="col-6">
                <div class="stats-item">
                  <div class="fs-7 text-muted">Students</div>
                  <div class="fs-5 fw-bold text-gray-800"><?= number_format($inst['students']) ?></div>
                </div>
              </div>
            </div>

            <!-- Earnings Highlight -->
            <div class="earnings-highlight">
              <div class="fs-7 text-white-50 mb-1">Total Earnings</div>
              <div class="fs-2 fw-bold">$<?= number_format($inst['earnings'], 2) ?></div>
            </div>

            <!-- Action Button -->
            <a href="#" class="btn btn-light-primary btn-sm w-100 mt-3">
              <i class="ki-duotone ki-chart-line fs-5 me-2"></i>View Analytics
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Summary Stats -->
  <div class="row g-6 mt-10">
    <div class="col-md-3">
      <div class="card bg-light-primary">
        <div class="card-body text-center">
          <i class="ki-duotone ki-user fs-2x text-primary mb-3"></i>
          <div class="fs-2 fw-bold text-primary"><?= count($instructors) ?></div>
          <div class="fs-6 text-muted">Total Instructors</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-success">
        <div class="card-body text-center">
          <i class="ki-duotone ki-book fs-2x text-success mb-3"></i>
          <div class="fs-2 fw-bold text-success"><?= array_sum(array_column($instructors, 'courses')) ?></div>
          <div class="fs-6 text-muted">Total Courses</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-warning">
        <div class="card-body text-center">
          <i class="ki-duotone ki-people fs-2x text-warning mb-3"></i>
          <div class="fs-2 fw-bold text-warning"><?= number_format(array_sum(array_column($instructors, 'students'))) ?></div>
          <div class="fs-6 text-muted">Total Students</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light-info">
        <div class="card-body text-center">
          <i class="ki-duotone ki-dollar fs-2x text-info mb-3"></i>
          <div class="fs-2 fw-bold text-info">$<?= number_format(array_sum(array_column($instructors, 'earnings')), 0) ?></div>
          <div class="fs-6 text-muted">Total Earnings</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.js"></script>
<script src="https://preview.keenthemes.com/html/metronic/assets/js/scripts.bundle.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    $('[data-control="select2"]').select2({
      minimumResultsForSearch: Infinity
    });
  });
</script>
</body>
</html>

    </div>
    <!--end::Content container-->
</div>