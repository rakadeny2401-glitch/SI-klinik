document.addEventListener('DOMContentLoaded', function(){
    function setup(idInput, idNote){
        var input = document.getElementById(idInput);
        var note = document.getElementById(idNote);
        if (!input || !note) return;
        input.addEventListener('focus', function(){ note.style.display = 'block'; });
        input.addEventListener('input', function(){
            if (input.value === '') {
                note.style.display = 'none';
            } else if (/^\d{6}$/.test(input.value)){
                note.style.color = '#28a745';
                note.textContent = 'PIN valid (6 digit)';
            } else {
                note.style.color = '#e67e22';
                note.textContent = 'PIN harus 6 digit angka';
            }
        });
        input.addEventListener('blur', function(){
            setTimeout(function(){ if (input.value === '' || /^\d{6}$/.test(input.value)) note.style.display = 'none'; }, 1500);
        });
    }

    setup('password-pasien','note-pasien');
    setup('password-admin','note-admin');
    setup('password-dokter','note-dokter');

    function restrictDigits(selector){
        var el = document.querySelector(selector);
        if (!el) return;
        el.addEventListener('input', function(){
            var pos = el.selectionStart;
            var cleaned = el.value.replace(/\D+/g, '');
            if (el.value !== cleaned){
                el.value = cleaned;
                try { el.setSelectionRange(pos-1,pos-1); } catch(e){}
            }
        });
    }

    restrictDigits('input[name="no_hp"]');
    restrictDigits('input[name="no_hp_dokter"]');
    restrictDigits('input[name="umur"]');
    restrictDigits('input#nik_manual');

    var form = document.querySelector('form');
    if (form){
        form.addEventListener('submit', function(e){
            var invalid = false;
            var isAddForm = form.action && form.action.includes('tambah_pengguna_proses');
            
            ['password-pasien','password-admin','password-dokter'].forEach(function(id){
                var el = document.getElementById(id);
                if (el && el.offsetParent !== null){
                    if (isAddForm) {
                        if (!/^\d{6}$/.test(el.value)) invalid = true;
                    } else {
                        if (el.value !== '' && !/^\d{6}$/.test(el.value)) invalid = true;
                    }
                }
            });

            ['nama_pasien', 'nama_admin', 'nama_dokter'].forEach(function(nameFieldId){
                var nameEl = document.querySelector('input[name="' + nameFieldId + '"]');
                if (nameEl && nameEl.offsetParent !== null) {
                    if (/\d/.test(nameEl.value)) {
                        invalid = true;
                    }
                }
            });

            var phoneChecks = [ ['input[name="no_hp"]','No HP pasien harus angka'], ['input[name="no_hp_dokter"]','No HP dokter harus angka'] ];
            phoneChecks.forEach(function(pair){
                var el = document.querySelector(pair[0]);
                if (el && el.offsetParent !== null) {
                    if (!/^\d+$/.test(el.value)) invalid = true;
                }
            });
            var umurEl = document.querySelector('input[name="umur"]');
            if (umurEl && umurEl.offsetParent !== null) {
                if (!/^\d+$/.test(umurEl.value)) invalid = true;
            }
            
            if (invalid){
                e.preventDefault();
                var firstInvalid = null;
                
                ['password-pasien','password-admin','password-dokter'].forEach(function(id){
                    var el = document.getElementById(id);
                    var noteId = id === 'password-pasien' ? 'note-pasien' : (id === 'password-admin' ? 'note-admin' : 'note-dokter');
                    var note = document.getElementById(noteId);
                    if (el && el.offsetParent !== null){
                        var isValid = false;
                        if (isAddForm) {
                            isValid = /^\d{6}$/.test(el.value);
                        } else {
                            isValid = el.value === '' || /^\d{6}$/.test(el.value);
                        }
                        if (!isValid){
                            if (!firstInvalid) firstInvalid = el;
                            if (note){ note.style.display = 'block'; note.style.color = '#e67e22'; note.textContent = isAddForm ? 'PIN harus 6 digit angka' : 'PIN harus 6 digit angka jika diisi'; }
                        } else {
                            if (note){ note.style.display = 'none'; }
                        }
                    }
                });
                
                ['nama_pasien', 'nama_admin', 'nama_dokter'].forEach(function(nameFieldId){
                    var nameEl = document.querySelector('input[name="' + nameFieldId + '"]');
                    if (nameEl && nameEl.offsetParent !== null) {
                        if (/\d/.test(nameEl.value)) {
                            if (!firstInvalid) firstInvalid = nameEl;
                            alert('Nama tidak boleh mengandung angka.');
                        }
                    }
                });
                
                ['input[name="no_hp"]','input[name="no_hp_dokter"]'].forEach(function(sel){
                    var el = document.querySelector(sel);
                    if (el && el.offsetParent !== null) {
                        if (!/^\d+$/.test(el.value)){
                            if (!firstInvalid) firstInvalid = el;
                            alert((sel.indexOf('dokter')!==-1) ? 'No HP dokter harus angka.' : 'No HP pasien harus angka.');
                        }
                    }
                });
                if (umurEl && umurEl.offsetParent !== null) {
                    if (!/^\d+$/.test(umurEl.value)){
                        if (!firstInvalid) firstInvalid = umurEl;
                        alert('Umur harus angka.');
                    }
                }
                
                if (firstInvalid){ firstInvalid.focus(); }
            }
        });
    }
});
