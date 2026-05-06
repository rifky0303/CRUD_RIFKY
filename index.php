<?php include('config/koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi - Premium UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f0f2f5; 
            font-family: 'Urbanist', sans-serif;
            color: #1e293b;
        }

        /* Container & Header */
        .main-container { margin-top: 60px; margin-bottom: 60px; }
        
        .header-section {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            padding: 40px;
            border-radius: 24px 24px 0 0;
            color: white;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
        }

        /* Table Card Area */
        .table-card {
            background: white;
            border-radius: 0 0 24px 24px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }

        /* Modern Table Styles */
        .table { border-collapse: separate; border-spacing: 0 12px; }
        .table thead th {
            border: none;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 15px;
        }
        .table tbody tr {
            background-color: #ffffff;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        .table tbody tr:hover {
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            background-color: #f8fafc;
        }
        .table tbody td {
            padding: 20px 15px;
            border: none;
            vertical-align: middle;
        }
        .table tbody td:first-child { border-radius: 12px 0 0 12px; }
        .table tbody td:last-child { border-radius: 0 12px 12px 0; }

        /* Status Badges */
        .badge-status {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.8rem;
        }
        .bg-hadir { background: #dcfce7; color: #166534; }
        .bg-izin { background: #fef9c3; color: #854d0e; }
        .bg-sakit { background: #dbeafe; color: #1e40af; }
        .bg-alpa { background: #fee2e2; color: #991b1b; }

        /* Action Buttons */
        .btn-add {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 700;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
        }
        .btn-add:hover {
            background: white;
            color: #4f46e5;
            transform: translateY(-2px);
        }

        .btn-edit { background: #f1f5f9; color: #6366f1; border-radius: 10px; border: none; padding: 8px 12px; }
        .btn-edit:hover { background: #6366f1; color: white; }
        
        .btn-delete { background: #f1f5f9; color: #ef4444; border-radius: 10px; border: none; padding: 8px 12px; }
        .btn-delete:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

<div class="container main-container">
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1 fw-bold"><i class="fas fa-layer-group me-3"></i>Data Absensi</h2>
            <p class="mb-0 opacity-75">Manajemen kehadiran siswa secara real-time</p>
        </div>
        <a href="tambah.php" class="btn btn-add">
            <i class="fas fa-plus-circle me-2"></i> Tambah Data
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="80">ID NO</th>
                        <th>Nama Siswa</th>
                        <th>Status</th>
                        <th>Tanggal Absen</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC");
                    while($data = mysqli_fetch_array($query)){
                        // Mapping Class Status
                        $statusClass = "";
                        $emoji = "";
                        if($data['status'] == 'Hadir') { $statusClass = "bg-hadir"; $emoji = "✅"; }
                        elseif($data['status'] == 'Izin') { $statusClass = "bg-izin"; $emoji = "✉️"; }
                        elseif($data['status'] == 'Sakit') { $statusClass = "bg-sakit"; $emoji = "🤒"; }
                        else { $statusClass = "bg-alpa"; $emoji = "❌"; }
                    ?>
                    <tr>
                        <td class="text-muted fw-bold">#<?= str_pad($no++, 2, "0", STR_PAD_LEFT); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; color: #4f46e5;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <span class="fw-bold text-dark"><?= $data['nama_siswa']; ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-status <?= $statusClass; ?>">
                                <?= $emoji; ?> <?= $data['status']; ?>
                            </span>
                        </td>
                        <td class="text-secondary fw-semibold">
                            <i class="far fa-calendar-alt me-2"></i><?= date('d M, Y', strtotime($data['tanggal'])); ?>
                        </td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-edit btn-sm me-1" title="Edit Data">
                                <i class="fas fa-pen-nib"></i>
                            </a>
                            <a href="hapus.php?id=<?= $data['id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus Data">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <?php if(mysqli_num_rows($query) == 0): ?>
        <div class="text-center py-5">
            <img src="https://illustrations.popsy.co/white/data-analysis.svg" style="width: 150px;" class="mb-3">
            <p class="text-muted fw-bold">Belum ada data absensi hari ini.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>