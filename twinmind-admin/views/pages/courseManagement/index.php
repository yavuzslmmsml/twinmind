<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="container mt-5">
            <h3 class="mb-4">All Courses</h3>

            <div class="row g-4">
                <!-- Course Card 1 -->
                <?php
        global $conn;
        foreach ($Result as $courses) {
          $course_id = $courses["id"];
          $course_title = $courses["title"];
          $course_description = $courses["description"];
          $section_count = $courses["section_count"];
          $price = $courses["price"];
          $thumbnail = $courses["thumbnail"];
          $is_published = $courses["is_published"];
          $created_at = $courses["created_at"];

          $query = "SELECT * FROM users WHERE user_id = '" . $courses["instructer_id"] . "'";
          $result = mysqli_query($conn, $query);
          $fetch2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
          $instructer_id = $fetch2["0"]["user_id"];
          $instructer_name = $fetch2["0"]["name"];
          $instructer_surname = $fetch2["0"]["surname"];
        ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="..\assets\images\courseThumbnails\<?= $thumbnail ?>" class="card-img-top">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1"><?= $course_title ?></h5>
                            <small class="text-muted mb-2"><?= $instructer_name ?>
                                &nbsp;<?= $instructer_surname ?></small>
                            <div class="mb-2 text-warning">★★★★☆ <small class="text-muted">(4.5)</small></div>
                            <p class="card-text flex-grow-1"><?= $course_description ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold"><?= $price ?> $</span>
                                <a href="courseManagement/displayCourse/<?= $course_id ?>"
                                    class="btn btn-sm btn-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>
                <!-- Course Card 2 -->

            </div>

            <!-- View More Button -->
            <div class="text-center mt-5">
                <a href="all_courses.php" class="btn btn-primary btn-lg">View More Courses</a>
            </div>
        </div>



    </div>
    <!--end::Content container-->
</div>