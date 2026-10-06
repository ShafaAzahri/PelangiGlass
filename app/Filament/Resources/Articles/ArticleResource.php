<?php

namespace App\Filament\Resources\Articles;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\Articles\Pages\EditArticle;
use App\Filament\Resources\Articles\Pages\ListArticles;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\Action;
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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
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

    protected static string|\UnitEnum|null $navigationGroup = 'Artikel & Tips';

    protected static ?string $navigationLabel = 'Artikel & Tips';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel & Tips';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Konten Artikel')
                    ->description('Judul, kategori, ringkasan, dan isi lengkap artikel')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Artikel')
                            ->placeholder('Contoh: 5 Cara Merawat Kaca Mobil Agar Tetap Bening')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),
                        Grid::make(2)->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                        ]),
                        Textarea::make('excerpt')
                            ->label('Ringkasan / Excerpt')
                            ->placeholder('Ringkasan artikel untuk pratinjau di beranda...')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Isi Konten Artikel')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto & Publikasi')
                    ->description('Foto unggulan dan pengaturan jadwal tayang')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_image_preview')
                            ->label('Cover Artikel Aktif')
                            ->content(function (?Article $record): ?HtmlString {
                                if (! $record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);

                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <a href='{$url}' target='_blank' rel='noopener noreferrer' title='Klik untuk melihat cover ukuran penuh' style='display: block; cursor: pointer;'>
                                            <img src='{$url}' alt='Cover' style='width: 72px; height: 54px; min-width: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        </a>
                                        <div style='font-size: 11px; line-height: 1.4; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Cover Terpasang</div>
                                            <a href='{$url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;'>
                                                🔍 Lihat Resolusi Penuh ↗
                                            </a>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?Article $record) => $record !== null && ! empty($record->image_url)),
                        FileUpload::make('featured_image')
                            ->label('Upload / Ganti Cover')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('articles')
                            ->imagePreviewHeight('180')
                            ->openable()
                            ->downloadable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('💡 Rekomendasi Ukuran: 1200 × 675 px atau 800 × 450 px (Rasio 16:9 Landscape). Format: JPG, PNG, atau WebP (Maks. 5 MB).'),
                        Select::make('status')
                            ->label('Status Publikasi')
                            ->options(ArticleStatus::class)
                            ->default(ArticleStatus::PUBLISHED)
                            ->required(),
                        TextInput::make('read_time_minutes')
                            ->label('Estimasi Waktu Baca (Menit)')
                            ->numeric()
                            ->default(5),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Cover')
                    ->width(110)
                    ->height(72)
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-lg shadow-xs cursor-pointer hover:opacity-80 transition',
                        'title' => 'Klik untuk preview gambar',
                    ])
                    ->defaultImageUrl(fn (Article $record) => $record->image_url)
                    ->action(
                        Action::make('preview_cover')
                            ->modalHeading(fn (Article $record) => 'Preview Cover: '.$record->title)
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->modalContent(fn (Article $record) => new HtmlString("
                                <div style='display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 8px;'>
                                    <img src='{$record->image_url}' alt='{$record->title}' style='max-height: 65vh; max-width: 100%; border-radius: 8px; object-fit: contain; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);' />
                                    <a href='{$record->image_url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-size: 13px; font-weight: 500;'>
                                        Buka di tab baru (Resolusi Asli) ↗
                                    </a>
                                </div>
                            "))
                    ),
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
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
