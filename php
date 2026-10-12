<?php

interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

function formatRupiah(float $angka): string {
    return "Rp " . number_format($angka, 0, ',', '.');
}

class TransferBank implements MetodePembayaran {
    private string $nomorRekening;

    public function __construct(string $nomorRekening) {
        $this->nomorRekening = $nomorRekening;
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0;
        $total = $jumlah + $biayaAdmin;

        echo "=== " . $this->getNamaMetode() . " ===\n";
        echo "Nomor Rekening   : " . $this->nomorRekening . "\n";
        echo "Keterangan       : " . $keterangan . "\n";
        echo "Jumlah           : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (0%) : " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran : " . formatRupiah($total) . "\n";
        echo "Status           : Pembayaran Berhasil\n\n";
        return true;
    }

    public function getNamaMetode(): string {
        return "Transfer Bank";
    }
}

class QRIS implements MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.007; // 0.7%
        $total = $jumlah + $biayaAdmin;

        echo "=== " . $this->getNamaMetode() . " ===\n";
        echo "Keterangan         : " . $keterangan . "\n";
        echo "Jumlah             : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (0.7%) : " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran   : " . formatRupiah($total) . "\n";
        echo "Status             : Pembayaran Berhasil\n\n";
        return true;
    }

    public function getNamaMetode(): string {
        return "QRIS"; // Diperbaiki dari echo menjadi return string
    }
}

class KartuKredit implements MetodePembayaran {
    private string $empatDigitTerakhir;

    public function __construct(string $nomorKartu) {
        // Mengambil 4 digit terakhir dari nomor kartu
        $this->empatDigitTerakhir = substr($nomorKartu, -4);
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.025; // 2.5%
        $total = $jumlah + $biayaAdmin;

        echo "=== " . $this->getNamaMetode() . " ===\n";
        echo "Nomor Kartu       : ****-****-****-" . $this->empatDigitTerakhir . "\n";
        echo "Keterangan        : " . $keterangan . "\n";
        echo "Jumlah            : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (2.5%): " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran  : " . formatRupiah($total) . "\n";
        echo "Status            : Pembayaran Berhasil\n\n";
        return true;
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }
}

// --- CONTOH PENGGUNAAN (TESTING) ---

$bank = new TransferBank("1234567890");
$bank->prosesBayar(500000, "Pembayaran Tagihan Listrik");

$qris = new QRIS();
$qris->prosesBayar(150000, "Pembayaran Makanan di Restoran");

$cc = new KartuKredit("4111222233339999");
$cc->prosesBayar(1250000, "Belanja Elektronik Online");

?>
