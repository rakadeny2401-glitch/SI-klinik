(function(){
    function show(){
        var toast = document.getElementById('localhost-toast');
        var msgEl = document.getElementById('localhost-toast-msg');
        if (!toast || !msgEl) return;
        var params = new URLSearchParams(window.location.search);
        var role = params.get('role');
        var msg = 'Pengguna berhasil ditambahkan.';
        if (role === 'pasien') msg = 'Pasien berhasil ditambahkan.';
        else if (role === 'dokter') msg = 'Dokter berhasil ditambahkan.';
        else if (role === 'admin') msg = 'Admin berhasil ditambahkan.';
        msgEl.textContent = msg;
        var box = document.getElementById('localhost-toast-box');
        if (box) box.classList.add('success');
        setTimeout(function(){ toast.style.top = '12px'; }, 20);
        setTimeout(function(){
            toast.style.top = '-180px';
            if (box) box.classList.remove('success');
            try { var u = new URL(window.location.href); u.searchParams.delete('status'); u.searchParams.delete('role'); history.replaceState(null, '', u.pathname + u.search); } catch (e) {}
            window.__localToastShown = true;
        }, 4200);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', show); else show();
})();