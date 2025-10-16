@extends('layouts.app')
@section('title','Kassa')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif
<div class="pagetitle">
    <h1>Kassa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Kassa</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title"><i class="bi bi-box-seam text-primary"></i> Omborxonada mavjud</h5>
                <p class="text-muted mb-1">Naqt summa: <strong>{{ number_format($mavjud['balans_naqt'], 0, ',', ' ') }} UZS</strong></p>
                <p class="text-muted">Plastik summa: <strong>{{ number_format($mavjud['balans_plastik'], 0, ',', ' ') }} UZS</strong></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title mb-2 fw-bold"><i class="bi bi-hourglass-split text-warning"></i> Chiqim tasdiqlanish kutilmoqda</h5>
                <p class="text-muted mb-1">Naqt: <strong>{{ number_format($mavjud['pedding_naqt'], 0, ',', ' ') }} UZS</strong></p>
                <p class="text-muted">Plastik: <strong>{{ number_format($mavjud['pedding_plastik'], 0, ',', ' ') }} UZS</strong></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title mb-2 fw-bold"><i class="bi bi-truck text-success"></i> Haydovchilar balansida</h5>
                <p class="text-muted mb-1">Mahsulotlar soni: <strong>{{ $mavjud['xaydovchi_idishlar'] }} dona</strong></p>
                <p class="text-muted">Summa: <strong>{{ number_format($mavjud['xaydovchi_balans'], 0, ',', ' ') }} UZS</strong></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#chiqimModal">
                    <i class="bi bi-cash-coin me-2"></i> Kassadan chiqim qilish
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="chiqimModal" tabindex="-1" aria-labelledby="chiqimModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="chiqimModalLabel"><i class="bi bi-wallet2 me-2"></i> Kassadan chiqim qilish</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                </div>
                <div class="modal-body">
                    <form id="chiqimForm" action="{{ route('kassa_chiqim') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="summa_naqt" class="form-label">Chiqim summasi (Naqt)</label>
                            <input type="number" class="form-control" id="summa_naqt" name="summa_naqt" min=0 max={{ $mavjud['balans_naqt'] }} required>
                        </div>
                        <div class="mb-3">
                            <label for="summa_plastik" class="form-label">Chiqim summasi (Plastik)</label>
                            <input type="number" class="form-control" id="summa_plastik" name="summa_plastik" min=0 max={{ $mavjud['balans_plastik'] }} required>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Chiqim haqida</label>
                            <textarea class="form-control" id="desc" name="comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-2"></i> Chiqimni tasdiqlash
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('kassa_history') }}" class="btn btn-warning text-primary w-100 mt-3"><i class="bi bi-clock-history me-2"></i> Chiqimlar tarixi</a>
            </div>
        </div>
    </div>
</div>
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title"><i class="bi bi-hourglass-split text-warning"></i> Tasdiqlanmagan chiqimlar</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Omborchi</th>
                                <th>Naqt summa</th>
                                <th>Plastik summa</th>
                                <th>Chiqim haqida</th>
                                <th>Chiqim vaqti</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mavjud['peddin_list'] as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ number_format($item['summa_naqt'], 0, ',', ' ') }} UZS</td>
                                    <td>{{ number_format($item['summa_plastik'], 0, ',', ' ') }} UZS</td>
                                    <td>{{ $item['comment'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <form action="{{ route('kassa_chiqim_success') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                <button class="btn btn-primary px-1 py-0" title="Tasdiqlash">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('kassa_chiqim_cancel') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                <button class="btn btn-danger px-1 py-0" title="O‘chirish">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=7 class="text-center">Tasdiqlanmagan chiqimlar mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


        </div>
    </div>

@endsection
