<?php
// Statik veri
$dataByYear = [
  '2023' => [
    ['month' => 'Jan', 'users' => 120],
    ['month' => 'Feb', 'users' => 160],
    ['month' => 'Mar', 'users' => 200],
    ['month' => 'Apr', 'users' => 250],
    ['month' => 'May', 'users' => 300],
    ['month' => 'Jun', 'users' => 350],
    ['month' => 'Jul', 'users' => 400],
    ['month' => 'Aug', 'users' => 460],
    ['month' => 'Sep', 'users' => 500],
    ['month' => 'Oct', 'users' => 550],
    ['month' => 'Nov', 'users' => 580],
    ['month' => 'Dec', 'users' => 600],
  ],
  '2024' => [
    ['month' => 'Jan', 'users' => 650],
    ['month' => 'Feb', 'users' => 700],
    ['month' => 'Mar', 'users' => 750],
    ['month' => 'Apr', 'users' => 800],
  ],
];

// Eksik ayları doldur
function fillMissingMonths($data) {
    $allMonths = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $output = [];

    foreach ($allMonths as $month) {
        $found = false;
        foreach ($data as $entry) {
            if ($entry['month'] === $month) {
                $output[] = $entry;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $output[] = ['month' => $month, 'users' => 0];
        }
    }

    return $output;
}

$year = $_GET['year'] ?? '2024';
$selectedData = $dataByYear[$year] ?? [];
$selectedData = fillMissingMonths($selectedData);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Monthly User Growth</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .card {
      border: 1px solid #eee;
      border-radius: 8px;
      padding: 20px;
      margin-top: 20px;
      background: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .form-inline {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
<div id="kt_app_content" class="app-content flex-column-fluid">
  <!--begin::Content container-->
  <div id="kt_app_content_container" class="app-container container-xxl">

    <div class="card">
      <h2>Monthly User Growth</h2>

      <form method="get" class="form-inline">
        <label for="year">Select Year:</label>
        <select name="year" id="year" onchange="this.form.submit()">
          <?php foreach ($dataByYear as $key => $_): ?>
            <option value="<?= $key ?>" <?= $key === $year ? 'selected' : '' ?>><?= $key ?></option>
          <?php endforeach; ?>
        </select>
      </form>

      <canvas id="userChart" width="600" height="300"></canvas>
    </div>

  </div>
  <!--end::Content container-->
</div>

<script>
  const chartData = <?= json_encode($selectedData) ?>;
  const labels = chartData.map(item => item.month);
  const users = chartData.map(item => item.users);

  const ctx = document.getElementById('userChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Users',
        data: users,
        borderColor: 'rgba(54, 162, 235, 1)',
        fill: false,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'User Growth per Month (<?= $year ?>)'
        }
      }
    }
  });
</script>
</body>
</html>
