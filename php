<?php

// 1. Membuat Interface MetodePembayaran
interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

// Fungsi helper untuk format Rupiah Indonesia (contoh: Rp 500.000)
function formatRupiah(float $angka): string {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// 2 & 3. Class TransferBank (Biaya Admin 0%)
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

// 2 & 3. Class QRIS (Biaya Admin 0.7%)
class QRIS implements MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.007;
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
        echo "QRIS";
    }
}

// 2 & 3. Class KartuKredit (Biaya Admin 2.5%, Tampilkan 4 digit terakhir)
class KartuKredit implements MetodePembayaran {
    private string $empatDigitTerakhir;

    public function __construct(string $nomorKartu) {
        // Mengambil 4 digit terakhir dari nomor kartu
        $this->empatDigitTerakhir = substr($nomorKartu, -4);
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.025;
        $total = $jumlah + $biayaAdmin;

        echo "=== " . $this->getNamaMetode() . " ===\n";
        echo "Nomor Kartu      : ****-****-****-" . $this->empatDigitTerakhir . "\n";
        echo "Keterangan       : " . $keterangan . "\n";
        echo "Jumlah           : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (2.5%): " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran : " . formatRupiah($total) . "\n";
        echo "Status           : Pembayaran Berhasil\n\n";
        return true;
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }
}

// --- CONTOH PENGGUNAAN (TESTING) ---

// 1. Transfer Bank
$bank = new TransferBank("1234567890");
$bank->prosesBayar(500000, "Pembayaran Tagihan Listrik");

// 2. QRIS
$qris = new QRIS();
$qris->prosesBayar(150000, "Pembayaran Makanan di Restoran");

// 3. Kartu Kredit
$cc = new KartuKredit("4111222233339999");
$cc->prosesBayar(1250000, "Belanja Elektronik Online");

?>