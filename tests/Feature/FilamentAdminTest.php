<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    public function test_admin_login_page_renders(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Pelangi Glass');
    }

    public function test_authenticated_admin_can_access_filament_dashboard(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();
        $this->assertNotNull($admin, 'Admin user should be seeded');

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_access_settings_resource(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();
        $response = $this->actingAs($admin)->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertSee('Nama Pengaturan');
        $response->assertSee('Nama Bengkel / Website');
    }

    public function test_authenticated_admin_can_access_hero_banners_resource(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();
        $response = $this->actingAs($admin)->get('/admin/hero-banners');

        $response->assertStatus(200);
        $response->assertSee('Banner Beranda');
        $response->assertSee('Gambar Preview');
    }
}
