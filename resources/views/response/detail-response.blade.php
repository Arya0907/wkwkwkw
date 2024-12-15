@extends('templates.app')

@push('style')
<style>
    :root {
        --primary-color: #3b82f6;
        --secondary-color: #10b981;
        --text-color: #1f2937;
        --background-color: #f3f4f6;
    }

    body {
        background-color: var(--background-color);
        font-family: 'Inter', sans-serif;
    }

    .report-container {
        max-width: 800px;
        margin: 2rem auto;
        perspective: 1000px;
    }

    .report-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform-style: preserve-3d;
    }

    .report-card:hover {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
    }

    .report-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .report-image:hover {
        transform: scale(1.05);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: var(--primary-color);
        color: white;
    }

    .report-body {
        padding: 1.5rem;
        background-color: #f9fafb;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items-center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-success {
        background-color: var(--secondary-color);
        color: white;
    }

    .progress-form {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-top: 1rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endpush

@section('content')
<div class="report-container">
    <div class="report-card animate-fade-in">
        <!-- Report Header -->
        <!-- Report Image -->
        <img src="{{ asset('assets/images/' . (old('image', $report->image) ?? 'default.jpg')) }}" 
             class="report-image" 
             alt="Image of {{ old('name', $report->name) ?? 'No Name' }}">
        <div class="report-header">
            <div>
                <h1 class="text-xl font-bold flex items-center">
                    <span class="mr-2">👤</span> 
                    {{ old('user', $report->user->email) ?? 'Penulis tidak tersedia' }}
                </h1>
                <p class="text-sm flex items-center">
                    <span class="mr-2">📅</span>
                    {{ old('date', $report->created_at->format('Y-m-d')) ?? 'Tanggal tidak tersedia' }}
                </p>
            </div>
            <div id="province-name" class="text-lg font-semibold flex items-center">
                <span class="mr-2">🌆</span>
                Loading Province...
            </div>
        </div>


        <!-- Report Body -->
        <div class="report-body">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="mr-3">📝</span>
                {{ old('name', $report->description) ?? 'Nama tidak tersedia' }}
            </h2>

            <!-- Action Buttons -->
            <div class="btn-group">
                @if(is_null($report->response?->response_status))
                    <!-- Initial Status Buttons -->
                    <form action="{{ route('response.status', $report->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="response_status" value="ON_PROGRESS">
                        <button class="btn btn-primary w-full" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            Berikan Progres
                        </button>
                    </form>
                    <form action="{{ route('response.status', $report->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="response_status" value="REJECTED">
                        <button class="btn btn-danger w-full" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            Reject
                        </button>
                    </form>
                @elseif($report->response?->response_status === 'ON_PROGRESS')
                    <!-- On Progress Buttons -->
                    <form action="{{ route('response.update.status', $report->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="response_status" value="DONE">
                        <button class="btn btn-success w-full" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Nyatakan Selesai
                        </button>
                    </form>

                    <!-- Progress Form -->
                    <div class="w-full progress-form">
                        <form action="{{ route('response.progress', $report->id) }}" method="POST">
                            @csrf
                            <h4 class="text-lg font-semibold mb-4 flex items-center">
                                <span class="mr-2">📊</span>
                                Kirim Response Progress
                            </h4>
                            <div class="mb-4">
                                <textarea name="response_progress" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                                          rows="4" 
                                          placeholder="Tulis response progress..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <path d="M12 18v-6"></path>
                                    <path d="M9 15l3 3 3-3"></path>
                                </svg>
                                Kirim Progress
                            </button>
                        </form>
                    </div>
                @else
                    <div class="w-full bg-gray-100 p-4 rounded-lg text-center">
                        <h2 class="text-xl font-bold text-gray-700">
                            Status: {{ $report->response?->response_status }} 🏁
                        </h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch province name
        const provinceId = "{{ $report->province }}";
        const provinceElement = document.getElementById('province-name');

        fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
            .then(response => response.json())
            .then(provinces => {
                const province = provinces.find(p => p.id === provinceId);
                provinceElement.innerHTML = province 
                    ? `<span class="mr-2">🏙️</span> ${province.name}` 
                    : `<span class="mr-2">🌍</span> Unknown Province`;
            })
            .catch(error => {
                console.error('Error fetching province:', error);
                provinceElement.innerHTML = `<span class="mr-2">🌍</span> Province Not Found`;
            });
    });
</script>
@endpush