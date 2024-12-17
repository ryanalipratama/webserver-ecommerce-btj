@extends('pengunjung.main')

@section('title', 'Bintang Tiga Jaya | Homepage')

@section('content')

    <!-- Tampilan Awal -->
    <div class="jumbotron" data-aos="fade-up">
        <img src="{{ asset('lte/dist/img/Designer.jpeg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
        <div class="overlay">
            <h1>Selamat Datang di Bintang Tiga Jaya</h1>
            <p>Solusi terbaik untuk kebutuhan percetakan Anda</p>
            <a href="#carousel" class="btn btn-primary">Pelajari Selengkapnya</a>
        </div>
    </div>
    <!-- End Tampilan Awal -->

    <!-- Carousel -->
    <div class="carousel zoom-effect" id="carousel" data-aos="fade-up">
        <div class="container mt-5">
            <div class="mx-auto my-lg-5 my-md-3">
                <div id="carouselExampleCaptions" class="carousel slide border rounded-5 shadow-custom">
                    <div class="carousel-indicators">
                        @foreach ($banner as $item)
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"
                                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                aria-label="Slide {{ $loop->index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($banner as $item)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }} border rounded-5">
                                <img src="{{ asset($item->gambar_banner) }}"
                                    class="d-block w-100 fixed-size-img img-fluid border rounded-5" alt="...">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Carousel -->

    <!-- Produk -->
    <div class="container container-produk my-5" data-aos="fade-up">
        <div class="pendahuluan-produk">
            <h1 class="text-center">Produk Kami</h1>
            <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga cupiditate nisi maxime id,
                vero perferendis nemo possimus sit blanditiis assumenda cumque quasi! Quaerat in, quidem tempora quas
                similique natus suscipit.</p>
        </div>
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
                @if ($index == 6)
                    <!-- Cek jika ini produk ke-7 -->
                    <div class="col-lg-3">
                        <a href="{{ route('pengunjung.produk') }}" class="text-decoration-none">
                            <div class="container container-produk-selengkapnya">
                                <div class="card card-produk-selengkapnya">
                                    <div class="card-body">
                                        <h1 class="card-title">Lihat Semua Produk</h1>
                                        <h2>----------></h1>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- Produk -->

    <!-- Fasilitas Produksi -->
    <div class="container container-fasilitas-produksi" data-aos="fade-up"> 
        <div class="pendahuluan-fasilitas-produksi" data-aos="fade-up">
            <h1 class="text-center">Mesin Produksi Yang Kami Gunakan</h1>
            <p class="text-center">Kami menggunakan mesin-mesin produksi berkualitas tinggi untuk memastikan setiap produk yang dihasilkan memiliki presisi dan kualitas terbaik. Dengan teknologi canggih yang terus diperbarui, kami berkomitmen untuk memberikan hasil terbaik yang sesuai dengan kebutuhan dan harapan pelanggan.</p>
        </div>
        <div class="swiper mySwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="container container-fasilitas-produksi-swiper">
                        <img src="{{ asset('lte/dist/img/mesin--t8i.jpg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
                        <h1>Taimes T8i</h1>
                    </div>
                    
                </div>
                <div class="swiper-slide">
                    <div class="container container-fasilitas-produksi-swiper">
                        <img src="{{ asset('lte/dist/img/mesin--xenon.jpg') }}" class="img-fluid" alt="BTJ LOGO" data-aos="fade-up">
                        <h1>Xenon UV 2000D</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="container container-fasilitas-produksi-swiper">
                        <img src="{{ asset('lte/dist/img/mesin--cutting.jpg') }}" class="img-fluid border" alt="BTJ LOGO" data-aos="fade-up">
                        <h1>Plot cutting CE7000-60</h1>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="container container-fasilitas-produksi-swiper">
                        <img src="{{ asset('lte/dist/img/mesin--laser.jpg') }}" class="img-fluid border" alt="BTJ LOGO" data-aos="fade-up">
                        <h1>LC Cnc 1390</h1>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- End Fasilitas Produksi -->
@endsection
