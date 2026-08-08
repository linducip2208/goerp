<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationGroup = '📝 Content';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 101;
    protected static ?string $modelLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required()
                    ->label('Penulis'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (callable $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->label('Slug'),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->label('Konten'),
                Forms\Components\Textarea::make('excerpt')
                    ->columnSpanFull()
                    ->label('Ringkasan'),
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->label('Gambar Utama'),
                Forms\Components\Toggle::make('is_published')
                    ->required()
                    ->label('Dipublikasikan'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi'),
                Forms\Components\TextInput::make('meta_title')
                    ->maxLength(255)
                    ->label('Meta Title'),
                Forms\Components\TextInput::make('meta_description')
                    ->maxLength(255)
                    ->label('Meta Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tgl Publikasi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
