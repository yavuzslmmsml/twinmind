<?php

namespace App\Controllers;

use Core\View;

class MessagesController {

    public function index() {

        $test = "sifre";
        View::render('messages/index', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }

    public function reply() {

        $test = "sifre";
        View::render('messages/reply', [
            'Title' => 'All Courses',
            'ProfileDetails' => $test
        ]);
    }
     public function systemMessages() {
         global $conn;

         $query = "SELECT * FROM system_messages";

        $result = mysqli_query($conn, $query);

        $test = "sifre";
        View::render('messages/systemMessages', [
            'Title' => 'All Courses',
            'Result' => $result
        ]);
        
    

}
    public function AddSystemMessage() {
         global $conn;
        $Errors = [];

        if (!isset($_POST['recipient_role']) || empty($_POST['recipient_role'])) {
            $Errors['recipient_role'][] = 'Recipient Role field is required';
        }

        if (!isset($_POST['title']) || empty($_POST['title'])) {
            $Errors['title'][] = 'Title field is required';
        }

        if (!isset($_POST['message']) || empty($_POST['message'])) {
            $Errors['message'][] = 'Message field is required';
        }

       // Prepare the data for insertion
       
        $recipient_role = mysqli_real_escape_string($conn, $_POST['recipient_role']);
 
        if (!in_array($recipient_role, [1, 2, 3, 4])) {
            $Errors['recipient_role'][] = 'an error occurred';
        }
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);



        $sql = "INSERT INTO system_messages (recipient_role, title, message, sent_at) 
                VALUES ('$recipient_role', '$title', '$message', NOW())";

        if (mysqli_query($conn, $sql)) {
            exit(json_encode(['status' => true, 'message' => 'Message successfully sent!', 'redirect' => 'messages/systemMessages']));
        } else {
            exit(json_encode(['status' => false, 'errors' => ['general' => ['systemMEssage failed. Please try again.']]]));
        }
    

}
}
