<?php
include 'config/koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_array($query);

// Variabel untuk kontrol animasi
$showSuccess = false;

if (isset($_POST['update'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $status  = mysqli_real_escape_string($koneksi, $_POST['status']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    $update = mysqli_query($koneksi, "UPDATE siswa SET nama_siswa='$nama', status='$status', tanggal='$tanggal' WHERE id='$id'");

    if ($update) {
        $showSuccess = true;
    } else {
        echo "<script>alert('Gagal update: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa - Premium UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Tampilan Utama */
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            padding: 40px;
            color: white;
            text-align: center;
        }

        .form-header i { font-size: 45px; margin-bottom: 10px; }
        .form-header h2 { font-weight: 700; font-size: 24px; letter-spacing: 1px; margin: 0; }

        .form-body { padding: 40px; }
        
        .form-label { font-weight: 700; color: #475569; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 8px; }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #f8fafc;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background-color: white;
        }

        .btn-update {
            background: #6366f1;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
            width: 100%;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn-update:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        /* Animasi Sukses */
        .success-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .success-card { text-align: center; }
        .icon-circle {
            width: 100px; height: 100px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            margin: 0 auto 20px;
            animation: bounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes bounceIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        .loader-bar {
            width: 200px; height: 4px;
            background: #e2e8f0;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-fill {
            height: 100%; background: #6366f1;
            width: 0; animation: fillProgress 1.5s linear forwards;
        }

        @keyframes fillProgress { to { width: 100%; } }
    </style>
</head>
<body>

<?php if ($showSuccess): ?>
    <div class="success-overlay">
        <div class="success-card">
            <div class="icon-circle">
                <i class="fas fa-check"></i>
            </div>
            <h2 class="fw-bold" style="color: #1e293b;">Update Berhasil!</h2>
            <p class="text-muted">Perubahan data telah disimpan...</p>
            <div class="loader-bar"><div class="loader-fill"></div></div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 1500);
    </script>
<?php endif; ?>

<div class="form-container">
    <div class="form-header">
        <i class="fas fa-user-edit"></i>
        <h2>EDIT DATA SISWA</h2>
    </div>

    <div class="form-body">
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" value="<?php echo $data['nama_siswa']; ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Status Kehadiran</label>
                <select name="status" class="form-select" required>
                    <option value="Hadir" <?php if($data['status'] == 'Hadir') echo 'selected'; ?>>Hadir ✅</option>
                    <option value="Izin" <?php if($data['status'] == 'Izin') echo 'selected'; ?>>Izin ✉️</option>
                    <option value="Sakit" <?php if($data['status'] == 'Sakit') echo 'selected'; ?>>Sakit 🤒</option>
                    <option value="Alpa" <?php if($data['status'] == 'Alpa') echo 'selected'; ?>>Alpa ❌</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-update">
                <i class="fas fa-sync-alt me-2"></i> UPDATE DATA SEKARANG
            </button>

            <a href="index.php" class="d-block text-center mt-3 text-decoration-none text-muted fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Batal & Kembali
            </a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>