<?php

if (! function_exists('rupiah')) {
    /**
     * Format angka menjadi mata uang Rupiah, contoh: Rp 1.500.000
     */
    function rupiah(float|int|string $angka): string
    {
        $hasil = number_format((float) $angka, 0, ',', '.');

        return $angka < 0 ? '- Rp '.ltrim($hasil, '-') : 'Rp '.$hasil;
    }
}
