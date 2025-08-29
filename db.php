 <?php
final class DB {
  private static ?\PDO $pdo = null;

  // MySQL için parametresiz init
  public static function init(): void {
    if (self::$pdo) return;

    $cfgAll = require __DIR__ . '/../config.php';
    $cfg = $cfgAll['db'] ?? null;

    if (!$cfg || ($cfg['driver'] ?? '') !== 'mysql') {
      throw new \RuntimeException('MySQL konfigürasyonu eksik (src/config.php → db)');
    }

    $dsn = sprintf(
      'mysql:host=%s;port=%d;dbname=%s;charset=%s',
      $cfg['host'],
      (int)($cfg['port'] ?? 3306),
      $cfg['name'],
      $cfg['charset'] ?? 'utf8mb4'
    );

    try {
      self::$pdo = new \PDO($dsn, $cfg['user'], $cfg['pass'], [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$cfg['charset']} COLLATE {$cfg['collation']}"
      ]);
      self::migrate();
    } catch (\Throwable $e) {
      throw new \RuntimeException('MySQL bağlantısı kurulamadı: ' . $e->getMessage());
    }
  }

  public static function pdo(): \PDO {
    if (!self::$pdo) throw new \RuntimeException('DB init edilmedi');
    return self::$pdo;
  }

  private static function migrate(): void {
    $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS users(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  pass VARCHAR(255) NOT NULL,
  role ENUM('member','writer','moderator','editor','admin') NOT NULL DEFAULT 'writer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(300) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  excerpt TEXT NULL,
  body MEDIUMTEXT NOT NULL,
  status ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
  lang ENUM('tr','en') NOT NULL DEFAULT 'tr',
  category VARCHAR(100) DEFAULT 'formula-1',
  hero VARCHAR(500) NULL,
  author_id INT UNSIGNED NULL,
  publish_at DATETIME NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_posts_author FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS comments(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id INT UNSIGNED NOT NULL,
  author VARCHAR(120) NULL,
  email  VARCHAR(190) NULL,
  content TEXT NOT NULL,
  status ENUM('pending','approved','rejected','spam') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_comments_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

    foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
      if ($stmt !== '') self::$pdo->exec($stmt);
    }

    // ilk admin kullanıcısı
    $cnt = (int) self::$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($cnt === 0) {
      $st = self::$pdo->prepare('INSERT INTO users(name,email,pass,role) VALUES(?,?,?,?)');
      $st->execute(['Admin','admin@local', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
    }
  }
}