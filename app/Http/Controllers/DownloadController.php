<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DownloadController extends Controller
{
    public function getDownload($model) {
        try {
            $title = $model;
            switch ($model) {
                case 'user':
                    $data = User::select('name as nama', 'address as alamat', 'phone_number as no_hp', 'specialist as spesialis')
                        ->get()->toArray();
                    $header = ['Nama', 'Alamat', 'No HP', 'Spesialis'];
                    $width = ['25%', '40%', '15%', '15%'];
                    $title = 'Daftar Dokter / Perawat';
                    break;
                case 'patient':
                    $data = Patient::select('medical_number as nomor_rekam_medis', 'name as nama', DB::raw("CONCAT(birth_place, ', ', DATE_FORMAT(birth_date, '%e %M %Y')) AS tempat_tanggal_lahir"),
                        'identity_number as nomor_identitas', 'identity_type as kartu_identitas', 'address as alamat', 'gender as jenis_kelamin', 'type as keperluan')
                        ->get()->toArray();
                    $header = ['Nomor Rekam Medis', 'Nama', 'Tempat Tanggal Lahir', 'Nomor Identitas', 'Kartu Identitas', 'Alamat', 'Jenis Kelamin', 'Keperluan'];
                    $width = ['9%', '15%', '15%', '15%', '5%', '20%', '8%', '8%'];
                    $title = 'Daftar Pasien';
                    break;
            }

            $convert = [
                'title' => $title,
                'header' => $header,
                'data' => $data,
                'width' => $width,
            ];
            $pdf = PDF::loadView('download', $convert);
            return $pdf->download($title.' '.Carbon::now()->format('d-m-Y').'.pdf');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
