<?php
require_once __DIR__ . '/../../config/koneksi_db.php';
session_start();

$ranking = [];
$qr = mysqli_query($koneksi, "SELECT ID_Alternatif FROM hasil_preferensi ORDER BY Total DESC");
if ($qr) {
    while ($r = mysqli_fetch_assoc($qr)) {
        $ranking[] = (int)$r['ID_Alternatif'];
    }
}

if (count($ranking) === 0) {
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert d-flex align-items-center shadow-sm" role="alert"
                style="border-radius:12px; background:linear-gradient(135deg, #0c2461, #0c2461); padding:20px 25px; color:#ffffff;">

                <div class="mr-4" style="font-size:2rem; color:#ffffff;">
                    <i class="fas fa-bullhorn"></i>
                </div>

                <div style="flex:1;">
                    <h4 style="margin:0; font-weight:700; font-size:1.5rem; color:#ffffff; letter-spacing:0.5px;">
                        Informasi Belum Tersedia
                    </h4>
                    <p style="margin-top:8px; margin-bottom:0; font-size:1rem; color:#eaf8fa; line-height:1.6;">
                        Informasi terkait hasil seleksi <strong>Beasiswa GENBI</strong> akan muncul di halaman ini
                        setelah pengumuman resmi dirilis.
                    </p>
                    <p style="margin-top:6px; font-weight:600; color:#f8f9fa;">
                        Silakan Cek Secara Berkala.
                    </p>
                </div>
            </div>
        </div>
    </section>
<?php
    return;
}

// tentukan daftar ID alternatif yang dinyatakan LOLOS (rank 1..3)
$accepted = array_slice($ranking, 0, 3);

// cari ID_Alternatif milik user yang sedang login
$userAltId = null;

// 1) coba pakai session username (jika disimpan saat login)
if (!empty($_SESSION['username'])) {
    $uname = mysqli_real_escape_string($koneksi, trim($_SESSION['username']));
    $q = mysqli_query($koneksi, "SELECT ID_Alternatif FROM data_alternatif WHERE LOWER(Nama_Mahasiswa) = LOWER('{$uname}') LIMIT 1");
    if ($q && ($row = mysqli_fetch_assoc($q))) {
        $userAltId = (int)$row['ID_Alternatif'];
    }
}

// 2) jika belum ketemu, coba pakai session npm untuk mencari username di data_user lalu cari di data_alternatif
if ($userAltId === null && !empty($_SESSION['npm'])) {
    $npm = mysqli_real_escape_string($koneksi, trim($_SESSION['npm']));
    $q = mysqli_query($koneksi, "SELECT username FROM data_user WHERE TRIM(npm) = '{$npm}' LIMIT 1");
    if ($q && ($ru = mysqli_fetch_assoc($q))) {
        $uname = mysqli_real_escape_string($koneksi, trim($ru['username']));
        $q2 = mysqli_query($koneksi, "SELECT ID_Alternatif FROM data_alternatif WHERE LOWER(Nama_Mahasiswa) = LOWER('{$uname}') LIMIT 1");
        if ($q2 && ($r2 = mysqli_fetch_assoc($q2))) {
            $userAltId = (int)$r2['ID_Alternatif'];
        }
    }
}

// 3) jika masih belum ketemu -> tampilkan informasi belum tersedia (sama seperti atas)
if ($userAltId === null) {
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert d-flex align-items-center shadow-sm" role="alert"
                style="border-radius:12px; background:linear-gradient(135deg, #0c2461, #0c2461); padding:20px 25px; color:#ffffff;">

                <div class="mr-4" style="font-size:2rem; color:#ffffff;">
                    <i class="fas fa-bullhorn"></i>
                </div>

                <div style="flex:1;">
                    <h4 style="margin:0; font-weight:700; font-size:1.5rem; color:#ffffff; letter-spacing:0.5px;">
                        Informasi Belum Tersedia
                    </h4>
                    <p style="margin-top:8px; margin-bottom:0; font-size:1rem; color:#eaf8fa; line-height:1.6;">
                        Informasi terkait hasil seleksi <strong>Beasiswa GENBI</strong> akan muncul di halaman ini
                        setelah pengumuman resmi dirilis.
                    </p>
                    <p style="margin-top:6px; font-weight:600; color:#f8f9fa;">
                        Silakan Cek Secara Berkala.
                    </p>
                </div>
            </div>
        </div>
    </section>
<?php
    return;
}

// sekarang tampilkan status berdasarkan apakah ID_Alternatif user ada di daftar accepted (rank 1..4)
if (in_array($userAltId, $accepted, true)) {
    // LOLOS (green)
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert d-flex align-items-center shadow-sm" role="alert"
                style="border-radius:12px; background:linear-gradient(135deg, #28a745, #43d17a); padding:20px 25px; color:#ffffff;">

                <div class="mr-4" style="font-size:2rem; color:#ffffff;">
                    <i class="fas fa-bullhorn"></i>
                </div>

                <div style="flex:1;">
                    <h3 style="margin:0; font-weight:700; font-size:1.7rem; color:#ffffff; letter-spacing:0.5px;">
                        Selamat!
                    </h3>

                    <p style="margin-top:10px; margin-bottom:6px; font-size:1.1rem; color:#f0fff4; line-height:1.6;">
                        Kamu dinyatakan <strong style="color:#ffffff;">LOLOS</strong> sebagai penerima <strong>Beasiswa GENBI</strong>.
                    </p>

                    <p style="margin-top:8px; font-size:1rem; color:#eaffea; line-height:1.6;">
                        Silakan lengkapi data lanjutan sesuai petunjuk yang akan dikirim melalui
                        <strong style="color:#ffffff;">email</strong> atau melalui menu
                        <a href="index.php?page=pengumuman" style="color:#ffffff; font-weight:600; text-decoration:underline;">
                            Pengumuman Beasiswa
                        </a>.
                    </p>
                </div>

            </div>
        </div>
    </section>
<?php
} else {
    // TIDAK LOLOS (red/pink)
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="alert d-flex align-items-center shadow-sm" role="alert"
                style="border-radius:12px; background:linear-gradient(135deg, #ff3e3eff, #ff3e3eff); padding:20px 25px; color:#ffffff;">

                <div class="mr-4" style="font-size:2rem; color:#ffffff;">
                    <i class="fas fa-bullhorn"></i>
                </div>

                <div style="flex:1;">
                    <h4 style="margin:0; font-weight:700; font-size:1.5rem; color:#ffffff; letter-spacing:0.5px;">
                        Terima kasih telah berpartisipasi.
                    </h4>
                    <p style="margin: 5px 0 0 0; color: #ffffff; font-family: 'Poppins', sans-serif; font-size: 0.95rem;">
                        Kamu <strong style="color: #ffffff;">Belum Lolos</strong> dalam seleksi <strong>Beasiswa GENBI</strong> periode ini.<br>
                    </p>

                    <strong style="color:#ffffff;">Tetap Semangat dan nantikan kesempatan berikutnya.</strong>
                </div>

            </div>
        </div>
    </section>
<?php
}
?>