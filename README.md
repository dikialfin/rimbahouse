## Deskripsi

API ini menyediakan endpoint untuk mengelola data pengguna, termasuk membuat, membaca, memperbarui, dan menghapus pengguna.
dibangun menggunakan laravel 12

## Instalasi

1.  Clone repositori:

    ```bash
    git clone https://github.com/dikialfin/rimbahouse.git
    ```

2.  Pindah directory:

    ```bash
    cd rimbahouse/rimba-api/
    ```

3.  Instal dependensi Composer:

    ```bash
    composer install
    ```

4.  Buat file bernama .env pada root project, salin isi file .example.env ke file .env yang telah dibuat

5.  Hasilkan kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

6.  Jalankan migrasi database:

    ```bash
    php artisan migrate
    ```

7.  Jalankan server pengembangan:

    ```bash
    php artisan serve
    ```

## API Documentation
http://your-server:your-port/api/documentation

## Cara menjalankan

1.  Buka aplikasi Postman.
2.  buat request baru
3.  Masukkan URL endpoint ke kolom URL.
4.  Pilih metode HTTP yang sesuai (GET, POST, PUT, DELETE).
5.  Jika diperlukan, tambahkan header dan body request.
6.  Klik tombol "Send".
7.  Periksa respons API di bagian bawah Postman.
