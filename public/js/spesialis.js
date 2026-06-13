(function(){
    function show(msg, kind){
        var toast = document.getElementById('localhost-toast');
        var msgEl = document.getElementById('localhost-toast-msg');
        var box = document.getElementById('localhost-toast-box');
        if (!toast || !msgEl) return;
        msgEl.textContent = msg;
        if (box && kind === 'success') box.classList.add('success');
        setTimeout(function(){ toast.style.top = '12px'; }, 20);
        setTimeout(function(){
            toast.style.top = '-180px';
            if (box) box.classList.remove('success');
            try {
                var u = new URL(window.location.href);
                u.searchParams.delete('status');
                history.replaceState(null, '', u.pathname + u.search);
            } catch (e) {}
        }, 4200);
    }

    var meta = document.getElementById('page-meta');
    var status = meta ? meta.getAttribute('data-status') : '';
    if (!status) {
        var urlParams = new URLSearchParams(window.location.search);
        status = urlParams.get('status') || '';
    }

    if (status === 'added') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show('Spesialis berhasil ditambahkan.', 'success'); });
        else show('Spesialis berhasil ditambahkan.', 'success');
    } else if (status === 'deleted') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show('Spesialis berhasil dihapus.'); });
        else show('Spesialis berhasil dihapus.');
    } else if (status === 'updated') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show('Spesialis berhasil diperbarui.'); });
        else show('Spesialis berhasil diperbarui.');
    } else if (status === 'blocked') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ show('Tidak dapat menghapus: masih ada dokter di spesialis ini.'); });
        else show('Tidak dapat menghapus: masih ada dokter di spesialis ini.');
    }
})();