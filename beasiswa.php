<!DOCTYPE html>
<html lang="en">
<!-- Favicons -->
<link rel="icon" type="image/png" sizes="192x192" href="img/genbi.png" />
<meta name="msapplication-TileColor" content="#ffffff" />
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
<meta name="theme-color" content="#ffffff" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenBI Check - Portal Beasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary: #6c5ce7;
            --secondary: #a8a5e6;
            --accent: #ffd700;
        }

        body {
            background: linear-gradient(45deg, #142c8d, #142c8d);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            perspective: 1000px;
        }

        header {
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }

        .logo {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 2rem;
            transform-style: preserve-3d;
        }

        .hero h1 {
            color: white;
            font-size: 4rem;
            text-align: center;
            margin-bottom: 1rem;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateZ(50px);
        }

        .card-container {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            width: 300px;
            min-height: 400px;
            transition: all 0.5s ease;
            cursor: pointer;
            transform-style: preserve-3d;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
            background: rgba(255, 255, 255, 0.2);
        }

        .card h2 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .card p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        .btn {
            padding: 1rem 2rem;
            background: linear-gradient(45deg, var(--accent), #ffea00);
            border: none;
            border-radius: 30px;
            color: var(--primary);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
        }

        .bg-circle {
            position: absolute;
            background: linear-gradient(45deg, var(--accent), transparent);
            border-radius: 50%;
            filter: blur(50px);
            z-index: -1;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .card {
                width: 100%;
                min-height: 300px;
            }
        }

        footer {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 4rem 2rem;
            color: white;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            color: var(--accent);
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .footer-section p {
            margin-bottom: 0.8rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
        }

        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            opacity: 0.7;
        }

        .footer-section.address-section {
            grid-column: 1 / 3;
            min-width: 400px;
        }

        .footer-content {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        @media (max-width: 1200px) {
            .footer-section.address-section {
                grid-column: initial;
                min-width: 100%;
            }
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .main-sections {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .social-media-section {
            text-align: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-links {
            justify-content: center;
        }

        @media (max-width: 768px) {
            .main-sections {
                grid-template-columns: 1fr;
            }

            .social-media-section {
                padding-top: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="hero">
            <h1>Temukan Kesempatan Beasiswa <br> Impian Anda</h1>

            <div class="card-container">
                <div class="card">
                    <h2>Cek Beasiswa Lainnya</h2>
                    <p>Telusuri berbagai program beasiswa terbaru dari institusi dalam dan luar negeri. Temukan yang
                        sesuai dengan bidang studi dan aspirasi Anda.</p>
                </div>

                <div class="card">
                    <h2>Cek GenBI Lainnya</h2>
                    <p>Pelajari lebih lanjut tentang program GenBI, persyaratan khusus, dan manfaat yang bisa Anda
                        dapatkan sebagai anggota GenBI.</p>
                </div>

                <div class="card">
                    <h2>Cek Persyaratan Lainnya</h2>
                    <p>Pastikan Anda memenuhi semua persyaratan dokumen dan administrasi yang diperlukan untuk aplikasi
                        beasiswa Anda.</p>
                </div>
            </div>
        </div>

        <div class="bg-circle" style="width: 500px; height: 500px; top: -200px; left: -200px;"></div>
        <div class="bg-circle" style="width: 600px; height: 600px; bottom: -300px; right: -200px;"></div>
    </div>
    <footer>
        <div class="footer-content">
            <!-- Tiga Section Pertama -->
            <div class="main-sections">
                <div class="footer-section">
                    <h3>Kantor GenBI</h3>
                    <p>
                        Gedung Kementerian Keuangan RI<br>
                        Jl. Dr. Wahidin Raya No.1<br>
                        Jakarta Pusat 10710<br>
                        Indonesia
                    </p>
                </div>

                <div class="footer-section">
                    <h3>Kontak Kami</h3>
                    <p>Email: info@genbi-check.id</p>
                    <p>Telepon: (021) 345-6789</p>
                    <p>WhatsApp: +62 812-3456-7890</p>
                </div>

                <div class="footer-section">
                    <h3>Tautan Cepat</h3>
                    <p><a href="#beasiswa">Cek Beasiswa</a></p>
                    <p><a href="#genbi">Tentang GenBI</a></p>
                    <p><a href="#syarat">Persyaratan</a></p>
                    <p><a href="login.php">Login</a></p>
                </div>
            </div>

            <!-- Section Sosial Media -->
            <div class="social-media-section">
                <h3>Sosial Media</h3>
                <div class="social-links">
                    <a href="#instagram">Instagram</a>
                    <a href="#facebook">Facebook</a>
                    <a href="#twitter">Twitter</a>
                    <a href="#youtube">YouTube</a>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2025 GenBI Check. All rights reserved</p>
        </div>
    </footer>
</body>

</html>