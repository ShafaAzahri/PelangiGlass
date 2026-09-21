<?php

namespace App\Filament\Resources\Articles;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\Articles\Pages\EditArticle;
use App\Filament\Resources\Articles\Pages\ListArticles;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten & Publikasi';

    protected static ?string $navigationLabel = 'Artikel & Tips';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel & Tips';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status Publikasi')
                    ->options(ArticleStatus::class)
                    ->default(ArticleStatus::PUBLISHED)
                    ->required(),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->default(now()),
                TextInput::make('read_time_minutes')
                    ->label('Estimasi Waktu Baca (Menit)')
                    ->numeric()
                    ->default(5),
                Textarea::make('excerpt')
                    ->label('Ringkasan / Excerpt')
                    ->rows(2)
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Isi Konten Artikel')
                    ->required()
                    ->columnSpanFull(),
                Placeholder::make('current_image_preview')
                    ->label('Preview Foto Unggulan')
                    ->content(function (?Article $record): ?HtmlString {
                        if (!$record || empty($record->image_url)) {
                            return null;
                        }
                        $url = e($record->image_url);
                        return new HtmlString("
                            <div class='flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-xl'>
                                <img src='{$url}' alt='Preview Foto Artikel' class='h-20 w-28 object-cover rounded-lg shadow-sm border border-gray-300 dark:border-gray-600' />
                                <div class='text-xs space-y-1'>
                                    <div class='font-semibold text-gray-800 dark:text-gray-200'>Foto artikel aktif saat ini</div>
                                    <div class='text-gray-500 dark:text-gray-400 text-[11px] truncate max-w-xs'>{$url}</div>
                                    <div class='text-emerald-600 dark:text-emerald-400 text-[11px] font-medium'>✓ Terpasang. Kosongkan upload jika tidak ingin mengganti.</div>
                                </div>
                            </div>
                        ");
                    })
                    ->visible(fn (?Article $record) => $record !== null && !empty($record->image_url)),
                FileUpload::make('featured_image')
                    ->label('Upload Foto Unggulan Baru')
                    ->image()
                    ->directory('articles')
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto yang sudah ada.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Cover')
                    ->width(80)
                    ->height(55)
                    ->extraImgAttributes(['class' => 'object-cover rounded-md shadow-xs'])
                    ->defaultImageUrl(fn (Article $record) => $record->image_url),
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('read_time_minutes')
                    ->label('Waktu Baca')
                    ->formatStateUsing(fn ($state) => "{$state} mnt"),
                TextColumn::make('published_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(ArticleStatus::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
