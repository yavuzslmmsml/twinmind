<?php
require_once '../../config/database.php';
require_once '../../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    // Validate input
    if (empty($name)) {
        $_SESSION['error'] = "Category name is required";
        header("Location: manageCourseCategory.php");
        exit;
    }

    // Check if category name already exists
    $stmt = $conn->prepare("SELECT id FROM course_categories WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "A category with this name already exists";
        header("Location: manageCourseCategory.php");
        exit;
    }

    // Insert new category
    $stmt = $conn->prepare("INSERT INTO course_categories (name, parent_id, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $parent_id, $description, $status);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Category added successfully";
    } else {
        $_SESSION['error'] = "Error adding category: " . $conn->error;
    }

    header("Location: manageCourseCategory.php");
    exit;
} else {
    header("Location: manageCourseCategory.php");
    exit;
} 