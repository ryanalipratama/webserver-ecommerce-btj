@extends('pengunjung.main')

@section('title', 'Bintang Tiga Jaya | Produk Selengkapnya')

@section('content')

<!-- Gambar Judul -->
<div class="gambar-judul position-relative" data-aos="fade-right">
    <img src="{{ asset('lte/dist/img/produk.jpeg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="fw-bold">Info Produk</h1>
    </div>
</div>
<!-- End Of Gambar Judul -->

<!-- Home/Produk Selengkapnya -->
<nav aria-label="breadcrumb" class="mt-3" data-aos="fade-up">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Info Produk</li>
        </ol>
    </div>
</nav>
<!-- End Home/Produk Selengkapnya -->

<!-- Content -->
<div class="container container-halaman-produk-selengkapnya my-5" data-aos="fade-up">
    <div class="row">
        <div class="col-lg-6">
            <div class="container container-gambar-selengkapnya">
                <img src="{{ asset($produk->gambar) }}" class="img-fluid">
            </div>
        </div>
        <div class="col-lg-6">
            <h1>{{ $produk->nama_produk }}</h1>
            <p>{{ $produk->deskripsi }}</p>
            <h3>Harga: Rp {{ number_format($produk->harga, 2, ',', '.') }}</h3>
            <a class="btn" onclick="showAlertPesanSekarang()" >Pesan Sekarang!</a>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection