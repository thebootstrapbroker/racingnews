 <?php
require __DIR__.'/../src/lib/bootstrap.php';
Auth::requireRole('moderator');
$pdo=DB::pdo();
if(isset($_GET['act'],$_GET['id'])){
  $act=$_GET['act']; $id=(int)$_GET['id'];
  if(in_array($act,['approve','reject','spam'])){
    $st=$pdo->prepare('UPDATE comments SET status=? WHERE id=?'); $st->execute([$act==='approve'?'approved':($act==='reject'?'rejected':'spam'),$id]);
  }
  header('Location:/admin/comments.php'); exit;
}
$rows=$pdo->query('SELECT c.*, p.title AS post FROM comments c LEFT JOIN posts p ON c.post_id=p.id ORDER BY c.created_at DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Yorumlar</title></head><body>
<div class="wrap">
  <h1>Yorumlar</h1>
  <table class="table"><thead><tr><th>Durum</th><th>Yorum</th><th>Yazı</th><th>Tarih</th><th></th></tr></thead><tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= e($r['status']) ?></td>
      <td><?= e($r['author'] . ' — ' . $r['content']) ?></td>
      <td><?= e($r['post'] ?? '—') ?></td>
      <td><?= e($r['created_at']) ?></td>
      <td>
        <a href="?act=approve&id=<?= (int)$r['id'] ?>">Onayla</a> ·
        <a href="?act=reject&id=<?= (int)$r['id'] ?>">Reddet</a> ·
        <a href="?act=spam&id=<?= (int)$r['id'] ?>">Spam</a>
      </td>
    </tr>
  <?php endforeach; ?></tbody></table>
</div>
</body></html>