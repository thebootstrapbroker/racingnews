 <?php
require __DIR__.'/../src/lib/bootstrap.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(Auth::login($_POST['email']??'', $_POST['pass']??'')) { header('Location: /admin/'); exit; }
  $err='Giriş başarısız';
}
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Admin Giriş</title></head><body>
<div class="wrap card pad">
  <h1>Admin Girişi</h1>
  <?php if(!empty($err)) echo '<p style="color:#FE0000">'.e($err).'</p>'; ?>
  <form class="form" method="post">
    <label>E-posta<input name="email" required></label>
    <label>Şifre<input type="password" name="pass" required></label>
    <button class="btn" type="submit">Giriş yap</button>
  </form>
</div>
</body></html>