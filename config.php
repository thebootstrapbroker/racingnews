 <?php
return [
  'site_name' => 'RacingNewsTR',
  'base_url'  => '', // örn. 'https://racingnews.infinityfree.me'
  'timezone'  => 'Europe/Istanbul',
  'session'   => 'rntr_sess',
  'brand_red' => '#FE0000',

  // === MySQL ===
  'db' => [
    'driver' => 'mysql',
    'host'   => 'sql100.infinityfree.com',     // sunucu adı/IP
    'port'   => 3306,            // farklıysa değiştir
    'name'   => 'if0_39707124_racingnews',    // veritabanı adı
    'user'   => 'if0_39707124',   // kullanıcı
    'pass'   => 'Emre21224',   // şifre
    'charset'=> 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
  ],
];