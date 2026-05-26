<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard_admin.css') }}">
</head>
<body>

<div class="dashboard-container">
    <h1>Dashboard Admin</h1>
    
    <div class="welcome-message">
        <p>Selamat datang, {{ session('data')->nama_admin ?? 'Admin' }}!</p>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Pasien</h3>
            <p class="stat-number">{{ $totalPasien ?? 0 }}</p>
        </div>
        
        <div class="stat-card">
            <h3>Pendaftaran Hari Ini</h3>
            <p class="stat-number">{{ $todayRegistrations ?? 0 }}</p>
        </div>
        
        <div class="stat-card">
            <h3>Total Dokter</h3>
            <p class="stat-number">{{ $totalDokter ?? 0 }}</p>
        </div>
    </div>

    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <a href="/admin/pengguna" class="btn btn-primary">Kelola Pengguna</a>
        <a href="/logout" class="btn btn-secondary">Logout</a>
    </div>
</div>

<style>
    .dashboard-container {
        padding: 20px;
    }
    
    .welcome-message {
        background-color: #f0f8ff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }
    
    .stat-card {
        background: white;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 2em;
        font-weight: bold;
        color: #007bff;
        margin: 10px 0;
    }
    
    .quick-actions {
        margin-top: 30px;
    }
    
    .quick-actions a {
        display: inline-block;
        margin: 10px 10px 10px 0;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>

</body>
</html>
