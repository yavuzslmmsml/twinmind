<?php
// Session'ı başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Veritabanı bağlantı bilgileri
$host = "localhost";      // IP adresi ya da alan adı (örnek: 192.168.1.100 ya da db.example.com)
$user = "root";         // Veritabanı kullanıcı adı
$password = "root-password";     // Şifre
$database = "twinmind";     // Veritabanı adı
// $port = 3306;                    // Port (varsayılan: 3306)

// Bağlantı oluştur
$conn = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($conn, "utf8mb4");
$return = false;
// Bağlantıyı kontrol et
if (!$conn) {
    $return = json_encode(['status' => false, 'message' => 'baglanamadi ' . mysqli_connect_error() . '']);
} else {
    $return = json_encode(['status' => true, 'message' => 'baglanti basarili']);
}

return $return;


// Bağlantı başarılıysa mesaj ver


// Bağlantıyı kapatmak istersen:
// mysqli_close($conn);