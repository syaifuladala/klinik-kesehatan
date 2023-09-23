<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalReportResource\Pages;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

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
                RichEditor::make('note')
                    ->columnSpan('full')
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
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
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Tanggal Periksa'),
                        Forms\Components\DatePicker::make('date_until')
                            ->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->columns(2),
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
            'view' => Pages\ViewMedicalReport::route('/{record}'),
            'edit' => Pages\EditMedicalReport::route('/{record}/edit'),
        ];
    }
}
