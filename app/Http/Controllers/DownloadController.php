<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DownloadController extends Controller
{
    public function getDownload($model)
    {
        try {
            $title = $model;
            switch ($model) {
                case 'user':
                    $data = User::select('name as nama', 'address as alamat', 'phone_number as no_hp', 'specialist as spesialis')
                        ->get()->toArray();
                    $header = ['Nama', 'Alamat', 'No HP', 'Spesialis'];
                    $width = ['25%', '40%', '15%', '15%'];
                    $title = 'Daftar Dokter - Perawat';
                    break;
                case 'patient':
                    $data = Patient::select(
                        'medical_number as nomor_rekam_medis',
                        'name as nama',
                        DB::raw("CONCAT(birth_place, ', ', DATE_FORMAT(birth_date, '%e %M %Y')) AS tempat_tanggal_lahir"),
                        'identity_number as nomor_identitas',
                        'identity_type as kartu_identitas',
                        'address as alamat',
                        'gender as jenis_kelamin',
                        'type as keperluan'
                    )
                        ->get()->toArray();
                    $header = ['Nomor Rekam Medis', 'Nama', 'Tempat Tanggal Lahir', 'Nomor Identitas', 'Kartu Identitas', 'Alamat', 'Jenis Kelamin', 'Keperluan'];
                    $width = ['9%', '15%', '15%', '15%', '5%', '20%', '8%', '8%'];
                    $title = 'Daftar Pasien';
                    break;
                case 'medical-report':
                    $report = DB::table('medical_reports')
                        ->select(
                            DB::raw("DATE_FORMAT(medical_reports.date, '%e %M %Y') AS tanggal_periksa"),
                            'patients.name as nama_pasien',
                            'users.name as nama_dokter',
                            'medical_reports.note as catatan'
                        )
                        ->join('patients', 'medical_reports.patient_id', '=', 'patients.id')
                        ->join('users', 'medical_reports.user_id', '=', 'users.id');

                    if (!empty(request()->input('date_from'))) {
                        $report = $report->where('medical_reports.date', '>=', Carbon::parse(request()->input('date_from'))->format('Y-m-d'));
                    }

                    if (!empty(request()->input('date_until'))) {
                        $report = $report->where('medical_reports.date', '<=', Carbon::parse(request()->input('date_until'))->format('Y-m-d'));
                    }

                    $report = $report->orderByDesc('medical_reports.date')->get();
                    $data = $report->map(function ($record) {
                        return [
                            'tanggal_periksa' => $record->tanggal_periksa,
                            'nama_pasien' => $record->nama_pasien,
                            'nama_dokter' => $record->nama_dokter,
                            'catatan' => $record->catatan,
                        ];
                    })->toArray();
                    $header = ['Tanggal Periksa', 'Nama Pasien', 'Nama Dokter', 'Catatan'];
                    $width = ['15%', '20%', '20%', '40%'];
                    $title = 'Daftar Medical Report';
            }

            $convert = [
                'title' => $title,
                'header' => $header,
                'data' => $data,
                'width' => $width,
            ];
            $pdf = PDF::loadView('download', $convert);
            return $pdf->download($title . ' ' . Carbon::now()->format('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getPatientDownload($id)
    {
        try {
            $patient = Patient::with('medicalReports')->find($id);
            $data = [
                'data' => $patient,
            ];
            $pdf = PDF::loadView('patient', $data);
            return $pdf->download('RM ' . $patient->name . ' ' . Carbon::now()->format('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
