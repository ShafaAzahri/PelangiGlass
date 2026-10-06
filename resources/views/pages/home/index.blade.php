@extends('layouts.app')

@section('content')

    <!-- 1. Hero Slider Banner -->
    @include('pages.home.sections.hero-slider')

    <!-- 2. Profil & Fasilitas Workshop -->
    @include('pages.home.sections.welcome-facilities')

    <!-- 3. Layanan Unggulan -->
    @include('pages.home.sections.services')

    <!-- 4. Keunggulan Nilai B-E-R-E-S -->
    @include('pages.home.sections.why-us')

    <!-- 5. Galeri Pengerjaan -->
    @include('pages.home.sections.gallery')

    <!-- 6. Testimoni Pelanggan -->
    @include('pages.home.sections.testimonials')

    <!-- 7. Artikel & Edukasi -->
    @include('pages.home.sections.articles-preview')

    <!-- 8. Pertanyaan Umum (FAQ) -->
    @include('pages.home.sections.faq')

    <!-- 9. Kontak Kami & Peta Lokasi Workshop -->
    @include('pages.home.sections.contact')

@endsection
