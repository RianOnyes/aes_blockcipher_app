<?php
include 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>AES Encryption Demo (PHP + OpenSSL)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body class="bg-light text-dark">
<div class="container mt-5">
    <h2 class="text-center mb-4">🔐 AES Encryption Demo (PHP + OpenSSL)</h2>

    <form method="post" class="card p-4">
        <div class="mb-3">
            <label for="inputText" class="form-label">Teks Input</label>
            <textarea name="inputText" id="inputText" class="form-control" rows="4" placeholder="Masukkan teks..."><?php echo htmlspecialchars($_POST['inputText'] ?? ''); ?></textarea>
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <label for="key" class="form-label">Kunci Rahasia</label>
                <input type="text" name="key" id="key" class="form-control" value="<?php echo htmlspecialchars($_POST['key'] ?? ''); ?>" placeholder="Masukkan kunci (min 4 karakter)">
                <div class="form-text">Kunci bebas — akan di-hash dan disesuaikan panjangnya (128/256-bit).</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Pilihan AES</label>
                <select name="method" class="form-select">
                    <option value="AES-128-CBC" <?php if(($_POST['method'] ?? '')==='AES-128-CBC') echo 'selected'; ?>>AES-128-CBC</option>
                    <option value="AES-256-CBC" <?php if(($_POST['method'] ?? '')==='AES-256-CBC') echo 'selected'; ?>>AES-256-CBC</option>
                </select>
                <div class="form-text">Mode: CBC. IV acak di-generate tiap enkripsi dan disertakan pada output (Base64).</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" name="encrypt" class="btn btn-primary">🔒 Enkripsi</button>
            <button type="submit" name="decrypt" class="btn btn-success">🔓 Dekripsi</button>
            <button type="submit" name="clear" class="btn btn-secondary">Clear</button>
        </div>
    </form>

    <div class="mt-4">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = $_POST['inputText'] ?? '';
            $key = $_POST['key'] ?? '';
            $method = $_POST['method'] ?? 'AES-128-CBC';

            if (strlen($key) < 1) {
                echo "<div class='alert alert-warning'>Kunci minimal 1 karakter.</div>";
            } else {
                if (isset($_POST['encrypt'])) {
                    $cipher = encryptAES($input, $key, $method);
                    echo "<div class='alert alert-primary'><b>Hasil Enkripsi (Base64 - IV + Ciphertext):</b><br><textarea class='form-control' rows='4'>".htmlspecialchars($cipher)."</textarea></div>";
                } elseif (isset($_POST['decrypt'])) {
                    $plain = decryptAES($input, $key, $method);
                    echo "<div class='alert alert-success'><b>Hasil Dekripsi:</b><br><textarea class='form-control' rows='4'>".htmlspecialchars($plain)."</textarea></div>";
                } elseif (isset($_POST['clear'])) {
                    // nothing
                }
            }
        }
        ?>
    </div>

    <div class="mt-3">
        <div class="card p-3">
            <h6>Petunjuk Singkat</h6>
            <ul>
                <li>Untuk enkripsi: masukkan plaintext dan kunci → pilih AES-128 atau AES-256 → klik Enkripsi.</li>
                <li>Salin seluruh output (Base64) ke field input untuk didekripsi — IV sudah disertakan di awal hasil Base64.</li>
                <li>Implementasi menggunakan <code>openssl_encrypt</code> dan <code>openssl_decrypt</code> (OPENSSL_RAW_DATA).</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
