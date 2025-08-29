 <?php
$slug = $_GET['slug'] ?? '';
$st = DB::pdo()->prepare('SELECT * FROM posts WHERE slug=? AND status="published"');
$st->execute([$slug]);
$post=$st->fetch();
if(!$post){ echo '<p>Yazı bulunamadı.</p>'; return; }
?>
<article class="article card">
  <img class="thumb" src="<?= e($post['hero'] ?: '/assets/placeholder.jpg') ?>" alt="">
  <div class="pad">
    <h1><?= e($post['title']) ?></h1>
    <div class="meta">Kategori: <?= e($post['category']) ?> • Yayın: <?= e($post['publish_at']) ?></div>
    <div class="body"><?= nl2br(e($post['body'])) ?></div>
  </div>
</article>