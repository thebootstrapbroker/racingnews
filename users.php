 <?php
require __DIR__.'/../src/lib/bootstrap.php';
Auth::requireRole('admin');
$pdo=DB::pdo();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $st=$pdo->prepare('INSERT INTO users(name,email,pass,role) VALUES(?,?,?,?)');
  $st->execute([$_POST['name'],$_POST['email'], password_hash($_POST['pass'], PASSWORD_DEFAULT), $_POST['role']]);
}
$rows=$pdo->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Kullanıcılar</title></head><body>
<div class="wrap">
  <h1>Kullanıcılar</h1>
  <div class="card pad">
    <h3>Yeni Üye/Yazar Ekle</h3>
    <form class="form" method="post">
      <div class="row">
        <label>Ad Soyad<input name="name" required></label>
        <label>E-posta<input name="email" required></label>
      </div>
      <div class="row">
        <label>Şifre<input type="password" name="pass" required></label>
        <label>Rol<select name="role"><option value="writer">Writer</option><option value="editor">Editor</option><option value="moderator">Moderator</option><option value="admin">Admin</option></select></label>
      </div>
      <button class="btn" type="submit">Ekle</button>
    </form>
  </div>
  <table class="table" style="margin-top:16px"><thead><tr><th>Ad</th><th>E-posta</th><th>Rol</th><th>Katıldı</th></tr></thead><tbody>
  <?php foreach($rows as $u): ?>
    <tr><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['role']) ?></td><td><?= e($u['created_at']) ?></td></tr>
  <?php endforeach; ?></tbody></table>
</div>
</body></html>