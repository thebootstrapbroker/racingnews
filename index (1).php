 <?php
require __DIR__.'/../src/lib/bootstrap.php';
Auth::requireRole('writer');
$u = Auth::user();
$posts = DB::pdo()->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$pend  = DB::pdo()->query("SELECT COUNT(*) FROM comments WHERE status='pending'")->fetchColumn();
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Admin</title></head><body>
<div class="wrap">
  <h1>Admin Paneli</h1>
  <nav class="admin-nav">
    <a href="/admin/posts.php">Yazılar</a>
    <a href="/admin/comments.php">Yorumlar</a>
    <a href="/admin/users.php">Kullanıcılar</a>
    <a href="/admin/logout.php">Çıkış</a>
  </nav>
  <div class="card pad"><b>Merhaba, <?= e($u['name']) ?></b> — Toplam yazı: <?= (int)$posts ?> • Bekleyen yorum: <?= (int)$pend ?></div>
</div>
</body></html>