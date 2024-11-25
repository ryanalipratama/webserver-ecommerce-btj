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

<!-- Home/Learning Center Content-->
<nav aria-label="breadcrumb" class="mt-3" data-aos="fade-up">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About US</li>
        </ol>
    </div>
</nav>
<!-- End Home/Learning Center Content -->

<!-- Isi About US -->
<div class="container container-aboutus">
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
        </div>
    </div>
</div>
<!-- End Of About US -->
    
@endsection