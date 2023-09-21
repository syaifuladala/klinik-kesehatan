<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Dokter / Perawat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama'),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Email'),
                TextInput::make('password')
                    ->password(true)
                    ->minLength(8)
                    ->required()
                    ->hiddenOn('edit')
                    ->visibleOn('create')
                    ->currentPassword()
                    ->label('Password'),
                TextInput::make('passwordConfirmation')
                    ->required()
                    ->password()
                    ->dehydrated(false)
                    ->extraAttributes(['class' => 'password-toggle'])
                    ->label('Konfirmasi Password'),
                Textarea::make('address')
                    ->maxLength(255)
                    ->rows(3)
                    ->label('address'),
                TextInput::make('phone_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                TextInput::make('specialist')
                    ->label('Spesialis'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('No HP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('specialist')
                    ->label('Spesialis')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters(
                [
                    //
                ],
                layout: Layout::AboveContent,
            )
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
