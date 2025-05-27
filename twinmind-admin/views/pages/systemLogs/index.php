<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
  <?php
// Örnek kullanıcı aktivite verisi
$activities = [
  [
    'id' => 1,
    'user_name' => 'John Doe',
    'user_avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=6366f1&color=fff&size=40',
    'action' => 'Course Completed',
    'description' => 'Completed "Advanced JavaScript" course',
    'timestamp' => '2025-05-27 14:30:00',
    'type' => 'course',
    'status' => 'completed',
    'details' => ['course' => 'Advanced JavaScript', 'progress' => 100, 'score' => 95]
  ],
  [
    'id' => 2,
    'user_name' => 'Jane Smith',
    'user_avatar' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=ec4899&color=fff&size=40',
    'action' => 'Login',
    'description' => 'User logged into the system',
    'timestamp' => '2025-05-27 13:45:00',
    'type' => 'login',
    'status' => 'success',
    'details' => ['ip' => '192.168.1.100', 'device' => 'Chrome on Windows']
  ],
  [
    'id' => 3,
    'user_name' => 'Michael Brown',
    'user_avatar' => 'https://ui-avatars.com/api/?name=Michael+Brown&background=10b981&color=fff&size=40',
    'action' => 'Quiz Attempt',
    'description' => 'Attempted "React Fundamentals Quiz"',
    'timestamp' => '2025-05-27 12:15:00',
    'type' => 'quiz',
    'status' => 'failed',
    'details' => ['quiz' => 'React Fundamentals Quiz', 'score' => 65, 'attempts' => 2]
  ],
  [
    'id' => 4,
    'user_name' => 'Emily White',
    'user_avatar' => 'https://ui-avatars.com/api/?name=Emily+White&background=f59e0b&color=fff&size=40',
    'action' => 'Profile Updated',
    'description' => 'Updated profile information',
    'timestamp' => '2025-05-27 11:30:00',
    'type' => 'profile',
    'status' => 'updated',
    'details' => ['fields' => ['email', 'phone', 'bio']]
  ],
  [
    'id' => 5,
    'user_name' => 'David Johnson',
    'user_avatar' => 'https://ui-avatars.com/api/?name=David+Johnson&background=ef4444&color=fff&size=40',
    'action' => 'Course Enrolled',
    'description' => 'Enrolled in "Python for Data Science"',
    'timestamp' => '2025-05-27 10:20:00',
    'type' => 'enrollment',
    'status' => 'enrolled',
    'details' => ['course' => 'Python for Data Science', 'price' => 99.99]
  ],
  [
    'id' => 6,
    'user_name' => 'Sarah Wilson',
    'user_avatar' => 'https://ui-avatars.com/api/?name=Sarah+Wilson&background=8b5cf6&color=fff&size=40',
    'action' => 'Assignment Submitted',
    'description' => 'Submitted "Final Project" assignment',
    'timestamp' => '2025-05-27 09:45:00',
    'type' => 'assignment',
    'status' => 'submitted',
    'details' => ['assignment' => 'Final Project', 'course' => 'Web Development Bootcamp']
  ]
];

// Filtreleme parametreleri
$filter_type = $_GET['type'] ?? '';
$filter_status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Filtreleme uygula
$filtered_activities = array_filter($activities, function($activity) use ($filter_type, $filter_status, $search) {
  $type_match = empty($filter_type) || $activity['type'] === $filter_type;
  $status_match = empty($filter_status) || $activity['status'] === $filter_status;
  $search_match = empty($search) || 
    stripos($activity['user_name'], $search) !== false || 
    stripos($activity['description'], $search) !== false;
  
  return $type_match && $status_match && $search_match;
});

// Zaman hesaplama fonksiyonu
function timeAgo($datetime) {
  $time = time() - strtotime($datetime);
  if ($time < 60) return 'Just now';
  if ($time < 3600) return floor($time/60) . ' minutes ago';
  if ($time < 86400) return floor($time/3600) . ' hours ago';
  return floor($time/86400) . ' days ago';
}

// Aktivite tipine göre ikon
function getActivityIcon($type) {
  $icons = [
    'course' => 'ki-book',
    'login' => 'ki-entrance-right',
    'quiz' => 'ki-questionnaire-tablet',
    'profile' => 'ki-user-edit',
    'enrollment' => 'ki-add-item',
    'assignment' => 'ki-file-up'
  ];
  return $icons[$type] ?? 'ki-information';
}

