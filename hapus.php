<?php
include 'config/koneksi.php';

// Ambil ID dari URL
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menghapus Data...</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .success-card {
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: popIn 0.5s cubic-bezier(0.26, 0.53, 0.74, 1.48);
        }

        /* Animasi Card Muncul */
        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }

        .icon-box {
            width: 100px;
            height: 100px;
            background: #fdf2f2; /* Warna merah muda lembut untuk hapus */
            color: #ef4444; /* Warna merah */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            margin: 0 auto 20px;
            animation: circleScale 0.4s 0.3s both;
        }

        @keyframes circleScale {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        h2 { color: #1e293b; margin: 0 0 10px; }
        p { color: #64748b; margin: 0; }

        /* Loader Bar */
        .loader-bar {
            height: 4px;
            width: 100%;
            background: #e2e8f0;
            margin-top: 30px;
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-progress {
            height: 100%;
            width: 0;
            background: #ef4444;
            animation: progress 2s linear forwards;
        }

        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <?php if ($hapus): ?>
            <div class="icon-box">
                <i class="fas fa-trash-check animate__animated animate__bounceIn"></i>
            </div>
            <h2>Terhapus!</h2>
            <p>Data siswa telah berhasil dihapus dari sistem.</p>
            
            <div class="loader-bar">
                <div class="loader-progress"></div>
            </div>
            <p style="font-size: 12px; margin-top: 10px; opacity: 0.6;">Mengalihkan halaman dalam 2 detik...</p>

            <script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000);
            </script>

        <?php else: ?>
            <div class="icon-box" style="background: #fee2e2; color: #b91c1c;">
                <i class="fas fa-times"></i>
            </div>
            <h2>Gagal!</h2>
            <p>Terjadi kesalahan: <?= mysqli_error($koneksi); ?></p>
            <a href="index.php" style="display:inline-block; margin-top:20px; color:#4f46e5; text-decoration:none; font-weight:700;">Kembali</a>
        <?php endif; ?>
    </div>

</body>
</html>