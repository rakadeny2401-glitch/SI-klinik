$('#nik').select2({
    placeholder: 'Ketik NIK atau Nama Pasien',
    minimumInputLength: 2,
    ajax: {
        url: '/puskesmas/controller/search_pasien.php',
        dataType: 'json',
        delay: 300,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return { results: data };
        }
    }
});

$('#nik').on('select2:select', function (e) {
    let d = e.params.data;
    $('#nama_pasien').val(d.nama);
    $('#nik_manual').val(d.nik);
    $('#alamat_pasien').val(d.alamat);
    $('#jenis_kelamin').val(d.jk);
    $('#umur').val(d.umur);
});