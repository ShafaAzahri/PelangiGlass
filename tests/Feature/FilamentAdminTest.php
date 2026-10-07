<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

    public function test_authenticated_admin_can_access_gallery_services_products_and_articles_resources(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();

        $galleryRes = $this->actingAs($admin)->get('/admin/gallery-items');
        $galleryRes->assertStatus(200);
        $galleryRes->assertSee('Galeri Foto');

        $servicesRes = $this->actingAs($admin)->get('/admin/services');
        $servicesRes->assertStatus(200);
        $servicesRes->assertSee('Layanan & Servis');

        $productsRes = $this->actingAs($admin)->get('/admin/products');
        $productsRes->assertStatus(200);
        $productsRes->assertSee('Katalog Produk');

        $articlesRes = $this->actingAs($admin)->get('/admin/articles');
        $articlesRes->assertStatus(200);
        $articlesRes->assertSee('Artikel & Tips');
    }

    public function test_authenticated_admin_can_access_inquiries_faqs_and_testimonials_resources(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();

        $inquiriesRes = $this->actingAs($admin)->get('/admin/inquiries');
        $inquiriesRes->assertStatus(200);
        $inquiriesRes->assertSee('Pesan Masuk');

        $faqsRes = $this->actingAs($admin)->get('/admin/faqs');
        $faqsRes->assertStatus(200);
        $faqsRes->assertSee('FAQ');

        $testimonialsRes = $this->actingAs($admin)->get('/admin/testimonials');
        $testimonialsRes->assertStatus(200);
        $testimonialsRes->assertSee('Testimoni');

        $usersRes = $this->actingAs($admin)->get('/admin/users');
        $usersRes->assertStatus(200);
        $usersRes->assertSee('Pengguna');
    }

    public function test_authenticated_admin_can_access_category_resources(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();

        $prodCat = $this->actingAs($admin)->get('/admin/product-categories');
        $prodCat->assertStatus(200);

        $servCat = $this->actingAs($admin)->get('/admin/service-categories');
        $servCat->assertStatus(200);

        $artCat = $this->actingAs($admin)->get('/admin/article-categories');
        $artCat->assertStatus(200);

        $galCat = $this->actingAs($admin)->get('/admin/gallery-categories');
        $galCat->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_manage_about_page(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();
        $this->assertNotNull($admin, 'Admin user should be seeded');

        $response = $this->actingAs($admin)->get('/admin/manage-about');
        $response->assertStatus(200);
        $response->assertSee('Tentang Kami');
    }

    public function test_authenticated_admin_can_access_shield_roles_resource(): void
    {
        $admin = User::where('email', 'admin@pelangiglass.com')->first();
        $this->assertNotNull($admin, 'Admin user should be seeded');

        $response = $this->actingAs($admin)->get('/admin/shield/roles');
        $response->assertStatus(200);
    }

    public function test_staff_user_is_restricted_from_settings_resource(): void
    {
        $staff = User::firstOrCreate(
            ['email' => 'staff-test-unique@pelangiglass.com'],
            [
                'name' => 'Staf Test',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ]
        );

        $response = $this->actingAs($staff)->get('/admin/settings');
        $response->assertStatus(403);
    }

    public function test_staff_user_can_access_allowed_resources_like_articles_and_gallery(): void
    {
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $permArt = Permission::firstOrCreate(['name' => 'ViewAny:Article', 'guard_name' => 'web']);
        $permGal = Permission::firstOrCreate(['name' => 'ViewAny:GalleryItem', 'guard_name' => 'web']);
        $staffRole->givePermissionTo([$permArt, $permGal]);

        $staff = User::firstOrCreate(
            ['email' => 'staff-allowed-test@pelangiglass.com'],
            [
                'name' => 'Staf Allowed Test',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ]
        );
        $staff->assignRole($staffRole);

        $resArt = $this->actingAs($staff)->get('/admin/articles');
        $resArt->assertStatus(200);

        $resGal = $this->actingAs($staff)->get('/admin/gallery-items');
        $resGal->assertStatus(200);
    }
}
