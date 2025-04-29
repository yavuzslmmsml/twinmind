<?php
// Veritabanı bağlantı bilgileri
$host = "104.247.167.187";      // IP adresi ya da alan adı (örnek: 192.168.1.100 ya da db.example.com)
$user = "talhabekci_yavuzslm";         // Veritabanı kullanıcı adı
$password = "T@RCCcdEfYwS";     // Şifre
$database = "talhabekci_twinmind";     // Veritabanı adı
$port = 3306;                    // Port (varsayılan: 3306)

// Bağlantı oluştur
$conn = mysqli_connect($host, $user, $password, $database, $port);
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