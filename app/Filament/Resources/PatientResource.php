<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $modelLabel = 'Pasien';

    public static function form(Form $form): Form
    {
        $number = '0001';
        $dateFormat = Carbon::now()->format('my');
        $patient = Patient::select('medical_number')->latest()->first();
        if ($patient) {
            $matches = str_replace('RM' . $dateFormat, '', $patient->medical_number);
            $number = str_pad((int)$matches + 1, 4, '0', STR_PAD_LEFT);
        }

        $forms = [
            TextInput::make('medical_number')
                ->disabled()
                ->default('RM' . $dateFormat . $number)
                ->label('Nomor Rekam Medis'),
            TextInput::make('name')
                ->required()
                ->label('Nama'),
            TextInput::make('phone_number')
                ->required()
                ->label('No HP'),
            Select::make('gender')
                ->required()
                ->options([
                    'laki-laki' => 'Laki-laki',
                    'perempuan' => 'Perempuan',
                ])
                ->label('Jenis Kelamin'),
            TextInput::make('birth_place')
                ->required()
                ->label('Tempat Lahir'),
            DatePicker::make('birth_date')
                ->required()
                ->label('Tanggal Lahir'),
            Select::make('identity_type')
                ->required()
                ->options([
                    'ktp' => 'KTP',
                    'sim' => 'SIM',
                    'paspor' => 'Paspor',
                ])
                ->label('Kartu Identitas'),
            TextInput::make('identity_number')
                ->required()
                ->label('Nomor Identitas'),
            Textarea::make('address')
                ->required()
                ->label('Alamat'),
            Select::make('type')
                ->required()
                ->options([
                    'skhpn' => 'SKHPN',
                    'konsultasi' => 'Konsultasi',
                ])
                ->label('Keperluan'),
            Repeater::make('medicalReports')
                ->relationship('medicalReports')
                ->schema([
                    DateTimePicker::make('date')
                        ->disabled()
                        ->label('Tanggal Periksa'),
                    Select::make('user_id')
                        ->options(User::all()->pluck('name', 'id'))
                        ->disabled()
                        ->label('Dokter'),
                    RichEditor::make('note')
                        ->disabled()
                        ->columnSpan('full')
                        ->label('Catatan'),
                ])
                ->hiddenOn(['create', 'edit'])
                ->disabled()
                ->columns(2)
                ->columnSpan('full')
                ->label('Riwayat Pemeriksaan')
        ];
        return $form
            ->schema($forms);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'asc')
            ->columns([
                TextColumn::make('medical_number')
                    ->sortable()
                    ->searchable()
                    ->label('Nomor Rekam Medis'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama'),
                TextColumn::make('type')
                    ->sortable()
                    ->searchable()
                    ->label('Keperluan'),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->searchable()
                    ->label('Tanggal Daftar'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
