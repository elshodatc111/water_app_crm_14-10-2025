@extends('layouts.app01')
@section('title', 'Buyurtma haqida')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif

<div class="pagetitle">
    <h1><i class="bi bi-receipt-cutoff me-2"></i> Buyurtma haqida</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('aktive_kent') }}">Aktiv buyurtmalar</a></li>
            <li class="breadcrumb-item active">Buyurtma haqida</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center fw-bold">
                <i class="bi bi-person-circle me-2"></i> Buyurtmachi haqida
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Ismi:</span>
                        <strong>{{ $klent['name'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Telefon:</span>
                        <strong class="text-primary"><i class="bi bi-telephone me-1"></i> {{ $klent['phone'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Buyurtma soni:</span>
                        <strong>{{ $klent['count'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Manzil:</span>
                        <strong>{{ $klent['address'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Buyurtma vaqti:</span>
                        <strong>{{ $klent['start'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Operator:</span>
                        <strong>{{ $klent['operator'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>Hudud:</span>
                        <strong>{{ $klent['hudud'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🟨 Buyurtma tafsilotlari --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center fw-bold">
                <i class="bi bi-truck me-2"></i> Buyurtma tafsilotlari
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Holati:</span>
                        <strong>
                            @if($klent['status'] == 'active')
                                <span class="badge bg-primary"><i class="bi bi-check2-circle me-1"></i> Aktiv</span>
                            @elseif($klent['status'] == 'pedding')
                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Kutilmoqda</span>
                            @elseif($klent['status'] == 'cancel')
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Bekor qilingan</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i> Aktiv</span>
                            @endif
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Haydovchi:</span>
                        <strong>{{ $klent['currer_id'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Qabul qildi:</span>
                        <strong>{{ $klent['pedding_time'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Yetkazildi:</span>
                        <strong>{{ $klent['end_time'] }}</strong>
                    </div>
                </div>
                <button class="btn btn-outline-primary w-100 my-1" data-bs-toggle="modal" data-bs-target="#editOrderModal">
                    <i class="bi bi-pencil-square me-1"></i> Taxrirlash
                </button>
                <button class="btn btn-outline-primary w-100 my-1" data-bs-toggle="modal" data-bs-target="#editOrderAboutModal">
                    <i class="bi bi-chat-left-dots me-1"></i> Buyurtma haqida
                </button>
                <button class="btn btn-outline-danger w-100 my-1" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                    <i class="bi bi-x-octagon me-1"></i> Bekor qilish
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">
                        <i class="bi bi-pencil-square me-2"></i> Buyurtmani tahrirlash
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Buyurtmachi</label>
                            <input type="text" name="name" class="form-control" value="{{ $klent['name'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefon raqam</label>
                            <input type="text" name="phone" class="form-control phone" value="{{ $klent['phone'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Manzil</label>
                            <input type="text" name="address" class="form-control" value="{{ $klent['address'] }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hudud</label>
                            <select name="" class="form-select">
                                <option value="">Tanlang</option>
                            </select>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Saqlash
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editOrderAboutModal" tabindex="-1" aria-labelledby="editOrderAboutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderAboutModalLabel">
                        <i class="bi bi-pencil-square me-2"></i> Buyurtma haqida qo'shimcha izoh
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Buyurtmachi</label>
                            <input type="text" name="name" class="form-control" value="{{ $klent['name'] }}" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Saqlash
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header rounded-top-4">
                    <h5 class="modal-title" id="cancelOrderModalLabel">
                        <i class="bi bi-x-octagon me-2"></i> Buyurtmani bekor qilish
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="fw-semibold text-center">Haqiqatan ham bu buyurtmani bekor qilmoqchimisiz?</p>
                        <div class="mb-3">
                            <label class="form-label">Bekor qilish sababi</label>
                            <textarea name="cancel_reason" class="form-control" rows="3" placeholder="Sababni kiriting..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i> Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center fw-bold">
                <i class="bi bi-chat-left-dots me-2"></i> Buyurtma harakati
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Hodim</th>
                                <th>Izoh</th>
                                <th>Vaqt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Elshod Musurmonov</td>
                                <td>Test</td>
                                <td>2025-01-45 15:21:15</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="bi bi-inbox me-2"></i> Izohlar topilmadi
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
