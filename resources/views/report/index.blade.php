@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="fw-bold text-primary">Laporan Keluhan Masyarakat</h1>
            <p class="text-muted">Laporkan keluhan dan pantau laporan Anda dengan mudah.</p>
        </div>

        <!-- Tombol Tambah Laporan -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('report.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> Tambahkan Laporan
                </a>
                <form method="GET" action="{{ route('report.index') }}" class="d-flex gap-2">
                    <select name="province" id="province" class="form-select w-auto">
                        <option value="">Semua Provinsi</option>
                    </select>
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>
            </div>
        </div>

        <!-- Daftar Laporan -->
        <div class="row g-4">
            @forelse($reports as $report)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img src="{{ asset('assets/images/' . ($report->image ?? 'default.jpg')) }}" 
                            class="card-img-top rounded-top" 
                            alt="Gambar {{ $report->name ?? 'No Name' }}" 
                            style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold mb-2">{{ $report->type ?? 'Jenis Laporan' }}</h5>
                            <p class="text-secondary flex-grow-1">
                                {{ Str::limit($report->description ?? 'Deskripsi tidak tersedia', 80) }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="bi bi-envelope me-1"></i> {{ $report['user']['email'] ?? 'Email tidak tersedia' }}
                            </p>
                            <p id="province-{{ $report->id }}" class="text-muted">Lokasi: Memuat...</p>

                            <!-- Statistik Laporan -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="text-muted me-3">
                                        <i class="bi bi-eye"></i> {{ $report->viewers ?? 0 }}
                                    </span>
                                    <span class="text-danger">
                                        <i class="bi bi-heart" 
                                           id="love-{{ $report->id }}" 
                                           style="{{ $report->voting > 0 ? 'color: red;' : '' }}" 
                                           onclick="toggleLove({{ $report->id }})"></i>
                                        <span id="voting-count-{{ $report->id }}">{{ $report->voting ?? 0 }}</span>
                                    </span>
                                </div>
                                <span class="badge bg-primary">{{ $report->created_at->format('d M Y') ?? '' }}</span>
                            </div>

                            <!-- Tombol Detail -->
                            <a href="{{ route('report.show', ['id' => $report->id]) }}" class="btn btn-sm btn-outline-primary mt-3">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center py-4">
                        <i class="bi bi-info-circle me-2"></i> Tidak ada laporan yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @push('style')
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            body {
                background-color: #f8f9fa;
            }

            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-8px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endpush

    @push('script')
        <!-- Script Mengambil Data Provinsi -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reports = @json($reports);

                reports.forEach(report => {
                    const provinceId = report.province;
                    const provinceElement = document.getElementById(`province-${report.id}`);

                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
                        .then(response => response.json())
                        .then(provinces => {
                            const province = provinces.find(province => province.id == provinceId);
                            provinceElement.innerText = `Lokasi: ${province ? province.name : 'Lokasi tidak tersedia'}`;
                        })
                        .catch(error => {
                            provinceElement.innerText = 'Lokasi tidak tersedia';
                            console.error('Error fetching province data:', error);
                        });
                });

                const provinceSelect = document.getElementById('province');

                fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.id;
                            option.textContent = province.name;
                            provinceSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            });

            function toggleLove(reportId) {
    const heartIcon = document.getElementById('love-' + reportId);
    const votingCountElement = document.getElementById('voting-count-' + reportId);

    let isLoved = heartIcon.style.color === 'red';

    if (!isLoved) {
        heartIcon.style.color = 'red';
        votingCountElement.innerText = parseInt(votingCountElement.innerText) + 1; // Increment count
    } else {
        heartIcon.style.color = ''; // Remove red color
        votingCountElement.innerText = parseInt(votingCountElement.innerText) - 1; // Decrement count
    }

    // Mengirim request untuk mengupdate voting
    fetch(`/report/${reportId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ vote: !isLoved }) // Mengirimkan status vote (true/false)
    })
    .then(response => response.json())
    .then(data => {
        // Update voting count jika request sukses
        votingCountElement.innerText = data.voting_count; // Menampilkan jumlah vote yang sudah valid
    })
    .catch(error => console.error('Error:', error));
}


               
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
@endsection
