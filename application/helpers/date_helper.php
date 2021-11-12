<?php
if (!function_exists('month')) {
    function month($bulan){
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
            default:
                $bulan = Date('F');
                break;
        }
        return $bulan;
    }
}

if (!function_exists('tanggal')) {
    function tanggal($tanggal) {
        $a = explode('-',$tanggal);
        $tanggal = $a['2']." ".month($a['1'])." ".$a['0'];
        return $tanggal;
    }
}
if (!function_exists('sumDuration')) {
    function sumDuration($times) {
        // loop throught all the times
        $all_seconds = null;
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $all_seconds += $hour * 3600;
            $all_seconds += $minute * 60; 
            $all_seconds += $second;

        }

        $total_minutes = floor($all_seconds/60); $seconds = $all_seconds % 60;  $hours = floor($total_minutes / 60); $minutes = $total_minutes % 60;

        // returns the time already formatted
        return sprintf('%02d:%02d:%02d', $hours, $minutes,$seconds);
    }
}