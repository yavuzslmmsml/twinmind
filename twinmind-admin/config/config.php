<?php
// $mysql = mysqli_connect('104.247.167.187', 'talhabekci_yavuzslm', 'T@RCCcdEfYwS', 'talhabekci_twinmind', 3306);
// $mysql = mysqli_connect('localhost', 'root', 'root-password', 'twin_mind_db', 3306);
// if (!$mysql) {
//     exit(json_encode(['Status' => false, 'Message' => 'An error occurred while connecting database' . mysqli_connect_error()]));
// }

// $result = mysqli_query($mysql, "SELECT * FROM `users`");
// exit(json_encode($result));

$mysql = mysqli_connect('localhost', 'root', 'root-password', 'twin_mind_db', 3306);
if (!$mysql) {
    exit(json_encode(['Status' => false, 'Message' => 'An error occurred while connecting database: ' . mysqli_connect_error()]));
}

$result = mysqli_query($mysql, "SELECT * FROM `users`");

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    exit(json_encode(['Status' => true, 'Data' => $data]));
} else {
    exit(json_encode(['Status' => false, 'Message' => 'Query failed: ' . mysqli_error($mysql)]));
}