// Status renkleri
function getStatusColor($status) {
  $colors = [
    'completed' => 'success',
    'success' => 'success',
    'failed' => 'danger',
    'updated' => 'info',
    'enrolled' => 'primary',
    'submitted' => 'warning'
  ];
  return $colors[$status] ?? 'secondary';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Activities Dashboard</title>
  <link href="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" />
  <link href="https://preview.keenthemes.com/html/metronic/assets/css/style.bundle.css" rel="stylesheet" />
  <style>
    .activity-card {
      transition: all 0.3s ease;
      border-left: 4px solid transparent;
    }
    .activity-card:hover {
      border-left-color: #6366f1;
      background-color: #f8f9fa;
    }
    .activity-icon {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .timeline-item {
      position: relative;
      padding-left: 40px;
    }
    .timeline-item::before {
      content: '';
      position: absolute;
      left: 20px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #e4e6ef;
    }
    .timeline-item:last-child::before {
      display: none;
    }
    .timeline-dot {
      position: absolute;
      left: 13px;
      top: 20px;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: #6366f1;
      border: 3px solid #fff;
      box-shadow: 0 0 0 3px #e4e6ef;
    }
    .stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 15px;
    }
  </style>
</head>
<body>
<div id="kt_app_content" class="app-content flex-column-fluid">
  <div id="kt_app_content_container" class="app-container container-xxl">
    
    <!-- Header -->
    <div class="d-flex align-items-center mb-10">
      <i class="ki-duotone ki-activity fs-1 text-primary me-3"></i>
      <div>
        <h1 class="fs-1 fw-bold text-gray-800 mb-0">User Activities</h1>
        <p class="text-muted fs-6 mb-0">Monitor and track all user interactions</p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-6 mb-10">
      <div class="col-md-3">
        <div class="card bg-light-primary">
          <div class="card-body text-center">
            <i class="ki-duotone ki-user fs-2x text-primary mb-3"></i>
            <div class="fs-2 fw-bold text-primary"><?= count(array_unique(array_column($activities, 'user_name'))) ?></div>
            <div class="fs-6 text-muted">Active Users</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light-success">
          <div class="card-body text-center">
            <i class="ki-duotone ki-check-circle fs-2x text-success mb-3"></i>
            <div class="fs-2 fw-bold text-success"><?= count(array_filter($activities, fn($a) => in_array($a['status'], ['completed', 'success']))) ?></div>
            <div class="fs-6 text-muted">Successful Actions</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light-warning">
          <div class="card-body text-center">
            <i class="ki-duotone ki-time fs-2x text-warning mb-3"></i>
            <div class="fs-2 fw-bold text-warning"><?= count(array_filter($activities, fn($a) => strtotime($a['timestamp']) > strtotime('-24 hours'))) ?></div>
            <div class="fs-6 text-muted">Last 24 Hours</div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light-danger">
          <div class="card-body text-center">
            <i class="ki-duotone ki-cross-circle fs-2x text-danger mb-3"></i>
            <div class="fs-2 fw-bold text-danger"><?= count(array_filter($activities, fn($a) => $a['status'] === 'failed')) ?></div>
            <div class="fs-6 text-muted">Failed Actions</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-8">
      <div class="card-header">
        <h3 class="card-title">
          <i class="ki-duotone ki-filter fs-3 me-2"></i>Activity Filters
        </h3>
      </div>
      <div class="card-body">
        <form method="get" class="row g-4">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Search</label>
            <input type="text" name="search" class="form-control form-control-solid" 
                   placeholder="Search user or activity..." value="<?= htmlspecialchars($search) ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Type</label>
            <select name="type" class="form-select form-select-solid" data-control="select2">
              <option value="">All Types</option>
              <option value="course" <?= $filter_type === 'course' ? 'selected' : '' ?>>Course</option>
              <option value="login" <?= $filter_type === 'login' ? 'selected' : '' ?>>Login</option>
              <option value="quiz" <?= $filter_type === 'quiz' ? 'selected' : '' ?>>Quiz</option>
              <option value="profile" <?= $filter_type === 'profile' ? 'selected' : '' ?>>Profile</option>
              <option value="enrollment" <?= $filter_type === 'enrollment' ? 'selected' : '' ?>>Enrollment</option>
              <option value="assignment" <?= $filter_type === 'assignment' ? 'selected' : '' ?>>Assignment</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select form-select-solid" data-control="select2">
              <option value="">All Status</option>
              <option value="completed" <?= $filter_status === 'completed' ? 'selected' : '' ?>>Completed</option>
              <option value="success" <?= $filter_status === 'success' ? 'selected' : '' ?>>Success</option>
              <option value="failed" <?= $filter_status === 'failed' ? 'selected' : '' ?>>Failed</option>
              <option value="submitted" <?= $filter_status === 'submitted' ? 'selected' : '' ?>>Submitted</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">From Date</label>
            <input type="date" name="date_from" class="form-control form-control-solid" value="<?= $date_from ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">To Date</label>
            <input type="date" name="date_to" class="form-control form-control-solid" value="<?= $date_to ?>">
          </div>
          <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
              <i class="ki-duotone ki-magnifier fs-5"></i>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Activities List -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="ki-duotone ki-timeline fs-3 me-2"></i>Activity Timeline
            </h3>
            <div class="card-toolbar">
              <span class="badge badge-light-primary fs-7"><?= count($filtered_activities) ?> Activities</span>
            </div>
          </div>
          <div class="card-body p-0">
            <?php if (empty($filtered_activities)): ?>
              <div class="text-center py-10">
                <i class="ki-duotone ki-information fs-3x text-muted mb-5"></i>
                <h3 class="text-muted">No Activities Found</h3>
                <p class="text-muted">Try adjusting your filters</p>
              </div>
            <?php else: ?>
              <?php foreach ($filtered_activities as $activity): ?>
                <div class="timeline-item activity-card p-6 border-bottom">
                  <div class="timeline-dot bg-<?= getStatusColor($activity['status']) ?>"></div>
                  
                  <div class="d-flex align-items-start">
                    <div class="activity-icon bg-light-<?= getStatusColor($activity['status']) ?> me-4">
                      <i class="ki-duotone <?= getActivityIcon($activity['type']) ?> fs-4 text-<?= getStatusColor($activity['status']) ?>"></i>
                    </div>
                    
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                          <img src="<?= $activity['user_avatar'] ?>" class="w-30px h-30px rounded-circle me-3" alt="<?= $activity['user_name'] ?>">
                          <div>
                            <h6 class="fw-bold text-gray-800 mb-0"><?= htmlspecialchars($activity['user_name']) ?></h6>
                            <span class="fs-7 text-muted"><?= timeAgo($activity['timestamp']) ?></span>
                          </div>
                        </div>
                        <span class="badge badge-light-<?= getStatusColor($activity['status']) ?> fs-8"><?= ucfirst($activity['status']) ?></span>
                      </div>
                      
                      <div class="mb-3">
                        <h6 class="fs-6 fw-semibold text-gray-700 mb-1"><?= $activity['action'] ?></h6>
                        <p class="text-muted mb-0 fs-7"><?= htmlspecialchars($activity['description']) ?></p>
                      </div>
                      
                      <!-- Activity Details -->
                      <?php if (!empty($activity['details'])): ?>
                        <div class="bg-light rounded p-3 fs-8">
                          <?php foreach ($activity['details'] as $key => $value): ?>
                            <div class="row mb-1">
                              <div class="col-4 text-muted"><?= ucfirst($key) ?>:</div>
                              <div class="col-8 fw-semibold">
                                <?php if (is_array($value)): ?>
                                  <?= implode(', ', $value) ?>
                                <?php elseif ($key === 'score' && is_numeric($value)): ?>
                                  <span class="text-<?= $value >= 70 ? 'success' : 'danger' ?>"><?= $value ?>%</span>
                                <?php elseif ($key === 'price'): ?>
                                  $<?= number_format($value, 2) ?>
                                <?php else: ?>
                                  <?= htmlspecialchars($value) ?>
                                <?php endif; ?>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <!-- Sidebar -->
      <div class="col-md-4">
        <!-- Quick Stats -->
        <div class="card mb-6">
          <div class="card-header">
            <h3 class="card-title fs-6">Activity Summary</h3>
          </div>
          <div class="card-body">
            <?php
            $activity_counts = array_count_values(array_column($activities, 'type'));
            foreach ($activity_counts as $type => $count):
            ?>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                  <i class="ki-duotone <?= getActivityIcon($type) ?> fs-4 text-primary me-3"></i>
                  <span class="fw-semibold"><?= ucfirst($type) ?></span>
                </div>
                <span class="badge badge-light-primary"><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Recent Users -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fs-6">Most Active Users</h3>
          </div>
          <div class="card-body">
            <?php
            $user_activity_count = array_count_values(array_column($activities, 'user_name'));
            arsort($user_activity_count);
            $top_users = array_slice($user_activity_count, 0, 5, true);
            
            foreach ($top_users as $user => $count):
              $user_data = array_values(array_filter($activities, fn($a) => $a['user_name'] === $user))[0];
            ?>
              <div class="d-flex align-items-center mb-4">
                <img src="<?= $user_data['user_avatar'] ?>" class="w-35px h-35px rounded-circle me-3" alt="<?= $user ?>">
                <div class="flex-grow-1">
                  <h6 class="fw-bold text-gray-800 mb-0 fs-7"><?= htmlspecialchars($user) ?></h6>
                  <span class="text-muted fs-8"><?= $count ?> activities</span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://preview.keenthemes.com/html/metronic/assets/plugins/global/plugins.bundle.js"></script>
<script src="https://preview.keenthemes.com/html/metronic/assets/js/scripts.bundle.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Select2 initialization
  $('[data-control="select2"]').select2({
    minimumResultsForSearch: Infinity
  });
  
  // Auto-refresh every 30 seconds
  setInterval(function() {
    // In a real application, this would fetch new data via AJAX
    console.log('Checking for new activities...');
  }, 30000);
  
  // Activity card click handler
  $('.activity-card').on('click', function() {
    // Add click functionality for activity details
    console.log('Activity clicked');
  });
});
</script>
</body>
</html>
    </div>
    <!--end::Content container-->
</div>