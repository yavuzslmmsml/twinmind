<div class="card">
    <!--begin::Body-->
    <div class="card-body p-lg-20">
        <!--begin::Section-->
        <div class="mb-17">
            <!--begin::Title-->
            <?php

            global $conn;
            if ($_SESSION["user"]["role"] == 1 || $_SESSION["user"]["role"] == 2) {
                $query = "SELECT * FROM courses WHERE id = $CourseId";
                $result = mysqli_query($conn, $query);
                $fetch = mysqli_fetch_assoc($result);
            } elseif ($_SESSION["user"]["role"] == 3) {

                if ($fetch["instructer_id"] != $_SESSION["user"]["user_id"]) {
                    header("Location: ../../courseManagement/");
                    exit;
                }
                $query = "SELECT * FROM courses WHERE id = $CourseId";
                $result = mysqli_query($conn, $query);
                $fetch = mysqli_fetch_assoc($result);
            }
            $course_id = $fetch["id"];
            $title = $fetch["title"];
            $description = $fetch["description"];
            $section_count = $fetch["section_count"];
            $instructer_id = $fetch["instructer_id"];
            $price = $fetch["price"];
            $thumbnail = $fetch["thumbnail"];
            $is_published = $fetch["is_published"];
            $created_at = $fetch["created_at"];

            $query = "SELECT CONCAT(name, ' ', surname) AS full_name FROM users WHERE user_id = $instructer_id";
            $result = mysqli_query($conn, $query);
            $fetch2 = mysqli_fetch_assoc($result);
            $instructer_name = $fetch2["full_name"]
            ?>
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-gray-900 mb-7"><?= $title ?></h3>

                <a href="" class="btn btn-primary mb-7">Edit Course</a>

            </div>
            <!--end::Title-->
            <!--begin::Separator-->
            <div class="separator separator-dashed mb-9"></div>
            <!--end::Separator-->
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-md-6">
                    <!--begin::Feature post-->
                    <div class="h-100 d-flex flex-column justify-content-between pe-lg-6 mb-lg-0 mb-10">
                        <!--begin::Video-->
                        <div class="mb-3">
                            <img src="..\assets\images\courseThumbnails\<?= $thumbnail ?>" class="card-img-top">
                        </div>
                        <!--end::Video-->
                        <!--begin::Body-->
                        <div class="mb-5">
                            <!--begin::Title-->
                            <p class="fs-2 text-gray-900 fw-bold text-hover-primary text-gray-900 lh-base"><?= $title ?>
                            </p>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="fw-semibold fs-5 text-gray-600 text-gray-900 mt-4"><?= $description ?></div>
                            <!--end::Text-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center pe-2">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-35px symbol-circle me-3">
                                    <img alt="" src="assets/media/avatars/300-9.jpg" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Text-->
                                <div class="fs-5 fw-bold">
                                    <a href="pages/user-profile/overview.html"
                                        class="text-gray-700 text-hover-primary"></a>
                                    <?= $instructer_name ?>
                                    <span class="text-muted"><?= $created_at ?></span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Label-->
                            <span class="badge badge-light-primary fw-bold my-2">Instructer</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Feature post-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->

                <div class="col-md-6 justify-content-between d-flex flex-column">
                    <!--begin::Post-->
                    <?php
                    $query = "SELECT * FROM course_sections WHERE course_id = $course_id ORDER BY section_order ASC";
                    $result = mysqli_query($conn, $query);
                    foreach ($result as $course_section) {
                    ?>
                        <div class="ps-lg-6 mb-16 mt-md-0 mt-17">
                            <!--begin::Body-->

                            <div class="mb-6">

                                <!--begin::Text-->
                                <div class="fw-semibold fs-5 mt-4 text-gray-600 text-gray-900">
                                    <?= $course_section["section_title"] ?>(<?= $course_section["lesson_count"] ?> lesson)
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->

                            <?php
                            $section_id = $course_section["id"];
                            $query = "SELECT * FROM course_lessons WHERE section_id = $section_id ORDER BY lesson_order ASC";
                            $result = mysqli_query($conn, $query);
                            foreach ($result as $course_lesson) {
                            ?>
                                <div class="d-flex flex-stack flex-wrap">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center pe-2">
                                        <!--begin::Avatar-->

                                        <div><?= $course_lesson["lesson_title"] ?></div>

                                        <!--end::Text-->
                                    </div>

                                    <!--end::Item-->
                                    <!--begin::Label-->

                                    <!--end::Label-->
                                </div>
                            <?php } ?>
                            <!--end::Footer-->
                        </div>


                        <!--end::Post-->
                        <!--begin::Post-->

                        <!--end::Post-->
                    <?php } ?>
                </div>

                <!--end::Col-->
            </div>
            <!--begin::Row-->
        </div>
        <!--end::Section-->
        <!--begin::Section-->

        <!--end::Section-->
        <!--begin::Section-->

        <!--end::Section-->
        <!--begin::latest instagram-->

        <!--end::latest instagram-->
    </div>
    <!--end::Body-->
</div>