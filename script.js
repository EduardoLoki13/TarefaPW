// script.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.vote-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = btn.getAttribute('data-id');
        const val = btn.getAttribute('data-val');
  
        // enviar via fetch
        fetch('vote.php', {
          method: 'POST',
          headers: {'Content-Type':'application/x-www-form-urlencoded'},
          body: `id_noticia=${encodeURIComponent(id)}&util=${encodeURIComponent(val)}`
        })
        .then(r => r.json())
        .then(j => {
          const area = document.getElementById('vote-msg');
          if (j.status === 'ok') {
            area.innerText = 'Obrigado pelo voto!';
            // recarregar estatísticas (simples: recarrega a página)
            setTimeout(() => location.reload(), 800);
          } else {
            area.innerText = j.msg || 'Erro';
          }
        })
        .catch(()=> {
          document.getElementById('vote-msg').innerText = 'Erro de conexão';
        });
      });
    });
  });
  