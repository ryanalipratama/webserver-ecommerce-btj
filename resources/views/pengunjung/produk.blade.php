@extends('pengunjung.main')

@section('title', 'Bintang Tiga Jaya | Produk')

@section('content')

<!-- Gambar Judul -->
<div class="gambar-judul position-relative" data-aos="fade-right">
    <img src="{{ asset('lte/dist/img/produk.jpeg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="fw-bold">Produk</h1>
    </div>
</div>
<!-- End Of Gambar Judul -->

<!-- Home/Produk-->
<nav aria-label="breadcrumb" class="mt-3" data-aos="fade-up">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produk</li>
        </ol>
    </div>
</nav>
<!-- End Home/Produk -->

<!-- Produk -->
<div class="container container-produk my-5" data-aos="fade-up">
    <div class="row">
        @foreach ($produk as $index => $item)
            <div class="col-lg-3">
                <div class="card card-produk mb-5">
                    <div class="card-head">
                        <img src="{{ asset($item->gambar) }}" class="card-img-top img-fluid">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama_produk }}</h5>
                        <a href="{{ route('pengunjung.produk_selengkapnya', $item->id) }}" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Produk -->

@endsection