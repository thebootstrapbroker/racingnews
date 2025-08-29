 // Simple helpers
const $$ = (sel,ctx=document)=>Array.from(ctx.querySelectorAll(sel));

// GP countdown widget example (if a .gp-countdown exists)
(async function(){
  const widget = document.querySelector('.gp-countdown');
  if(!widget) return;
  const res = await fetch('/assets/races_2025_ist.json');
  const races = await res.json();
  const now = Date.now();
  const next = races.find(r=> Date.parse(r.isoIST) > now);
  if(!next) return;
  const name = next.name;
  const t   = Date.parse(next.isoIST);
  function tick(){
    const diff = Math.max(0,t - Date.now());
    const d = Math.floor(diff/86400000);
    const h = Math.floor((diff%86400000)/3600000);
    const m = Math.floor((diff%3600000)/60000);
    const s = Math.floor((diff%60000)/1000);
    widget.querySelector('[data-name]').textContent = name;
    widget.querySelector('[data-dd]').textContent = String(d).padStart(2,'0');
    widget.querySelector('[data-hh]').textContent = String(h).padStart(2,'0');
    widget.querySelector('[data-mm]').textContent = String(m).padStart(2,'0');
    widget.querySelector('[data-ss]').textContent = String(s).padStart(2,'0');
  }
  tick(); setInterval(tick,1000);
})();
