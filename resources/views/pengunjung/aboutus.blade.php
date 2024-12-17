@extends('pengunjung.main')

@section('title', 'Bintang Tiga Jaya | About Us')

@section('content')

<!-- Gambar Judul -->
<div class="gambar-judul position-relative" data-aos="fade-right">
    <img src="{{ asset('lte/dist/img/aboutus.jpeg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="fw-bold">About US</h1>
    </div>
</div>
<!-- End Of Gambar Judul -->

<!-- Home/About Us-->
<nav aria-label="breadcrumb" class="mt-3" data-aos="fade-up">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About US</li>
        </ol>
    </div>
</nav>
<!-- End Home/About Us -->

<!-- Bintang Tiga Jaya -->
<div class="container container-aboutus" data-aos="fade-up">
    <div class="row">
        <div class="col-lg-6 d-flex justify-content-center">
                <img src="{{ asset('lte/dist/img/logobtj.png') }}" alt="Logo">
        </div>
        <div class="col-lg-6">
            <h1>Bintang Tiga Jaya</h1>
            <p>Bintang Tiga Jaya adalah perusahaan
                yang bergerak di bidang large format
                digital printing. Kami menyediakan
                service berupa cetakan berkualitas
                tinggi baik media dalam ruangan (indoor)
                maupun luar ruangan (outdoor) untuk
                membantu klien kami berpromosi.</p>
            <p>Dengan pengalaman serta tenaga
                profesional kami dibidang digital printing
                & design grafis yang begitu lama serta
                didukung dengan teknologi yang
                mutakhir, kami yakin mampu memberikan
                hasil yang terbaik dengan harga bersaing. </p>
            <p>Kami berkomitmen untuk memberikan hasil yang 
                memuaskan dengan harga yang bersaing, serta 
                layanan pelanggan yang responsif dan siap 
                membantu klien kami dalam setiap tahap proyek. 
                Kepercayaan yang telah diberikan oleh 
                berbagai perusahaan dan individu selama 
                bertahun-tahun menjadi bukti nyata dedikasi kami 
                dalam memberikan solusi cetak yang tepat dan 
                efektif untuk berbagai kebutuhan promosi. </p>
        </div>
    </div>
</div>
<!-- End Of Bintang Tiga Jaya -->

<!-- Why Us -->
<div class="container container-whyus" data-aos="fade-up">
    <div class="garis-whyus">
        <span class="line"></span>
        <h2>Why Us</h2>
        <span class="line"></span>
    </div>
    <div class="row mt-5 mb-3">
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-gears fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Mesin Berkualitas</h1>
                    <p>Kami menggunakan mesin berteknologi tinggi untuk memastikan setiap produk memiliki kualitas terbaik dan presisi tinggi.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-infinity fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>24 Jam</h1>
                    <p>Layanan kami tersedia 24 jam untuk memenuhi kebutuhan Anda kapan saja, tanpa batas waktu.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-bell fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Spesialis Dadakan</h1>
                    <p>Kami siap menangani pesanan mendadak dengan cepat tanpa mengurangi kualitas produk.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-thumbs-up fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Kualitas Terbaik</h1>
                    <p>Setiap produk yang kami hasilkan melewati kontrol kualitas yang ketat untuk menjamin kepuasan pelanggan.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-bolt fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Waktu Produksi Cepat</h1>
                    <p>Proses produksi kami dirancang untuk memberikan hasil dalam waktu yang singkat tanpa mengorbankan kualitas.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-cart-shopping fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Produk Lengkap</h1>
                    <p>Kami menyediakan berbagai jenis produk percetakan untuk memenuhi kebutuhan bisnis Anda.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-dollar-sign fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Harga Bersaing</h1>
                    <p>Kami menawarkan harga yang kompetitif tanpa mengurangi kualitas produk dan layanan kami.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-comments fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Konsultasi Produk</h1>
                    <p>Tim kami siap memberikan konsultasi untuk membantu Anda memilih produk terbaik yang sesuai dengan kebutuhan.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-money-bill-transfer fa-6x"></i>
                </div>
                <div class="col-lg-6">
                    <h1>Jaminan Uang Kembali</h1>
                    <p>Kami memberikan jaminan uang kembali jika produk tidak sesuai dengan spesifikasi yang disepakati.</p>
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- End Of Why Us -->
    
@endsection