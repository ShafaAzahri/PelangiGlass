<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Models\Article;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicWebRoutesTest extends TestCase
{
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Home/Index')
            ->has('banners')
            ->has('featuredServices')
            ->has('galleryItems')
        );
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get('/tentang');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Tentang/Index')
        );
    }

    public function test_product_catalog_renders_successfully(): void
    {
        $response = $this->get('/produk');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Produk/Index')
            ->has('products')
            ->has('categories')
        );
    }

    public function test_product_detail_page_renders_for_existing_product(): void
    {
        $product = Product::query()->first();
        $this->assertNotNull($product, 'Seed product should exist');

        $response = $this->get("/produk/{$product->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Produk/Show')
            ->where('product.slug', $product->slug)
        );
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
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Servis/Index')
            ->has('services')
            ->has('categories')
        );
    }

    public function test_service_detail_page_renders_for_existing_service(): void
    {
        $service = Service::query()->first();
        $this->assertNotNull($service, 'Seed service should exist');

        $response = $this->get("/servis/{$service->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Servis/Show')
            ->where('service.slug', $service->slug)
        );
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
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Artikel/Index')
            ->has('articles')
        );
    }

    public function test_article_detail_page_renders_for_existing_article(): void
    {
        $article = Article::query()->first();
        $this->assertNotNull($article, 'Seed article should exist');

        $response = $this->get("/artikel/{$article->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Artikel/Show')
            ->where('article.slug', $article->slug)
        );
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
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Promo/Index')
            ->has('promos')
        );
    }

    public function test_promo_detail_page_renders_successfully(): void
    {
        $response = $this->get('/promo/promo-kaca-film-v-kool-3m');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Promo/Show')
            ->has('promo')
        );
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

        $response->assertRedirect();
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

    public function test_layout_includes_dark_mode_anti_fouc(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        // Anti-FOUC theme script on root shell
        $response->assertSee('localStorage.getItem(\'theme\')', false);
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

    public function test_shared_inertia_props_contain_site_settings_and_contact(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('settings')
            ->has('contact.whatsapp')
            ->has('contact.phone_display')
        );
    }
}
