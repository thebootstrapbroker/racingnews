 <?php
$json = file_get_contents(__DIR__.'/../../public/assets/races_2025_ist.json');
$races = json_decode($json,true);
?>
<h1>2025 Takvim</h1>
<div class="grid">
<?php foreach($races as $r): ?>
  <article class="card">
    <div class="pad">
      <div class="badge"><?= e($r['name']) ?></div>
      <h3 class="title" style="font-size:1.1rem"><?= e($r['city'].', '.$r['country']) ?></h3>
      <p class="excerpt"><?= e((new DateTime($r['isoIST']))->format('d M Y H:i')) ?> IST</p>
      <a class="btn gray" href="<?= url('yarislar/gp') ?>&slug=<?= e($r['slug']) ?>">GP sayfası →</a>
    </div>
  </article>
<?php endforeach; ?>
</div>