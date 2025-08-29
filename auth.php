 <?php
final class Auth {
  public static function user(): ?array { return $_SESSION['u'] ?? null; }
  public static function login(string $email,string $pass): bool {
    $st=DB::pdo()->prepare('SELECT * FROM users WHERE email=?'); $st->execute([$email]);
    $u=$st->fetch(); if($u && password_verify($pass,$u['pass'])){ $_SESSION['u']=$u; return true; }
    return false;
  }
  public static function logout(): void { unset($_SESSION['u']); }
  public static function requireRole(string $role='editor'): void {
    $u=self::user(); if(!$u) { header('Location: /admin/login.php'); exit; }
    $levels=['member'=>0,'writer'=>1,'moderator'=>2,'editor'=>3,'admin'=>4];
    $need=$levels[$role]??0; $has=$levels[$u['role']]??0; if($has<$need){ http_response_code(403); echo 'Forbidden'; exit; }
  }
}