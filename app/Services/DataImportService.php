<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;

class DataImportService
{
    public static function readRows(string $filePath): array
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'xlsx' && class_exists(XlsxReader::class)) {
            $reader = new XlsxReader();
            $reader->open($filePath);
            $rows = [];

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    $cells = [];
                    foreach ($row->getCells() as $cell) {
                        $cells[] = (string) $cell->getValue();
                    }
                    $rows[] = $cells;
                }
                break; // Only first sheet
            }

            $reader->close();
            return $rows;
        }

        // Default CSV / Plain text
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }

    public static function importProducts(string $filePath): int
    {
        $rows = static::readRows($filePath);
        if (count($rows) <= 1) {
            return 0;
        }

        // Header mapping
        $header = array_map(fn ($h) => strtolower(trim((string) $h)), array_shift($rows));
        $count = 0;

        foreach ($rows as $row) {
            if (empty(array_filter($row))) continue;

            $data = [];
            foreach ($header as $idx => $key) {
                $data[$key] = isset($row[$idx]) ? trim((string) $row[$idx]) : '';
            }

            $name = $data['nama_produk'] ?? $data['nama'] ?? $data['name'] ?? null;
            if (empty($name)) continue;

            $catName = $data['kategori'] ?? $data['category'] ?? 'Kaca Mobil';
            $category = ProductCategory::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'sort_order' => 1]
            );

            $priceStr = $data['harga'] ?? $data['price'] ?? null;
            $numericPrice = $priceStr ? (float) preg_replace('/[^0-9.]/', '', $priceStr) : null;

            $compatibility = $data['kompatibilitas'] ?? $data['kompatibilitas_mobil'] ?? $data['vehicle_compatibility'] ?? 'Universal';
            $shortDesc = $data['deskripsi'] ?? $data['deskripsi_singkat'] ?? $data['short_description'] ?? ($name . ' kualitas resmi Pelangi Glass.');

            $product = Product::firstOrNew(['name' => $name]);
            $product->slug = Str::slug($name);
            $product->category_id = $category->id;
            $product->estimated_price = $numericPrice;
            $product->vehicle_compatibility = $compatibility;
            $product->short_description = $shortDesc;
            $product->full_description = "<p>{$shortDesc}</p>";
            $product->is_active = true;
            $product->save();

            $count++;
        }

        return $count;
    }

    public static function importServices(string $filePath): int
    {
        $rows = static::readRows($filePath);
        if (count($rows) <= 1) {
            return 0;
        }

        $header = array_map(fn ($h) => strtolower(trim((string) $h)), array_shift($rows));
        $count = 0;

        foreach ($rows as $row) {
            if (empty(array_filter($row))) continue;

            $data = [];
            foreach ($header as $idx => $key) {
                $data[$key] = isset($row[$idx]) ? trim((string) $row[$idx]) : '';
            }

            $name = $data['nama_layanan'] ?? $data['nama'] ?? $data['name'] ?? null;
            if (empty($name)) continue;

            $catName = $data['kategori'] ?? $data['category'] ?? 'Layanan Umum';
            $category = ServiceCategory::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'sort_order' => 1]
            );

            $warranty = $data['garansi'] ?? $data['warranty_period'] ?? '1 Tahun';
            $duration = $data['durasi'] ?? $data['estimated_duration'] ?? '2 - 3 Jam';
            $desc = $data['deskripsi'] ?? $data['description'] ?? ($name . ' bergaransi resmi dari Pelangi Glass Purwokerto.');

            $service = Service::firstOrNew(['name' => $name]);
            $service->slug = Str::slug($name);
            $service->category_id = $category->id;
            $service->warranty_period = $warranty;
            $service->estimated_duration = $duration;
            $service->description = $desc;
            $service->process_steps = "<p>{$desc}</p>";
            $service->is_active = true;
            $service->save();

            $count++;
        }

        return $count;
    }

    public static function getProductCsvTemplate(): string
    {
        $csv = "nama_produk,kategori,harga,kompatibilitas_mobil,deskripsi_singkat\n";
        $csv .= "Kaca Depan Brio Satya Original,Kaca Mobil,1250000,Honda Brio 2013-2023,Kaca depan OEM standar keselamatan SNI tahan getaran anti-bocor.\n";
        $csv .= "Kaca Film Solar Gard Premium,Kaca Film,1800000,Universal Semua Mobil,Kaca film tolak panas tinggi 60% bergaransi resmi 5 tahun.\n";
        return $csv;
    }

    public static function getServiceCsvTemplate(): string
    {
        $csv = "nama_layanan,kategori,garansi,durasi,deskripsi\n";
        $csv .= "Pemasangan Kaca Depan Standar Pabrik,Ganti Kaca,1 Tahun,2 - 3 Jam,Pemasangan kaca depan presisi lem sealant polyurethane anti bocor.\n";
        $csv .= "Poles Kaca Jamur dan Water Repellent,Perawatan,3 Bulan,1 - 2 Jam,Pembersihan jamur kaca membandel disertai lapisan daun talas anti hujan.\n";
        return $csv;
    }
}
