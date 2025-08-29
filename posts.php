 <?php
require __DIR__.'/../src/lib/bootstrap.php';
Auth::requireRole('writer');
$pdo=DB::pdo();
if(isset($_GET['del'])){ $st=$pdo->prepare('DELETE FROM posts WHERE id=?'); $st->execute([ (int)$_GET['del'] ]); header('Location: /admin/posts.php'); exit; }
$rows=$pdo->query('SELECT p.*, u.name AS author FROM posts p LEFT JOIN users u ON p.author_id=u.id ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Yazılar</title></head><body>
<div class="wrap">
  <h1>Yazılar</h1>
  <nav class="admin-nav"><a href="/admin/post_edit.php">Yeni Yazı</a><a href="/admin/">Panel</a></nav>
  <table class="table"><thead><tr><th>Başlık</th><th>Durum</th><th>Yazar</th><th>Yayın</th><th></th></tr></thead><tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><a href="/admin/post_edit.php?id=<?= (int)$r['id'] ?>"><?= e($r['title']) ?></a></td>
      <td><?= e($r['status']) ?></td><td><?= e($r['author'] ?? '—') ?></td><td><?= e($r['publish_at'] ?? '—') ?></td>
      <td><a href="/admin/posts.php?del=<?= (int)$r['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a></td>
    </tr>
  <?php endforeach; ?></tbody></table>
</div></body></html>