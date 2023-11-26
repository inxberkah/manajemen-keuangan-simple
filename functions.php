<?php
include 'db.php';

// Fungsi untuk mendapatkan data transaksi berdasarkan ID
function getTransactionById($id) {
    global $conn;

    $query = "SELECT * FROM keuangan WHERE id=$id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Fungsi untuk menampilkan ringkasan keuangan
function showFinancialSummary() {
    global $conn;

    // Query untuk mendapatkan saldo
    $saldoQuery = "SELECT SUM(pemasukan) - SUM(pengeluaran) AS saldo FROM keuangan";
    $saldoResult = $conn->query($saldoQuery);
    $saldo = $saldoResult->fetch_assoc()['saldo'];

    // Query untuk mendapatkan total pemasukan
    $totalPemasukanQuery = "SELECT SUM(pemasukan) AS total_pemasukan FROM keuangan";
    $totalPemasukanResult = $conn->query($totalPemasukanQuery);
    $totalPemasukan = $totalPemasukanResult->fetch_assoc()['total_pemasukan'];

    // Query untuk mendapatkan total pengeluaran
    $totalPengeluaranQuery = "SELECT SUM(pengeluaran) AS total_pengeluaran FROM keuangan";
    $totalPengeluaranResult = $conn->query($totalPengeluaranQuery);
    $totalPengeluaran = $totalPengeluaranResult->fetch_assoc()['total_pengeluaran'];

    echo "<div class='summary-container'>";
    echo "<div class='summary-item'><p>Saldo:</p><span>Rp " . number_format($saldo, 2) . "</span></div>";
    echo "<div class='summary-item'><p>Total Pemasukan:</p><span>Rp " . number_format($totalPemasukan, 2) . "</span></div>";
    echo "<div class='summary-item'><p>Total Pengeluaran:</p><span>Rp " . number_format($totalPengeluaran, 2) . "</span></div>";
    echo "</div>";

    // Query untuk mendapatkan riwayat transaksi
    $transaksiQuery = "SELECT * FROM keuangan ORDER BY tanggal DESC";
    $transaksiResult = $conn->query($transaksiQuery);

    echo "<h2>Riwayat Transaksi:</h2>";
    echo "<table>";
    echo "<tr><th>Tanggal</th><th>Keterangan</th><th>Pemasukan</th><th>Pengeluaran</th><th>Aksi</th></tr>";
    while ($row = $transaksiResult->fetch_assoc()) {
        $tanggal = date('d-m-Y', strtotime($row['tanggal']));
        $keterangan = $row['keterangan'];
        $pemasukan = number_format($row['pemasukan'], 2);
        $pengeluaran = number_format($row['pengeluaran'], 2);

        echo "<tr>";
        echo "<td>$tanggal</td><td>$keterangan</td><td>Rp $pemasukan</td><td>Rp $pengeluaran</td>";
        echo "<td><a href='javascript:void(0);' onclick='confirmDelete(" . $row['id'] . ")'>Hapus</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Menambahkan transaksi baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST["tanggal"];
    $keterangan = $_POST["keterangan"];
    $pemasukan = empty($_POST["pemasukan"]) ? 0 : $_POST["pemasukan"];
    $pengeluaran = empty($_POST["pengeluaran"]) ? 0 : $_POST["pengeluaran"];

    // Cek apakah transaksi dengan tanggal dan keterangan tersebut sudah ada
    $isTransactionExist = isTransactionExist($tanggal, $keterangan);

    if (!$isTransactionExist) {
        $query = "INSERT INTO keuangan (tanggal, keterangan, pemasukan, pengeluaran) VALUES ('$tanggal', '$keterangan', $pemasukan, $pengeluaran)";
        $conn->query($query);
    }

    // Redirect kembali ke halaman index setelah menambahkan transaksi
    header("Location: index.php");
    exit();
}

// Menghapus transaksi
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM keuangan WHERE id=$id";
    $conn->query($deleteQuery);
    header("Location: index.php");
    exit();
}

// Fungsi untuk mengecek apakah transaksi dengan tanggal dan keterangan tertentu sudah ada
function isTransactionExist($tanggal, $keterangan) {
    global $conn;

    $query = "SELECT COUNT(*) as count FROM keuangan WHERE tanggal='$tanggal' AND keterangan='$keterangan'";
    $result = $conn->query($query);

    if ($result) {
        $count = $result->fetch_assoc()['count'];
        return $count > 0;
    }

    return false;
}
?>
