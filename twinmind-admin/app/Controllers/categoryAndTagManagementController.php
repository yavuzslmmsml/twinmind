<?php

namespace App\Controllers;

use Core\View;

class categoryAndTagManagementController {

    public function index() {
        $mainCategories = $this->getMainCategories();

        View::render('categoryAndTagManagement/index', [
            'Title' => 'Kategori Yönetimi',
            'mainCategories' => $mainCategories
        ]);
    }

    public function getMainCategories() {
        global $conn;

        $query = "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name";
        $result = mysqli_query($conn, $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getSubCategories($parentId) {
        global $conn;

        $parentId = mysqli_real_escape_string($conn, $parentId);
        $query = "SELECT * FROM categories WHERE parent_id = '$parentId' ORDER BY name";
        $result = mysqli_query($conn, $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addCategory() {
        $mainCategories = $this->getMainCategories();

        View::render('categoryAndTagManagement/addCategory', [
            'Title' => 'Kategori Ekle',
            'mainCategories' => $mainCategories
        ]);
    }

    public function saveCategory() {
        global $conn;

        try {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
            $parentId = !empty($_POST['parent_id']) ? mysqli_real_escape_string($conn, $_POST['parent_id']) : 'NULL';

            if ($parentId !== 'NULL') {
                $query = "INSERT INTO categories (name, description, parent_id) VALUES ('$name', '$description', '$parentId')";
            } else {
                $query = "INSERT INTO categories (name, description, parent_id) VALUES ('$name', '$description', NULL)";
            }

            if (mysqli_query($conn, $query)) {
                header('Location: /category-management');
                exit;
            } else {
                echo "Hata: " . mysqli_error($conn);
            }
        } catch (\Exception $e) {
            echo "Hata: " . $e->getMessage();
        }
    }

    public function editCategory($id) {
        global $conn;

        $id = mysqli_real_escape_string($conn, $id);
        $query = "SELECT * FROM categories WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $category = mysqli_fetch_assoc($result);

        $mainCategories = $this->getMainCategories();

        View::render('categoryAndTagManagement/editCategory', [
            'Title' => 'Kategori Düzenle',
            'category' => $category,
            'mainCategories' => $mainCategories
        ]);
    }

    public function updateCategory() {
        global $conn;

        try {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
            $parentId = !empty($_POST['parent_id']) ? mysqli_real_escape_string($conn, $_POST['parent_id']) : 'NULL';

            if ($parentId !== 'NULL') {
                $query = "UPDATE categories SET name = '$name', description = '$description', parent_id = '$parentId' WHERE id = '$id'";
            } else {
                $query = "UPDATE categories SET name = '$name', description = '$description', parent_id = NULL WHERE id = '$id'";
            }

            if (mysqli_query($conn, $query)) {
                header('Location: /category-management');
                exit;
            } else {
                echo "Hata: " . mysqli_error($conn);
            }
        } catch (\Exception $e) {
            echo "Hata: " . $e->getMessage();
        }
    }

    public function deleteCategory($id) {
        global $conn;

        try {
            $id = mysqli_real_escape_string($conn, $id);

            // İlgili kategorinin altındaki tüm kategorileri de sil (cascade)
            $query = "DELETE FROM categories WHERE id = '$id' OR parent_id = '$id'";

            if (mysqli_query($conn, $query)) {
                header('Location: /category-management');
                exit;
            } else {
                echo "Hata: " . mysqli_error($conn);
            }
        } catch (\Exception $e) {
            echo "Hata: " . $e->getMessage();
        }
    }

    public function getSubCategoriesJson() {
        global $conn;

        $parentId = isset($_GET['parent_id']) ? mysqli_real_escape_string($conn, $_GET['parent_id']) : 0;
        $subCategories = $this->getSubCategories($parentId);

        header('Content-Type: application/json');
        echo json_encode($subCategories);
        exit;
    }
}
