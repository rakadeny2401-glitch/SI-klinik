@extends('layout.app')

@section('content')
<div style="font-family: 'Nunito', sans-serif; padding: 30px; background: #fff; border-radius: 12px; max-width: 900px; margin: 20px auto;">
    
    <h2 style="color: #0b438c; font-size: 22px; font-weight: 700; border-left: 4px solid #0b438c; padding-left: 10px; margin-bottom: 25px;">
        Detail Surat Rekomendasi Rujukan
    </h2>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #e2f0fd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <tr>
            <th style="width: 25%; background-color: #0b438c; color: white; padding: 15px; text-align: left; font-size: 14px; border-bottom: 1px solid #08336d;">Nama Pasien</th>
            <td style="padding: 15px; border-bottom: 1px solid #e2f0fd; font-size: 14px; color: #333;">{{ $data->nama_pasien }}</td>
        </tr>
        <tr>
            <th style="background-color: #0b438c; color: white; padding: 15px; text-align: left; font-size: 14px; border-bottom: 1px solid #08336d;">Umur</th>
            <td style="padding: 15px; border-bottom: 1px solid #e2f0fd; font-size: 14px; color: #333;">{{ $data->umur }} tahun</td>
        </tr>
        <tr>
            <th style="background-color: #0b438c; color: white; padding: 15px; text-align: left; font-size: 14px; border-bottom: 1px solid #08336d;">Keluhan</th>
            <td style="padding: 15px; border-bottom: 1px solid #e2f0fd; font-size: 14px; color: #333;">{{ $data->keluhan ?? '-' }}</td>
        </tr>
        <tr>
            <th style="background-color: #0b438c; color: white; padding: 15px; text-align: left; font-size: 14px; border-bottom: 1px solid #08336d;">Rekomendasi</th>
            <td style="padding: 15px; border-bottom: 1px solid #e2f0fd; font-size: 14px; color: #333; line-height: 1.6;">{{ $data->rekomendasi }}</td>
        </tr>
        <tr>
            <th style="background-color: #0b438c; color: white; padding: 15px; text-align: left; font-size: 14px;">Dokter</th>
            <td style="padding: 15px; font-size: 14px; color: #333;">{{ $data->nama_dokter }}</td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ url('/dokter/riwayat') }}" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-block;">
            Kembali
        </a>
    </div>
</div>
@endsection