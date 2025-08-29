 <?php $brand = $config['site_name']; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?= e($brand) ?></title>
  <link rel="stylesheet" href="/assets/style.css"/>
  <script>window.__RNTR__ = {brand:'<?= e($brand) ?>'};</script>
</head>
<body>
<header class="site-header">
  <div class="wrap nav">
    <a class="logo" href="/"><img src="/assets/logo.png" alt="<?= e($brand) ?>"/></a>
    <nav class="main-nav">
      <a href="<?= url('haber') ?>">FORMULA 1</a>
      <a href="#">WORLD SBK</a>
      <a href="#">MOTO GP</a>
      <a href="#">RALLI</a>
    </nav>
  </div>
</header>
<main class="wrap">
  <?= $content ?>
</main>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>© <?= date('Y') ?> RacingNewsTR</div>
    <div class="social"><a href="#">X</a> <a href="#">Instagram</a> <a href="#">YouTube</a></div>
  </div>
</footer>
<script src="/assets/site.js" defer></script>
</body>
</html>
