 <?php
// HATA GÖSTER (canlıda kapatılır)
ini_set('display_errors','1'); ini_set('display_startup_errors','1'); error_reporting(E_ALL);

declare(strict_types=1);

// Bu dosya H T D O C S kökünde. src'ye göre yollar:
$config = require __DIR__.'/src/config.php';
require __DIR__.'/src/lib/bootstrap.php';

// Basit router: ?p=...
$p = trim($_GET['p'] ?? '', '/');

// admin kısayolu
if ($p === 'admin') { header('Location: /admin/'); exit; }

$routes = [
  '' => 'home',
  'haber' => 'news',
  'yazi' => 'post',
  'yarislar/takvim' => 'calendar',
  'yarislar/gp' => 'gp',
  'sonuclar' => 'standings',
  'pilotlar' => 'drivers',
  'takimlar' => 'teams',
  'hakkimizda' => 'about',
  'iletisim' => 'contact',
  'arama' => 'search',
];

$page = $routes[$p] ?? '404';

// DB varsa-yoksa açılışta çökmemek için küçük kontrol
try { DB::pdo()->query("SELECT 1"); } 
catch (Throwable $e) { $GLOBALS['__RNTR_DB_ERROR__'] = $e->getMessage(); }

ob_start();
$viewPath = __DIR__ . "/src/pages/{$page}.php";
if (!is_file($viewPath)) {
  http_response_code(404);
  $viewPath = __DIR__.'/src/pages/404.php';
}
include $viewPath;
$content = ob_get_clean();

include __DIR__.'/src/partials/layout.php';