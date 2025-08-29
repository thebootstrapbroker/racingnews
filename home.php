 <?php
$pdo = DB::pdo();
$hero = $pdo->query("SELECT * FROM posts WHERE status='published' ORDER BY publish_at DESC LIMIT 1")->fetch();
$posts = $pdo->query("SELECT * FROM posts WHERE status='published' ORDER BY publish_at DESC LIMIT 7 OFFSET 1")->fetchAll();
?>
<section class="hero-grid">
  <article class="card" style="grid-row: span 2">
    <a href="<?= $hero? post_url($hero):'#' ?>">
      <img class="thumb" src="<?= e($hero['hero'] ?? '/assets/placeholder.jpg') ?>" alt="">
    </a>
    <div class="pad">
      <div class="badge">GÜNDEM</div>
      <h2 class="title"><?= e($hero['title'] ?? 'Başlamak için bir yazı ekleyin') ?></h2>
      <p class="excerpt"><?= e($hero['excerpt'] ?? 'Admin panelinden yazı oluşturup yayınlayın.') ?></p>
      <?php if($hero): ?><a class="btn" href="<?= post_url($hero) ?>">devamını gör →</a><?php endif; ?>
    </div>
  </article>
  <div class="grid">
  <?php foreach ($posts as $p): ?>
    <article class="card">
      <a href="<?= post_url($p) ?>">
        <img class="thumb" src="<?= e($p['hero'] ?: '/assets/placeholder.jpg') ?>" alt="">
      </a>
      <div class="pad">
        <div class="badge" style="background:var(--g9)"><?= strtoupper(e($p['category'])) ?></div>
        <h3 class="title" style="font-size:1.05rem"><a href="<?= post_url($p) ?>" style="color:#fff;text-decoration:none"><?= e($p['title']) ?></a></h3>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</section>

<section class="card pad gp-countdown" style="padding:14px">
  <strong>Sonraki Yarış:</strong> <span data-name>—</span>
  <div style="display:flex;gap:12px;margin-top:8px">
    <div class="badge"><span data-dd>--</span> GÜN</div>
    <div class="badge" style="background:#3a3a3a"><span data-hh>--</span>:<span data-mm>--</span>:<span data-ss>--</span></div>
  </div>
</section>