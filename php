<?php

// 1. Interface MetodePembayaran
interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

// 2 & 3. Class TransferBank
class TransferBank implements MetodePembayaran {
    private string $nomorRekening;

    public function __construct(string $nomorRekening) {
        $this->nomorRekening = $nomorRekening;
    }

    public function getNamaMetode(): string {
        return "Transfer Bank";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0; // 0%
        $totalBayar = $jumlah + ($jumlah * $biayaAdmin);

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Nomor Rekening  : " . $this->nomorRekening . "\n";
        echo "Jumlah Awal     : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin     : " . ($biayaAdmin * 100) . "%\n";
        echo "Total Bayar     : Rp " . number_format($totalBayar, 0, ',', '.') . "\n\n";

        return true;
    }
}

// 2 & 3. Class QRIS
class QRIS implements MetodePembayaran {
    public function getNamaMetode(): string {
        return "QRIS";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0.007; // 0.7%
        $totalBayar = $jumlah + ($jumlah * $biayaAdmin);

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Jumlah Awal     : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin     : 0.7%\n";
        echo "Total Bayar     : Rp " . number_format($totalBayar, 0, ',', '.') . "\n\n";

        return true;
    }
}

// 2 & 3. Class KartuKredit
class KartuKredit implements MetodePembayaran {
    private string $nomorKartu;

    public function __construct(string $nomorKartu) {
        // Menyimpan dan hanya menampilkan 4 digit terakhir
        $this->nomorKartu = substr($nomorKartu, -4);
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0.025; // 2.5%
        $totalBayar = $jumlah + ($jumlah * $biayaAdmin);

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Nomor Kartu     : ****-****-****-" . $this->nomorKartu . "\n";
        echo "Jumlah Awal     : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin     : 2.5%\n";
        echo "Total Bayar     : Rp " . number_format($totalBayar, 0, ',', '.') . "\n\n";

        return true;
    }
}

// --- Contoh Penggunaan (Testing) ---
$pembayaranList = [
    new TransferBank("1234567890"),
    new QRIS(),
    new KartuKredit("4532111122223333")
];

$jumlahTransaksi = 500000.0;
$keteranganTransaksi = "Pembelian Barang Elektronik";

foreach ($pembayaranList as $metode) {
    $metode->prosesBayar($jumlahTransaksi, $keteranganTransaksi);
}

