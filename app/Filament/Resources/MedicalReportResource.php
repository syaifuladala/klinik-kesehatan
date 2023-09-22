<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalReportResource\Pages;
use App\Filament\Resources\MedicalReportResource\RelationManagers;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicalReportResource extends Resource
{
    protected static ?string $model = MedicalReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        $patients = Patient::orderBy('name')->get()->pluck('name', 'id')->toArray();
        $users = User::orderBy('name')->get()->pluck('name', 'id')->toArray();
        return $form
            ->schema([
                DateTimePicker::make('date')
                    ->default('now')
                    ->disabled()
                    ->required()
                    ->label('Tanggal Periksa'),
                Select::make('patient_id')
                    ->options($patients)
                    ->searchable()
                    ->required()
                    ->label('Pasien'),
                Select::make('user_id')
                    ->options($users)
                    ->searchable()
                    ->required()
                    ->label('Pasien'),
                MarkdownEditor::make('note')
                    ->columnSpan('full')
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->searchable()
                    ->label('Tanggal Periksa'),
                TextColumn::make('patient.name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Pasien'),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Dokter'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMedicalReports::route('/'),
            'create' => Pages\CreateMedicalReport::route('/create'),
            'edit' => Pages\EditMedicalReport::route('/{record}/edit'),
        ];
    }
}
