<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Models\Article;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Tests\TestCase;

class PublicWebRoutesTest extends TestCase
{
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Pelangi Glass');
        $response->assertSee('Konsultasi Gratis');
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get('/tentang');

        $response->assertStatus(200);
        $response->assertSee('Tentang Pelangi Glass');
        $response->assertSee('Visi Perusahaan');
    }

    public function test_product_catalog_renders_successfully(): void
    {
        $response = $this->get('/produk');

        $response->assertStatus(200);
        $response->assertSee('Katalog Produk');
    }

    public function test_product_detail_page_renders_for_existing_product(): void
    {
        $product = Product::query()->first();
        $this->assertNotNull($product, 'Seed product should exist');

        $response = $this->get("/produk/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_product_detail_page_returns_404_for_missing_product(): void
    {
        $response = $this->get('/produk/non-existent-product-slug');

        $response->assertStatus(404);
    }

    public function test_service_catalog_renders_successfully(): void
    {
        $response = $this->get('/servis');

        $response->assertStatus(200);
        $response->assertSee('Layanan');
    }

    public function test_service_detail_page_renders_for_existing_service(): void
    {
        $service = Service::query()->first();
        $this->assertNotNull($service, 'Seed service should exist');

        $response = $this->get("/servis/{$service->slug}");

        $response->assertStatus(200);
        $response->assertSee($service->name);
    }

    public function test_service_detail_page_returns_404_for_missing_service(): void
    {
        $response = $this->get('/servis/non-existent-service-slug');

        $response->assertStatus(404);
    }

    public function test_article_list_renders_successfully(): void
    {
        $response = $this->get('/artikel');

        $response->assertStatus(200);
        $response->assertSee('Artikel');
    }

    public function test_article_detail_page_renders_for_existing_article(): void
    {
        $article = Article::query()->first();
        $this->assertNotNull($article, 'Seed article should exist');

        $response = $this->get("/artikel/{$article->slug}");

        $response->assertStatus(200);
        $response->assertSee($article->title);
    }

    public function test_article_detail_page_returns_404_for_missing_article(): void
    {
        $response = $this->get('/artikel/non-existent-article-slug');

        $response->assertStatus(404);
    }

    public function test_promo_page_renders_successfully(): void
    {
        $response = $this->get('/promo');

        $response->assertStatus(200);
        $response->assertSee('Diskon Kaca Film V-KOOL & 3M');
        $response->assertSee('Terlaris');
    }

    public function test_promo_detail_page_renders_successfully(): void
    {
        $response = $this->get('/promo/promo-kaca-film-v-kool-3m');

        $response->assertStatus(200);
        $response->assertSee('Diskon Kaca Film V-KOOL & 3M');
        $response->assertSee('FILMPREMIUM25');
    }

    public function test_promo_detail_returns_404_for_missing_promo(): void
    {
        $response = $this->get('/promo/non-existent-promo-slug');

        $response->assertStatus(404);
    }

    public function test_inquiry_submission_validates_required_fields(): void
    {
        $response = $this->post('/kontak', []);

        $response->assertSessionHasErrors(['name', 'phone_number', 'message']);
    }

    public function test_inquiry_submission_saves_record_and_redirects_to_whatsapp(): void
    {
        $payload = [
            'name' => 'Budi Pratama',
            'phone_number' => '081234567890',
            'car_model' => 'Toyota Rush 2021',
            'service_type' => 'Pasang Kaca Film Full',
            'message' => 'Halo mau tanya estimasi biaya dan lama pengerjaan.',
        ];

        $response = $this->post('/kontak', $payload);

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Budi Pratama',
            'phone_number' => '081234567890',
            'status' => InquiryStatus::NEW->value,
        ]);

        $response->assertRedirect('/#kontak');
        $response->assertSessionHas('success');
        $response->assertSessionHas('wa_url');
    }

    public function test_inquiry_submission_with_honeypot_ignores_bot_and_does_not_save(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'phone_number' => '08999999999',
            'message' => 'Spam message',
            'website_hp_field' => 'http://spam-link.com',
        ];

        $response = $this->post('/kontak', $payload);

        $this->assertDatabaseMissing('inquiries', [
            'name' => 'Spam Bot',
        ]);

        $response->assertRedirect();
    }

    public function test_inquiry_submission_rate_limiting_blocks_after_limit(): void
    {
        $payload = [
            'name' => 'Rate Test',
            'phone_number' => '08123456789',
            'message' => 'Testing rate limit threshold.',
        ];

        // First 5 requests should pass (redirect to WhatsApp)
        for ($i = 0; $i < 5; $i++) {
            $res = $this->post('/kontak', $payload);
            $this->assertTrue(in_array($res->getStatusCode(), [302, 200]));
        }

        // 6th request within the same minute must be throttled with HTTP 429
        $response = $this->post('/kontak', $payload);
        $response->assertStatus(429);
    }

    public function test_layout_includes_turbo_and_alpine_intersect_plugins(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('@alpinejs/intersect', false);
        $response->assertSee('@hotwired/turbo', false);
    }

    public function test_catalogs_render_incremental_lazy_loading_and_image_lazy_load(): void
    {
        $productResponse = $this->get('/produk');
        $productResponse->assertStatus(200);
        $productResponse->assertSee('x-intersect', false);
        $productResponse->assertSee('loading="lazy"', false);

        $serviceResponse = $this->get('/servis');
        $serviceResponse->assertStatus(200);
        $serviceResponse->assertSee('x-intersect', false);
        $serviceResponse->assertSee('loading="lazy"', false);
    }

    public function test_setting_caching_and_whatsapp_helpers_work_correctly(): void
    {
        Setting::clearCache();
        $cached = Setting::allKeyed();
        $this->assertIsArray($cached);

        $cleanWa = Setting::cleanWhatsapp();
        $this->assertStringStartsWith('62', $cleanWa);

        $waUrl = Setting::whatsappUrl('Test Message');
        $this->assertStringContainsString('https://wa.me/', $waUrl);
        $this->assertStringContainsString('text=Test+Message', $waUrl);
    }

    public function test_home_page_renders_clickable_banners(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        // Banner link should be present on home page
        $response->assertSee('href="/servis"', false);
    }

    public function test_layout_includes_dark_mode_anti_fouc_and_toggle_switch(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        // Anti-FOUC theme script
        $response->assertSee('localStorage.getItem(\'theme\')', false);
        // Theme toggle button
        $response->assertSee('aria-label="Toggle theme"', false);
    }

    public function test_years_experience_synchronizes_between_home_and_about_pages(): void
    {
        Setting::set('years_experience', '30+', 'general');

        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('30+');

        $aboutRes = $this->get('/tentang');
        $aboutRes->assertStatus(200);
        $aboutRes->assertSee('30+');
    }
}
