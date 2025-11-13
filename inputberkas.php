<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Berkas Persyaratan Beasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 32px 24px;
        }
        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #6c5ce7;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #6c5ce7;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #4834d4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Input Berkas Persyaratan Beasiswa</h2>
        <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Mahasiswa</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nim">NPM</label>
            <input type="text" id="nim" name="nim" required>

            <label for="prodi">Program Studi</label>
            <input type="text" id="prodi" name="prodi" required>

            <label for="berkas">Aktif Organisasi</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required>

            <label for="berkas">Tidak Menerima Beasiswa</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required>

            <label for="jumlah_sks">Jumlah SKS</label>
            <input type="number" id="jumlah_sks" name="jumlah_sks" min="40" required placeholder="Masukkan jumlah SKS (minimal 40)">

            <label for="berkas">Keluarga Kurang Mampu</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required>
            
            <label for="berkas">IPK</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required>


            <button type="submit">Kirim Berkas</button>
        </form>
    </div>
</body>