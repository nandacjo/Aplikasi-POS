<?php

function format_uang($angka)
{
  return number_format($angka, 0, ',', '.');
}

function terbilang($angka)
{
  $angka = abs($angka);
  $baca = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
  $terbilang = '';

  if ($angka < 12) { // 1 - 11
    $terbilang = ' ' . $baca[$angka];
  } elseif ($angka < 20) { // 12 - 19
    $terbilang = terbilang($angka - 10) . ' belas';
  } elseif ($angka < 100) { // 20 - 99
    $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
  } elseif ($angka < 200) { // 100 - 199
    $terbilang = ' seratus' . terbilang($angka - 100);
  } elseif ($angka < 1000) { // 200 - 999
    $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
  } elseif ($angka < 2000) { // 1.000 - 1.999
    $terbilang = ' seribu' . terbilang($angka - 1000);
  } elseif ($angka < 1000000) { // 2.000 - 999.999
    $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
  } elseif ($angka < 1000000000) { // 1.000.000 - 999.999.999
    $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
  }

  return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
  $nama_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu');
  $nama_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

  // 2021-08-09
  $tahun = substr($tgl, 0, 4); // 2021
  $bulan = $nama_bulan[(int) substr($tgl, 5, 2)]; // 08
  $tanggal = substr($tgl, 8, 2); // 09
  $text = '';

  if ($tampil_hari) {
    $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
    $hari = $nama_hari[$urutan_hari];
    $text .= "$hari, $tanggal $bulan $tahun";
  } else {
    $text .= "$tanggal $bulan $tahun";
  }

  return $text;
}
