 <?php
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES,'UTF-8'); }
function slugify(string $t): string {
  $t=iconv('UTF-8','ASCII//TRANSLIT',$t);
  $t=strtolower($t); $t=preg_replace('/[^a-z0-9]+/','-',$t); return trim($t,'-');
}
function url(string $p=''): string { return '/?p='.ltrim($p,'/'); }
function post_url(array $p): string { return '/?p=yazi&slug='.e($p['slug']); }