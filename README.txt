=== AES Encryption Demo (PHP + OpenSSL) ===

Deskripsi:
Aplikasi demo AES menggunakan OpenSSL di PHP. Mendukung AES-128-CBC dan AES-256-CBC.
IV di-generate acak tiap enkripsi dan disertakan di awal hasil (Base64 encoded).

Cara pakai:
1. Ekstrak folder 'aes_blockcipher_app' ke direktori server lokal (htdocs/www).
2. Jalankan Apache (XAMPP/Laragon).
3. Buka: http://localhost/aes_blockcipher_app/
4. Masukkan teks dan kunci, pilih AES-128 atau AES-256, klik Enkripsi.
5. Salin seluruh hasil Base64 ke field input lalu klik Dekripsi untuk mengembalikan plaintext.

Catatan keamanan:
- Kunci di-derive menggunakan SHA-256 dan dipotong ke panjang yang diperlukan.
- Ini demo edukasi; untuk produksi gunakan manajemen kunci yang aman dan mode authenticated (GCM) jika perlu.
