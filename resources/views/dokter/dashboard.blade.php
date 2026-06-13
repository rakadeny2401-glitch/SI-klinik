@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Dokter</h2>
        <p class="text-sm text-gray-500 mt-1">
            Selamat datang kembali, Dokter <span class="font-semibold text-[#004085]">{{ session('data.nama_dokter') ?? 'Dilan' }}</span>!
        </p>
    </div>

    <div class="max-w-4xl w-full bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_4px_20px_rgba(0,0,0,0.015)]">
        
        <h3 class="text-center text-base font-bold text-[#004085] tracking-wide mb-6">
            Kurva Keramaian Pasien Anda
        </h3>
        
        <div class="w-full h-[320px] relative">
            <canvas id="chartTanggal"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('chartTanggal'), {
        type: 'line',
        data: {
            labels: @json($label2),
            datasets: [{
                label: 'Jumlah Pasien',
                data: @json($data2),
                borderWidth: 3,
                tension: 0.4,
                // Warna Garis Merah Medis sesuai mockup gambar rekam medis Anda
                borderColor: '#c82333', 
                backgroundColor: 'rgba(200, 35, 51, 0.04)', 
                fill: true, 
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#c82333',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            // PENTING: Memaksa Chart.js agar patuh pada tinggi pembungkus div (h-[320px])
            maintainAspectRatio: false, 
            plugins: { 
                legend: { display: false } 
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1, 
                        color: '#94a3b8',
                        font: { size: 11 }
                    },
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11 }
                    },
                    grid: {
                        display: false 
                    }
                }
            }
        }
    });
});
</script>
@endsection