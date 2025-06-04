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
                    <input class="form-check-input" type="checkbox" value="' . $id . '" id="cat' . $id . '" name="categories[]">
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

        exit(json_encode(['status' => true, 'message' => 'Course Added', 'redirect' => 'home']));
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
