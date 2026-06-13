function validateForm(){
    var pw = document.querySelector('input[name="password"]');
    if (pw && pw.value){
        if (!/^\d{6}$/.test(pw.value)){
            alert('PIN harus 6 digit angka jika diisi.');
            return false;
        }
    }
    var pwAdmin = document.querySelector('input[name="passwordadmin"]');
    if (pwAdmin && pwAdmin.value){ 
        if (!/^\d{6}$/.test(pwAdmin.value)){ 
            alert('PIN admin harus 6 digit angka jika diisi.'); 
            return false; 
        } 
    }
    var pwDok = document.querySelector('input[name="passworddok"]');
    if (pwDok && pwDok.value){ 
        if (!/^\d{6}$/.test(pwDok.value)){ 
            alert('PIN dokter harus 6 digit angka jika diisi.'); 
            return false; 
        } 
    }
    
    var namaPasien = document.querySelector('input[name="nama_pasien"]');
    if (namaPasien && namaPasien.offsetParent !== null) {
        if (/\d/.test(namaPasien.value)) {
            alert('Nama tidak boleh mengandung angka.');
            namaPasien.focus();
            return false;
        }
    }
    
    var namaAdmin = document.querySelector('input[name="nama_admin"]');
    if (namaAdmin && namaAdmin.offsetParent !== null) {
        if (/\d/.test(namaAdmin.value)) {
            alert('Nama tidak boleh mengandung angka.');
            namaAdmin.focus();
            return false;
        }
    }
    
    var namaDokter = document.querySelector('input[name="nama_dokter"]');
    if (namaDokter && namaDokter.offsetParent !== null) {
        if (/\d/.test(namaDokter.value)) {
            alert('Nama tidak boleh mengandung angka.');
            namaDokter.focus();
            return false;
        }
    }
    
    return true;
}
