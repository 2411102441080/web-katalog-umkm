<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Ambil SEMUA elemen yang memiliki class 'btn-guest'
    const tombolGuests = document.querySelectorAll('.btn-guest');

    // 2. Lakukan perulangan untuk memasang event click ke setiap tombol
    tombolGuests.forEach(tombol => {
        tombol.addEventListener('click', function() {
            Swal.fire({
                title: 'Belum Login!',
                text: 'Harap login terlebih dahulu untuk menggunakan fitur ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Alihkan ke halaman login Laravel
                    window.location.href = "{{ route('login') }}"; 
                }
            });
        });
    });
</script>