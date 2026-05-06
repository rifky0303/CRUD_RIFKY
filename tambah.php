<?php 
include 'config/koneksi.php'; 

// Variabel untuk mengontrol tampilan animasi
$showSuccess = false;

if (isset($_POST['simpan'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $status  = mysqli_real_escape_string($koneksi, $_POST['status']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    $input = mysqli_query($koneksi, "INSERT INTO siswa (nama_siswa, status, tanggal) VALUES ('$nama', '$status', '$tanggal')");
    
    if ($input) { 
        $showSuccess = true; // Aktifkan animasi jika berhasil
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Style Overlay Animasi Sukses */
        .success-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            font-family: 'Urbanist', sans-serif;
        }
        .success-card {
            text-align: center;
            animation: zoomIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .check-container {
            width: 100px; height: 100px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        .loader-line {
            width: 200px; height: 4px;
            background: #e2e8f0;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
        }
        .loader-fill {
            height: 100%; background: #10b981;
            width: 0; animation: fillProgress 1.5s linear forwards;
        }
        @keyframes fillProgress { to { width: 100%; } }

        /* Style Form (Sama seperti sebelumnya) */
        body { background-color: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .form-container { width: 100%; max-width: 500px; background: white; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); overflow: hidden; }
        .form-header { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); padding: 30px; color: white; text-align: center; }
        .form-body { padding: 40px; }
        .btn-simpan { background: #4f46e5; border: none; padding: 14px; border-radius: 12px; font-weight: 700; color: white; width: 100%; }
    </style>
</head>
<body>

<?php if ($showSuccess): ?>
    <div class="success-overlay">
        <div class="success-card">
            <div class="check-container">
                <i class="fas fa-check"></i>
            </div>
            <h2 class="fw-bold" style="color: #1e293b;">Data Disimpan!</h2>
            <p class="text-muted">Mengalihkan ke daftar absensi...</p>
            <div class="loader-line">
                <div class="loader-fill"></div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 1500); // Tunggu 1.5 detik baru pindah
    </script>
<?php endif; ?>

<div class="form-container">
    <div class="form-header">
        <i class="fas fa-user-plus fa-3x mb-3"></i>
        <h2>TAMBAH ABSENSI</h2>
    </div>
    <div class="form-body">
        <form method="POST">
            <div class="mb-4">
                <label class="form-label fw-bold">NAMA SISWA</label>
                <input type="text" name="nama_siswa" class="form-control p-3" placeholder="Nama Lengkap" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">STATUS</label>
                <select name="status" class="form-select p-3" required>
                    <option value="Hadir">Hadir ✅</option>
                    <option value="Izin">Izin ✉️</option>
                    <option value="Sakit">Sakit 🤒</option>
                    <option value="Alpa">Alpa ❌</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">TANGGAL</label>
                <input type="date" name="tanggal" class="form-control p-3" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-simpan">SIMPAN DATA</button>
            <a href="index.php" class="d-block text-center mt-3 text-decoration-none text-muted small">Kembali ke Tabel</a>
        </form>
    </div>
</div>

</body>
</html>