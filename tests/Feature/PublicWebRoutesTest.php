<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use App\Models\Article;
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
        $this->assertStringContainsString('https://wa.me/', $response->headers->get('Location'));
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
}
