 <?php
$slug = $_GET['slug'] ?? '';
$races = json_decode(file_get_contents(__DIR__.'/../../public/assets/races_2025_ist.json'), true);
$race = null; foreach($races as $r){ if($r['slug']===$slug){ $race=$r; break; } }
if(!$race){ echo '<p>Yarış bulunamadı.</p>'; return; }
?>
<article class="card pad">
  <h1><?= e($race['name']) ?> — <?= e($race['city']) ?>, <?= e($race['country']) ?></h1>
  <p>Tarih: <strong><?= e((new DateTime($race['isoIST']))->format('d M Y H:i')) ?> IST</strong></p>
  <div class="gp-countdown" style="margin-top:10px">
    <strong>Geri Sayım:</strong>
    <div style="display:flex;gap:12px;margin-top:8px">
      <div class="badge"><span data-dd>--</span> GÜN</div>
      <div class="badge" style="background:#3a3a3a"><span data-hh>--</span>:<span data-mm>--</span>:<span data-ss>--</span></div>
    </div>
  </div>
  <script>window.addEventListener('DOMContentLoaded',()=>{fetch('/assets/races_2025_ist.json').then(r=>r.json()).then(rs=>{const r=rs.find(x=>x.slug==='<?= e($slug) ?>');if(!r)return;const t=Date.parse(r.isoIST);const w=document.currentScript.previousElementSibling;function tick(){const d=Math.max(0,t-Date.now());const D=Math.floor(d/86400000),H=Math.floor(d%86400000/3600000),M=Math.floor(d%3600000/60000),S=Math.floor(d%60000/1000);w.querySelector('[data-dd]').textContent=String(D).padStart(2,'0');w.querySelector('[data-hh]').textContent=String(H).padStart(2,'0');w.querySelector('[data-mm]').textContent=String(M).padStart(2,'0');w.querySelector('[data-ss]').textContent=String(S).padStart(2,'0');}tick();setInterval(tick,1000);});});</script>
</article>