<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class DownloadController extends Controller
{
    public function getDownload($model) {
        try {
            $title = $model;
            switch ($model) {
                case 'user':
                    $data = User::select('name as nama', 'address as alamat', 'phone_number as hp', 'specialist as spesialis')
                        ->get()->toArray();
                    $header = ['Nama', 'Alamat', 'HP', 'Spesialis'];
                    $width = ['20%', '35%', '20%', '20%'];
                    $title = 'Dokter / Perawat';
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
