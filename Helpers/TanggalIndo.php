<?php

namespace Helpers;

use DateTime;

class TanggalIndo {
    public static function formatIndo($tanggal)
    {
        $bulanIndo = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        list($tahun, $bulan, $hari) = explode('-', $tanggal);

        return $hari . ' ' . $bulanIndo[$bulan - 1] . ' ' . $tahun;
    }

    public static function hariIndo($tanggal){
        $datetime = DateTime::createFromFormat('Y-m-d', $tanggal);
        $hari = $datetime->format('l');

        return [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ][$hari] ?? $hari;
    }
}