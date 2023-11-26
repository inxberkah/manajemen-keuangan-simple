<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manajemen Keuangan</title>
</head>
<body>

<div class="container">
    <h1>Manajemen Keuangan</h1>

    <form action="functions.php" method="post">
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <input type="text" name="keterangan">
        </div>

        <div class="form-group">
            <label for="pemasukan">Pemasukan:</label>
            <input type="number" name="pemasukan" placeholder="0" step="1">
        </div>

        <div class="form-group">
            <label for="pengeluaran">Pengeluaran:</label>
            <input type="number" name="pengeluaran" placeholder="0" step="1">
        </div>

        <button type="submit">Tambah Transaksi</button>
    </form>

    <?php include 'functions.php'; showFinancialSummary(); ?>

</div>

<!-- Script dibuat oleh @inxberkah -->

</body>
</html>
