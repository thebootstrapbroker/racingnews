 <?php
// Geliştirme için hata görünür (canlıda kapatabilirsin)
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

$config = $config ?? require __DIR__ . '/../config.php';

date_default_timezone_set($config['timezone'] ?? 'Europe/Istanbul');
session_name($config['session'] ?? 'rntr_sess');
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

// *** ÖNEMLİ: MySQL modunda parametresiz init ***
DB::init();