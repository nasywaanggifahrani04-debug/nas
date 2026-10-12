<?php

// 1. Membuat Interface MetodePembayaran
interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

// 2 & 3. Class TransferBank (Biaya Admin 0%)
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
        $total = $jumlah + $biayaAdmin;

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "No. Rekening : " . $this->nomorRekening . "\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah Awal  : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin  : Rp " . number_format($biayaAdmin, 0, ',', '.') . "\n";
        echo "Total Bayar  : Rp " . number_format($total, 0, ',', '.') . "\n";
        echo "Status       : Berhasil\n\n";

        return true;
    }
}

// 2 & 3. Class QRIS (Biaya Admin 0.7%)
class QRIS implements MetodePembayaran {
    public function getNamaMetode(): string {
        return "QRIS";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.007; // 0.7%
        $total = $jumlah + $biayaAdmin;

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah Awal  : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin  : Rp " . number_format($biayaAdmin, 0, ',', '.') . "\n";
        echo "Total Bayar  : Rp " . number_format($total, 0, ',', '.') . "\n";
        echo "Status       : Berhasil\n\n";

        return true;
    }
}

// 2 & 3. Class KartuKredit (Biaya Admin 2.5% dengan 4 digit terakhir)
class KartuKredit implements MetodePembayaran {
    private string $nomorKartu;

    public function __construct(string $nomorKartu) {
        $this->nomorKartu = $nomorKartu;
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.025; // 2.5%
        $total = $jumlah + $biayaAdmin;
        
        // Mengambil 4 digit terakhir nomor kartu
        $empatDigitTerakhir = substr($this->nomorKartu, -4);

        echo "--- Informasi Pembayaran (" . $this->getNamaMetode() . ") ---\n";
        echo "No. Kartu    : ****-****-****-" . $empatDigitTerakhir . "\n";
        echo "Keterangan   : " . $keterangan . "\n";
        echo "Jumlah Awal  : Rp " . number_format($jumlah, 0, ',', '.') . "\n";
        echo "Biaya Admin  : Rp " . number_format($biayaAdmin, 0, ',', '.') . "\n";
        echo "Total Bayar  : Rp " . number_format($total, 0, ',', '.') . "\n";
        echo "Status       : Berhasil\n\n";

        return true;
    }
}

// ==========================================
// Contoh Penggunaan (Testing)
// ==========================================

$daftarPembayaran = [
    new TransferBank("8881234567"),
    new QRIS(),
    new KartuKredit("4532123456789999")
];

foreach ($daftarPembayaran as $metode) {
    $metode->prosesBayar(500000, "Pembayaran Langganan Bulanan");
}