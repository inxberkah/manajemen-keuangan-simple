<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Transaksi</title>
</head>
<body>

<div class="container">
    <h1>Edit Transaksi</h1>

    <?php
    include 'functions.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $id = $_GET['id'];
        $transaction = getTransactionById($id);

        if ($transaction) {
            echo "<form action='functions.php?action=update&id=$id' method='post'>";
            echo "<label for='tanggal'>Tanggal:</label>";
            echo "<input type='date' name='tanggal' value='" . $transaction['tanggal'] . "' required>";

            echo "<label for='keterangan'>Keterangan:</label>";
            echo "<input type='text' name='keterangan' value='" . $transaction['keterangan'] . "'>";

            echo "<label for='pemasukan'>Pemasukan:</label>";
            echo "<input type='number' name='pemasukan' value='" . $transaction['pemasukan'] . "' placeholder='0.00' step='0.01'>";

            echo "<label for='pengeluaran'>Pengeluaran:</label>";
            echo "<input type='number' name='pengeluaran' value='" . $transaction['pengeluaran'] . "' placeholder='0.00' step='0.01'>";

            echo "<button type='submit'>Update Transaksi</button>";
            echo "</form>";
        } else {
            echo "<p>Transaksi tidak ditemukan.</p>";
        }
    } else {
        echo "<p>Data transaksi tidak valid.</p>";
    }
    ?>

</div>

</body>
</html>
