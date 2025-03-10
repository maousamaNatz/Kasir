<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Memformat harga untuk tampilan (contoh: Rp 1.000.000,00)
     */
    public function formatForDisplay($amount)
    {
        if (is_null($amount)) {
            return 'Rp 0,00';
        }
        return 'Rp ' . number_format($amount, 2, ',', '.');
    }

    /**
     * Menyaring input mata uang untuk database (menghapus Rp, titik, dan koma)
     */
    public function filterForDatabase($amount)
    {
        // Jika input adalah string seperti "Rp 1.000.000,00" atau "1000000,00"
        $cleaned = str_replace(['Rp ', '.', ','], ['', '', '.'], $amount);
        return (float) $cleaned; // Konversi ke float untuk database
    }
}
