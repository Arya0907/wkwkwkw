@extends('templates.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Riwayat Laporan</h1>

        @if ($reports->isEmpty())
            <p class="text-center text-muted">Belum pernah melaporkan apapun.</p>
        @else
            @foreach ($reports as $key => $report)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                        onclick="toggleDropdown({{ $key }})" style="cursor: pointer;">
                        <h5 class="mb-0">Pengaduan: {{ $report->created_at->format('d M Y H:i') }}</h5>
                        <span class="dropdown-icon" id="icon-{{ $key }}">&#9660;</span>
                    </div>
                    <div class="card-body dropdown-content" id="dropdown-{{ $key }}" style="display: none;">
                        <div class="header">
                            <h5 class="card-title mb-3">Detail Pengaduan</h5>
                        </div>
                        <div class="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                            <label class="btn btn-outline-primary active" onclick="toggleView('data', {{ $key }})">
                                Data
                            </label>
                            <label class="btn btn-outline-primary" onclick="toggleView('image', {{ $key }})">
                                Gambar
                            </label>
                            <label class="btn btn-outline-primary" onclick="toggleView('status', {{ $key }})">
                                Status
                            </label>
                        </div>

                        <!-- Data View -->
                        <div class="content-row" id="data-row-{{ $key }}">
                            <div class="data-content">
                                <p><strong>Deskripsi:</strong> {{ $report->description }}</p>
                                <p><strong>Email:</strong> {{ $report->user->email }}</p>
                                <p><strong>Alamat:</strong> {{ $report->province }}</p>
                                <p><strong>Type:</strong> {{ $report->type }}</p>
                            </div>
                        </div>

                        <!-- Image View -->
                        <div class="content-row d-none" id="image-row-{{ $key }}">
                            <div class="image-content text-center">
                                <img src="{{ asset('assets/images/' . ($report->image ?? 'default.jpg')) }}"
                                    class="img-fluid img-thumbnail" alt="Image of {{ $report->description }}"
                                    style="width: 200px; height: auto;">
                            </div>
                        </div>

                        <!-- Status View -->
                        <div class="content-row d-none" id="status-row-{{ $key }}">
                            <div class="status-content">
                                @if ($report->response && $report->response->response_status)
                                    <p><strong>Status:</strong> {{ $report->response->response_status }}</p>
                                    @if ($report->response->responseProgresses->isEmpty())
                                        <p class="text-muted">Belum ada progress yang tercatat.</p>
                                    @else
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-muted">History Progress:</h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($report->response->responseProgresses as $progress)
                                                        @foreach ($progress->histories as $history)
                                                            <li class="list-group-item">
                                                                <strong>{{ \Carbon\Carbon::parse($history['created_at'])->format('d M Y H:i') }}:</strong>
                                                                {{ $history['response_progress'] }}
                                                            </li>
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <p><strong>Status:</strong> Belum ada respon</p>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-id="{{ $report->id }}">Hapus</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Modal Hapus Pengaduan -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('report.destroy', ':id') }}" method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hapus Pengaduan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pengaduan "<span id="report-description"></span>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- JavaScript Toggle Dropdown with Smooth Animation -->
    <script>
        function toggleDropdown(reportIndex) {
            const dropdownContent = document.getElementById(`dropdown-${reportIndex}`);
            const dropdownIcon = document.getElementById(`icon-${reportIndex}`);

            if (dropdownContent.style.display === "none" || dropdownContent.style.maxHeight === "0px") {
                dropdownContent.style.display = "block";
                setTimeout(() => {
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                }, 10); // Small delay to apply transition
                dropdownIcon.innerHTML = '&#9650;';
            } else {
                dropdownContent.style.maxHeight = "0px";
                dropdownIcon.innerHTML = '&#9660;';
                setTimeout(() => {
                    dropdownContent.style.display = "none";
                }, 500); // Match this to the transition duration
            }
        }

        function toggleView(view, reportIndex) {
            const card = document.getElementById(`dropdown-${reportIndex}`);
            card.querySelectorAll('.content-row').forEach(row => row.classList.add('d-none'));
            const targetRow = card.querySelector(`#${view}-row-${reportIndex}`);
            if (targetRow) {
                targetRow.classList.remove('d-none');
            }
        }

        // Set report ID and description to modal for deletion
        document.querySelectorAll('[data-bs-target="#exampleModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const reportId = this.getAttribute('data-id');
                document.getElementById('delete-form').action = '/reports/' + reportId;
                document.getElementById('report-description').textContent = this.closest('.card-body')
                    .querySelector('.card-title').textContent.trim();
            });
        });
    </script>

    <style>
        .data-content,
        .image-content,
        .status-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card {
            border: none;
        }

        .card-header {
            background: #007bff;
            color: white;
        }

        .card-title {
            margin: 0;
        }

        .btn-group-toggle .btn {
            flex: 1;
        }

        .modal-content {
            border-radius: 10px;
        }

        .img-thumbnail {
            max-width: 200px;
        }

        .dropdown-icon {
            font-size: 1.5rem;
        }

        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }
    </style>
@endsection
