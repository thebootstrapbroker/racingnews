 <?php
$pdo=DB::pdo();
$cat = $_GET['kategori'] ?? null;
if($cat){ $st=$pdo->prepare("SELECT * FROM posts WHERE status='published' AND category=? ORDER BY publish_at DESC"); $st->execute([$cat]); $posts=$st->fetchAll(); }
else { $posts=$pdo->query("SELECT * FROM posts WHERE status='published' ORDER BY publish_at DESC")->fetchAll(); }
?>
<h1>Haberler<?= $cat? ' — '.e(strtoupper($cat)) : '' ?></h1>
<div class="grid">
<?php foreach($posts as $p): ?>
  <article class="card">
    <a href="<?= post_url($p) ?>"><img class="thumb" src="<?= e($p['hero'] ?: '/assets/placeholder.jpg') ?>" alt=""></a>
    <div class="pad">
      <div class="badge" style="background:#3a3a3a"><?= strtoupper(e($p['category'])) ?></div>
      <h3 class="title" style="font-size:1.1rem"><a href="<?= post_url($p) ?>" style="color:#fff;text-decoration:none"><?= e($p['title']) ?></a></h3>
      <p class="excerpt"><?= e($p['excerpt']) ?></p>
    </div>
  </article>
<?php endforeach; ?>
</div>