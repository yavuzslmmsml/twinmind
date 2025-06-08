<?php

namespace App\Controllers;

use Core\View;

class CourseController {

    public function index() {

        $test = "sifre";
        View::render('courseManagement/index', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
    public function addNewCourse() {

        // $query = "SELECT * FROM categories WHERE parent_id IS NULL  ORDER BY name";
        // $result = mysqli_query($conn, $query);
        // $mainCategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // $query = "SELECT * FROM categories WHERE parent_id IS  NOT NULL  ORDER BY parent_id, name";
        // $result = mysqli_query($conn, $query);
        // $subCategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // $categories = array_merge($mainCategories, $subCategories);
        $categories = $this->getCategoryTree();

        $test = "sifre";
        View::render('courseManagement/addNewCourse', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test,
            'Categories' => $categories
        ]);
    }

    public function getCategoryTree() {
        // Tüm kategorileri çek
        global $conn;
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);

        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }

        $grouped = [];
        foreach ($categories as $cat) {
            $grouped[$cat['parent_id']][] = $cat;
        }

        // Ağaç yapısını döndüren iç fonksiyon
        function buildTree($parentId, $grouped, $level = 0) {
            if (!isset($grouped[$parentId])) return "";

            $html = "";
            foreach ($grouped[$parentId] as $category) {
                $margin = $level * 20; // Seviye başına 20px iç boşluk
                $id = $category['id'];
                $name = htmlspecialchars($category['name']);

                $html .= '
                <div class="form-check" style="margin-left: ' . $margin . 'px;">
                    <input class="form-check-input" type="checkbox" value="' . $name . '" id="cat' . $id . '" name="categories[]">
                    <label class="form-check-label" for="cat' . $id . '">' . $name . '(' . $id . ')</label>
                </div>
            ';

                $html .= buildTree($id, $grouped, $level + 1);
            }
            return $html;
        }

        // HTML string döndür
        return buildTree(null, $grouped);
    }


    public function addNewCourseWithPost() {
        global $conn;


        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $instructer = $_POST['instructer'] ?? '';
        $price = $_POST['price'] ?? '';
        $is_published = $_POST['status'] ?? '';
        $title = $_POST['title'];
        $categories = $_POST['categories'] ?? []; // array
        // JSON çıktısı
        echo json_encode(['categories' => $categories], JSON_PRETTY_PRINT);

        $thumbnail = $_FILES['thumbnail'] ?? null;

        if ($thumbnail && $thumbnail['error'] === 0) {
            $thumbName = $thumbnail['name'];
            $thumbTmp = $thumbnail['tmp_name'];

            // örnek: uploads klasörüne kaydet
            // move_uploaded_file($thumbTmp, "uploads/" . $thumbName);
        }

        $query = "INSERT INTO `courses` (`title`,`description`,`section_count`,`instructer_id`,`price`,`thumbnail`,`is_published`,`created_at`) VALUES ('$title','$description','0','$instructer','$price','$thumbName','$is_published',NOW())";

        if (mysqli_query($conn, $query)) {
            $course_id = mysqli_insert_id($conn);
        } else {
            exit(json_encode(['status' => false, 'errors' => ['general' => ['Registration failed. Please try again.']]]));
        }


        $sections = $_POST['sections'] ?? [];

        $sectionCounter = 0;

        foreach ($sections as $section_index => $section) {
            $section_title = mysqli_real_escape_string($conn, $section['title']);
            $lesson_count = count($section['lessons']);
            $section_order = $section_index + 1;
            $sectionCounter++;

            $query = "INSERT INTO course_sections (course_id, section_title, lesson_count, section_order,created_at)
            VALUES ('$course_id', '$section_title', '$lesson_count', '$section_order',NOW())";

            if (mysqli_query($conn, $query)) {
                $section_id = mysqli_insert_id($conn);

                foreach ($section['lessons'] as $lesson_index => $lesson) {
                    $lesson_title = mysqli_real_escape_string($conn, $lesson['title']);
                    $lesson_order = $lesson_index + 1;


                    $video_files = $lesson['video']; // HER ZAMAN ARRAY
                    $video_count = count($video_files);
                    echo json_encode($video_count);
                    // Lesson insert
                    $sql2 = "INSERT INTO course_lessons (section_id,lesson_title, video_count, lesson_order,created_at)
                     VALUES ($section_id, '$lesson_title', $video_count, $lesson_order,NOW())";
                    if (mysqli_query($conn, $sql2)) {
                        $lesson_id = mysqli_insert_id($conn);

                        // Video insert (örnek)
                        foreach ($video_files as $video_file) {
                            $filename = mysqli_real_escape_string($conn, $video_file['name'] ?? '');
                            $sql3 = "INSERT INTO lesson_videos (lesson_id, video_url) VALUES ($lesson_id, '$filename')";
                            mysqli_query($conn, $sql3);
                        }
                    }
                }
            }
        }

        // Section count'u güncelle
        $updateCourse = "UPDATE courses SET section_count = $sectionCounter WHERE id = $course_id";

        if (mysqli_query($conn, $updateCourse)) {
            exit(json_encode(['status' => true, 'message' => 'Course Added', 'redirect' => 'home']));
        }


        // exit(json_encode(['status' => true, 'message' => 'Course Added', 'redirect' => 'home']));
    }
    public function manageCourseCategory() {

        $test = "sifre";
        View::render('courseManagement/manageCourseCategory', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
    public function pendingCourseApprovals() {

        $test = "sifre";
        View::render('courseManagement/pendingCourseApprovals', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
}
