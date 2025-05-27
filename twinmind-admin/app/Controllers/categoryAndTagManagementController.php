<?php

namespace App\Controllers;

use Core\View;

class categoryAndTagManagementController {

    public function index() {
        global $conn;
        $mainCategories = $this->getMainCategories();

        View::render('categoryAndTagManagement/index', [
            'Title' => 'Kategori Yönetimi',
            'mainCategories' => $mainCategories,
            'conn' => $conn
        ]);
    }

    public function getMainCategories() {
        global $conn;

        // Önce ana kategorileri al (parent_id NULL olanlar)
        $query = "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name";
        $result = mysqli_query($conn, $query);
        $mainCategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Sonra alt kategorileri al
        $query = "SELECT * FROM categories WHERE parent_id IS NOT NULL ORDER BY parent_id, name";
        $result = mysqli_query($conn, $query);
        $subCategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Tüm kategorileri birleştir
        return array_merge($mainCategories, $subCategories);
    }

    public function getSubCategories($parentId) {
        global $conn;

        $parentId = mysqli_real_escape_string($conn, $parentId);
        $query = "SELECT c.*, 
                    (SELECT COUNT(*) FROM categories WHERE parent_id = c.id) as has_children 
                 FROM categories c 
                 WHERE c.parent_id = '$parentId' 
                 ORDER BY c.name";
        $result = mysqli_query($conn, $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addCategory() {
        $mainCategories = $this->getMainCategories();

        View::render('categoryAndTagManagement/addCategory', [
            'Title' => 'Add Category',
            'mainCategories' => $mainCategories
        ]);
    }

    public function saveCategory() {
        global $conn;

        try {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';

            // Handle parent category selection
            $parentId = !empty($_POST['parent_id']) ? mysqli_real_escape_string($conn, $_POST['parent_id']) : null;

            // Validate input
            if (empty($name)) {
                $_SESSION['error'] = "Category name is required";
                header('Location: /category-management/add');
                exit;
            }

            // Check if category name already exists
            $checkQuery = "SELECT id FROM categories WHERE name = '$name'";
            $checkResult = mysqli_query($conn, $checkQuery);
            if (mysqli_num_rows($checkResult) > 0) {
                $_SESSION['error'] = "A category with this name already exists";
                header('Location: /category-management/add');
                exit;
            }

            // Insert new category
            $query = "INSERT INTO categories (name, description, parent_id) VALUES ('$name', '$description', " .
                ($parentId ? "'$parentId'" : "NULL") . ")";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Category added successfully";
                header('Location: /category-management');
                exit;
            } else {
                $_SESSION['error'] = "Error adding category: " . mysqli_error($conn);
                header('Location: /category-management/add');
                exit;
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header('Location: /category-management/add');
            exit;
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
            'Title' => 'Edit Category',
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

            // Handle parent category selection
            $parentId = null;
            if (!empty($_POST['parent_id'])) {
                $parentId = mysqli_real_escape_string($conn, $_POST['parent_id']);
            }

            // Prevent circular references
            if ($parentId == $id) {
                $_SESSION['error'] = "A category cannot be its own parent";
                header('Location: /category-management/edit/' . $id);
                exit;
            }

            // Check if the selected parent is not a descendant of the current category
            if ($parentId) {
                $isDescendant = $this->isDescendant($id, $parentId);
                if ($isDescendant) {
                    $_SESSION['error'] = "Cannot set a descendant category as parent";
                    header('Location: /category-management/edit/' . $id);
                    exit;
                }
            }

            // Update the category
            $query = "UPDATE categories SET name = '$name', description = '$description', parent_id = " .
                ($parentId ? "'$parentId'" : "NULL") . " WHERE id = '$id'";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Category updated successfully";
                header('Location: /category-management');
                exit;
            } else {
                $_SESSION['error'] = "Error updating category: " . mysqli_error($conn);
                header('Location: /category-management/edit/' . $id);
                exit;
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header('Location: /category-management/edit/' . $id);
            exit;
        }
    }

    // Helper function to check if a category is a descendant of another
    private function isDescendant($categoryId, $potentialParentId) {
        global $conn;

        $currentId = $potentialParentId;
        while ($currentId) {
            if ($currentId == $categoryId) {
                return true;
            }

            $query = "SELECT parent_id FROM categories WHERE id = '$currentId'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            if (!$row || !$row['parent_id']) {
                break;
            }

            $currentId = $row['parent_id'];
        }

        return false;
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

    public function getCategoryPath() {
        global $conn;

        $categoryId = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;
        $path = [];

        // Get the current category
        $query = "SELECT id, name, parent_id FROM categories WHERE id = '$categoryId'";
        $result = mysqli_query($conn, $query);
        $category = mysqli_fetch_assoc($result);

        if ($category) {
            // Add current category to path
            $path[] = ['id' => $category['id'], 'name' => $category['name']];

            // Get parent categories
            $currentId = $category['parent_id'];
            while ($currentId) {
                $query = "SELECT id, name, parent_id FROM categories WHERE id = '$currentId'";
                $result = mysqli_query($conn, $query);
                $parent = mysqli_fetch_assoc($result);

                if ($parent) {
                    array_unshift($path, ['id' => $parent['id'], 'name' => $parent['name']]);
                    $currentId = $parent['parent_id'];
                } else {
                    break;
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($path);
        exit;
    }
}
