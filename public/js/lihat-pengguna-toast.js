(function(){
    function show(msg){
        var toast = document.getElementById('localhost-toast');
        var msgEl = document.getElementById('localhost-toast-msg');
        var box = document.getElementById('localhost-toast-box');
        if (!toast || !msgEl) return;
        msgEl.textContent = msg;
        // Use success style only for 'added' messages (caller decides)
        if (msg && msg.toLowerCase().indexOf('berhasil ditambah') !== -1 && box) box.classList.add('success');
        setTimeout(function(){ toast.style.top = '12px'; }, 20);
        setTimeout(function(){
            toast.style.top = '-180px';
            if (box) box.classList.remove('success');
            try {
                var u = new URL(window.location.href);
                u.searchParams.delete('status');
                u.searchParams.delete('role');
                history.replaceState(null, '', u.pathname + u.search);
            } catch (e) {}
            window.__localToastShown = true;
        }, 4200);
    }

    var urlParams = new URLSearchParams(window.location.search);
    var status = urlParams.get('status');
    var role = urlParams.get('role');

    if (status === 'deleted') {
        var mdel = 'Pengguna berhasil dihapus.';
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show(mdel); }); else show(mdel);
    } else if (status === 'added') {
        var madd = 'Pengguna berhasil ditambahkan.';
        if (role === 'pasien') madd = 'Pasien berhasil ditambahkan.';
        else if (role === 'dokter') madd = 'Dokter berhasil ditambahkan.';
        else if (role === 'admin') madd = 'Admin berhasil ditambahkan.';
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show(madd); }); else show(madd);
    } else if (status === 'updated') {
        var mupd = 'Pengguna berhasil diperbarui.';
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show(mupd); }); else show(mupd);
    }
})();