 <?php
require __DIR__.'/../src/lib/bootstrap.php';
Auth::requireRole('writer');
$pdo=DB::pdo(); $id=(int)($_GET['id'] ?? 0);
$post = ['title'=>'','slug'=>'','excerpt'=>'','body'=>'','status'=>'draft','lang'=>'tr','category'=>'formula-1','hero'=>'','publish_at'=>date('Y-m-d H:i')];
if($id){ $st=$pdo->prepare('SELECT * FROM posts WHERE id=?'); $st->execute([$id]); $post=$st->fetch() ?: $post; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  $d = $_POST; if(!$d['slug']) $d['slug']=slugify($d['title']);
  if($id){
    $st=$pdo->prepare('UPDATE posts SET title=?, slug=?, excerpt=?, body=?, status=?, lang=?, category=?, hero=?, publish_at=?, updated_at=CURRENT_TIMESTAMP WHERE id=?');
    $st->execute([$d['title'],$d['slug'],$d['excerpt'],$d['body'],$d['status'],$d['lang'],$d['category'],$d['hero'],$d['publish_at'],$id]);
  } else {
    $st=$pdo->prepare('INSERT INTO posts(title,slug,excerpt,body,status,lang,category,hero,author_id,publish_at) VALUES(?,?,?,?,?,?,?,?,?,?)');
    $st->execute([$d['title'],$d['slug'],$d['excerpt'],$d['body'],$d['status'],$d['lang'],$d['category'],$d['hero'],Auth::user()['id']??null,$d['publish_at']]);
    $id = (int)$pdo->lastInsertId();
  }
  header('Location: /admin/posts.php'); exit;
}
?>
<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="/assets/style.css"><title>Yazı Düzenle</title></head><body>
<div class="wrap card pad">
  <h1><?= $id? 'Yazı Düzenle' : 'Yeni Yazı' ?></h1>
  <form class="form" method="post">
    <label>Başlık<input name="title" value="<?= e($post['title']) ?>" required></label>
    <label>Slug<input name="slug" value="<?= e($post['slug']) ?>" placeholder="otomatik"></label>
    <div class="row">
      <label>Kategori<select name="category"><option value="formula-1"<?= $post['category']=='formula-1'?' selected':'' ?>>Formula 1</option><option value="teknik"<?= $post['category']=='teknik'?' selected':'' ?>>Teknik</option><option value="analiz"<?= $post['category']=='analiz'?' selected':'' ?>>Analiz</option></select></label>
      <label>Durum<select name="status"><option value="draft"<?= $post['status']=='draft'?' selected':'' ?>>Taslak</option><option value="scheduled"<?= $post['status']=='scheduled'?' selected':'' ?>>Zamanlı</option><option value="published"<?= $post['status']=='published'?' selected':'' ?>>Yayında</option></select></label>
    </div>
    <label>Kısa Özet<textarea name="excerpt" rows="2"><?= e($post['excerpt']) ?></textarea></label>
    <label>Kapak Görseli URL<input name="hero" value="<?= e($post['hero']) ?>" placeholder="https://..."></label>
    <label>İçerik<textarea name="body" rows="10"><?= e($post['body']) ?></textarea></label>
    <label>Yayın Zamanı<input type="datetime-local" name="publish_at" value="<?= e(str_replace(' ','T',$post['publish_at']??'')) ?>"></label>
    <button class="btn" type="submit">Kaydet</button>
  </form>
</div>
</body></html>
