<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Judul -->
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('lte/dist/img/logobtj.png') }}" type="image/x-icon">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <!-- Logo di kiri -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('lte/dist/img/logobtj.png') }}" alt="Logo" width="60" height="50"
                    class="d-inline-block align-text-top">
            </a>
            
            <!-- Tombol hamburger untuk mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu dan search box di kanan -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <!-- Menu item di kanan -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/aboutus">About US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Masuk</a>
                    </li>
                </ul>
                <!-- Form pencarian di kanan -->
                <form class="d-flex" role="search">
                    <input class="form-control form-search me-2" type="search" placeholder="Cari Produk" aria-label="Search">
                    <button class="btn btn-search" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- End Navbar -->

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    <!-- End Main Content -->

    <!-- Footer -->
    <footer class="footer1" data-aos="fade-up">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-lg-4 mt-5">
                    <h2>Alamat</h2>
                    <p>Jalan Sultan Ageng Tirtayasa Nomor 46
                        Kedungjaya, Kedawung,
                        Cirebon, Jawa Barat 45153</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.4633584565454!2d108.52444457475504!3d-6.713168893282615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee21ea2545b35%3A0x8967d2b97271db9e!2sCV.%20BINTANG%20TIGA%20JAYA!5e0!3m2!1sid!2sid!4v1732497356048!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-4 mt-5">
                    <h2>Hubungi Kami</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div class="col-lg-1">
                                <p>bintangtiga.jaya@yahoo.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="col-lg-10">
                                <p>085-222-545-454 / 085-295-555-575
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-regular fa-clock" ></i>
                            </div>
                            <div class="col-lg-10">
                                <p>Jam Operasional</p>
                                <p>Senin-Sabtu | 08.00 - 18.00 wib</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-5">
                    <h2>Sosial Media</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-brands fa-instagram"></i>
                            </div>
                            <div class="col-10">
                                <p>@bintangtigajayacrb</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-brands fa-twitter"></i>
                            </div>
                            <div class="col-10">
                                <p>@bintangtigajayacrb</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-brands fa-facebook"></i>
                            </div>
                            <div class="col-10">
                                <p>Bintang Tiga Jaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa-brands fa-linkedin"></i>
                            </div>
                            <div class="col-10">
                                <p>Bintang Tiga Jaya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <footer class="footer2">
        <div class="container container-fluid d-flex justify-content-center">
            <p class="mb-0 text-center">
                &copy; 2024 Bintang Tiga Jaya. All Rights Reserved.
            </p>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- JS -->
    <script src="{{ asset('js/index.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- End JS -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

</body>

</html>
