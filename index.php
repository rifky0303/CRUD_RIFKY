<?php 
include('config/koneksi.php'); 

// Ambil data untuk statistik dan grafik
$res_hadir = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE status='Hadir'");
$res_izin  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE status='Izin'");
$res_sakit = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE status='Sakit'");
$res_alpa  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE status='Alpa'");

$jml_hadir = mysqli_fetch_assoc($res_hadir)['total'] ?? 0;
$jml_izin  = mysqli_fetch_assoc($res_izin)['total'] ?? 0;
$jml_sakit = mysqli_fetch_assoc($res_sakit)['total'] ?? 0;
$jml_alpa  = mysqli_fetch_assoc($res_alpa)['total'] ?? 0;
$total_siswa = $jml_hadir + $jml_izin + $jml_sakit + $jml_alpa;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi - XI PPLG 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Urbanist', sans-serif; color: #1e293b; }
        .main-container { margin-top: 40px; margin-bottom: 60px; }
        
        .header-section {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            padding: 40px; border-radius: 24px; color: white;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2); margin-bottom: 30px;
        }

        .stats-card {
            background: white; border-radius: 20px; padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); height: 100%;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .table-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        
        .table { border-collapse: separate; border-spacing: 0 10px; }
        .table thead th { border: none; color: #94a3b8; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
        .table tbody tr { background-color: #fff; transition: all 0.3s; }
        .table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .table tbody td { padding: 15px; border: none; vertical-align: middle; }
        .table tbody td:first-child { border-radius: 12px 0 0 12px; }
        .table tbody td:last-child { border-radius: 0 12px 12px 0; }

        .badge-status { padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.75rem; }
        .bg-hadir { background: #dcfce7; color: #166534; }
        .bg-izin { background: #fef9c3; color: #854d0e; }
        .bg-sakit { background: #dbeafe; color: #1e40af; }
        .bg-alpa { background: #fee2e2; color: #991b1b; }

        .btn-add {
            background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.4);
            color: white; padding: 10px 24px; border-radius: 12px; font-weight: 700; text-decoration: none;
        }
        .btn-add:hover { background: white; color: #4f46e5; }
        
        #absensiChart { max-height: 200px !important; }
    </style>
</head>
<body>

<div class="container main-container">
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1 fw-bold"><i class="fas fa-chart-line me-3"></i>Dashboard Absensi</h2>
            <p class="mb-0 opacity-75">Monitoring Kehadiran Siswa</p>
        </div>
        <a href="tambah.php" class="btn btn-add"><i class="fas fa-plus-circle me-2"></i> Tambah Siswa</a>
    </div>

    <div class="row mb-4 g-4">
        <div class="col-lg-4 text-center">
            <div class="stats-card">
                <h6 class="fw-bold text-muted mb-3">PERSENTASE</h6>
                <canvas id="absensiChart"></canvas>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="stats-card border-bottom border-4 border-success">
                        <small class="text-muted fw-bold">HADIR</small>
                        <h3 class="fw-bold text-success m-0"><?= $jml_hadir; ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card border-bottom border-4 border-warning">
                        <small class="text-muted fw-bold">IZIN</small>
                        <h3 class="fw-bold text-warning m-0"><?= $jml_izin; ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card border-bottom border-4 border-primary">
                        <small class="text-muted fw-bold">SAKIT</small>
                        <h3 class="fw-bold text-primary m-0"><?= $jml_sakit; ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card border-bottom border-4 border-danger">
                        <small class="text-muted fw-bold">ALPA</small>
                        <h3 class="fw-bold text-danger m-0"><?= $jml_alpa; ?></h3>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="stats-card bg-dark text-white d-flex align-items-center justify-content-between">
                        <span class="fw-bold opacity-75">Total Partisipasi Siswa</span>
                        <h4 class="m-0 fw-bold"><?= $total_siswa; ?> <small class="fs-6">Jiwa</small></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <h5 class="fw-bold mb-4"><i class="fas fa-list me-2 text-primary"></i>Daftar Kehadiran Terbaru</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="60">NO</th>
                        <th>NAMA SISWA</th>
                        <th>KELAS</th>
                        <th>STATUS</th>
                        <th>TANGGAL</th>
                        <th width="120" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC");
                    while($data = mysqli_fetch_array($query)){
                        $statusClass = match($data['status']) {
                            'Hadir' => 'bg-hadir', 'Izin' => 'bg-izin', 'Sakit' => 'bg-sakit', default => 'bg-alpa'
                        };
                        $emoji = match($data['status']) {
                            'Hadir' => '✅', 'Izin' => '✉️', 'Sakit' => '🤒', default => '❌'
                        };
                    ?>
                    <tr>
                        <td class="fw-bold text-muted"><?= $no++; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 38px; height: 38px; color: #4f46e5;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="fw-bold"><?= $data['nama_siswa']; ?></span>
                            </div>
                        </td>
                        <td class="fw-bold text-primary">
                            <?= $data['kelas']; ?>
                        </td>
                        <td><span class="badge-status <?= $statusClass; ?>"><?= $emoji; ?> <?= $data['status']; ?></span></td>
                        <td class="text-secondary small fw-bold"><?= date('d M Y', strtotime($data['tanggal'])); ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-light btn-sm text-primary rounded-3 me-1"><i class="fas fa-edit"></i></a>
                            <a href="hapus.php?id=<?= $data['id']; ?>" class="btn btn-light btn-sm text-danger rounded-3" onclick="return confirm('Hapus data?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('absensiChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
            datasets: [{
                data: [<?= $jml_hadir; ?>, <?= $jml_izin; ?>, <?= $jml_sakit; ?>, <?= $jml_alpa; ?>],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '75%',
            plugins: { legend: { position: 'bottom', labels: { font: { family: 'Urbanist', weight: 'bold' } } } }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>