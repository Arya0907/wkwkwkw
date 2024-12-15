@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <!-- Hero Section -->
        <div class="text-center bg-light p-5 rounded shadow">
            <h1 class="display-4 fw-bold text-primary mb-3">Selamat Datang di Website Pengaduan Masyarakat</h1>
            <p class="lead text-secondary">
                Tempat untuk melaporkan keluhan dan permasalahan yang sering dihadapi oleh masyarakat setempat. 
                Kami berkomitmen untuk menindaklanjuti setiap laporan dengan cepat dan transparan.
            </p>
            <a href="{{ route('report.index') }}" class="btn btn-lg btn-primary mt-3">Laporkan Keluhan Sekarang</a>
        </div>

        <!-- Features Section -->
        <div class="row mt-5 text-center">
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded">
                    <i class="bi bi-file-earmark-text display-3 text-primary"></i>
                    <h3 class="mt-3">Laporan Mudah</h3>
                    <p class="text-secondary">Laporkan keluhan Anda hanya dengan beberapa langkah cepat dan mudah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded">
                    <i class="bi bi-shield-check display-3 text-success"></i>
                    <h3 class="mt-3">Proses Transparan</h3>
                    <p class="text-secondary">Pantau perkembangan laporan Anda dengan sistem yang transparan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded">
                    <i class="bi bi-people display-3 text-warning"></i>
                    <h3 class="mt-3">Dukung Komunitas</h3>
                    <p class="text-secondary">Berpartisipasi aktif dalam membantu menyelesaikan masalah di lingkungan Anda.</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-5 p-4 bg-primary text-white text-center rounded">
            <h3 class="fw-bold">Laporkan Sekarang dan Bersama Kita Selesaikan Masalah!</h3>
            <a href="{{ route('report.index') }}" class="btn btn-light btn-lg mt-3">Buat Laporan</a>
        </div>
    </div>
@endsection
