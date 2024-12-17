document.addEventListener("DOMContentLoaded", function() {
    const banner = document.querySelectorAll('.banner');
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function animateBanner() {
        banner.forEach(banner => {
            if (isElementInViewport(banner) && !banner.classList.contains('in-view')) {
                banner.classList.add('in-view');
                
                const percentageText = banner.querySelector('#number').textContent;
                const percentage = parseInt(percentageText.replace('%', ''));
                
                const circle = banner.querySelector('svg circle');
                const circumference = 2 * Math.PI * circle.r.baseVal.value;
                const offset = circumference - (circumference * percentage / 100);
                
                circle.style.strokeDasharray = circumference;
                circle.style.strokeDashoffset = offset;
            }
        });
    }

    window.addEventListener('scroll', animateBanner);
    animateBanner();

    // Inisialisasi AOS
    AOS.init({
        duration: 1000,
        once: true 
    });

    // swiper bagian fasilitas
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1, // Default: 1 slide untuk layar kecil
        slidesPerGroup: 1,
        spaceBetween: 10,
        loop: true, // Infinite loop
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2, // Menampilkan 2 slide pada layar ≥ 640px
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3, // Menampilkan 3 slide pada layar ≥ 768px
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3, // Menampilkan 4 slide pada layar ≥ 1024px
                spaceBetween: 10,
            },
        },
    });

  

    

    

    
});

function showAlertPesanSekarang() {
    Swal.fire({
        icon: "error",
        title: "Maaf...",
        text: "Saat ini fitur pembelian didalam website sedang dikembangkan. Silahkan hubungi admin melalui WhatsApp yang tertera atau tekan icon WhatsApp untuk melakukan pesanan!.",
    });
}

function showAlertMasuk(){
    Swal.fire({
        icon: "error",
        title: "Maaf...",
        text: "Saat ini fitur untuk login user sedang dikembangkan.",
    });
}

function showAlertSearch(){
    Swal.fire({
        icon: "error",
        title: "Maaf...",
        text: "Saat ini fitur fitur mencari produk sedang dikembangkan.",
    });
}

