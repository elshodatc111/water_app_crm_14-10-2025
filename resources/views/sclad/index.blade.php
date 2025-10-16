@extends('layouts.app')
@section('title', 'Omborxona')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif

<div class="pagetitle mb-4">
    <h1 class="fw-bold">Omborxona</h1>
    <nav>
        <ol class="breadcrumb bg-light p-2 rounded">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Omborxona</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Tayyor idishlar</h4>
                <h2 class="mt-0"><i class="bi bi-box-seam text-success"></i> {{  $res['tayyor'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Bo'sh idishlar</h4>
                <h2 class="mt-0"><i class="bi bi-droplet-half text-primary"></i> {{  $res['bush'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Nosoz idishlar</h4>
                <h2 class="mt-0"><i class="bi bi-exclamation-triangle text-danger"></i> {{  $res['nosoz'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-0">Xaydavchilarda</h4>
                <h2 class="mt-0"><i class="bi bi-truck text-warning"></i> {{  $res['currer'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4 col-md-6">
        <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#kirimModal">
            <i class="bi bi-box-arrow-in-down"></i>
            Omborga yangi idish kirim qilish
        </button>
    </div>
    <div class="col-lg-4 col-md-6">
        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#chiqimModal">
            <i class="bi bi-box-arrow-up"></i>
            Ombordan idishni chiqim qilish
        </button>
    </div>
    <div class="col-lg-4 col-md-6">
        <a class="btn btn-primary w-100" href="{{ route('sclad_currer') }}">
            <i class="bi bi-truck"></i>
            Haydovchilarga kirim chiqim tarixi
        </a>
    </div>
</div>

<div class="card g-4 mt-3">
    <div class="card-body">
        <h3 class="card-title">Ombordagi idishlar kirim chiqim tarixi</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kirim / Chiqim</th>
                        <th>Idishlar</th>
                        <th>Nosoz idishlar</th>
                        <th>Drektor</th>
                        <th>Izoh</th>
                        <th>Amaliyot vaqti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ScladTarix as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>
                                @if($item['status']=='kirim')
                                    Kirim
                                @else
                                    Chiqim
                                @endif
                            </td>
                            <td>{{ $item['idishlar'] }}</td>
                            <td>{{ $item['nosoz_idish'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['comment'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan=7 class="text-center">Omborxona tarixi mavjud emas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="kirimModal" tabindex="-1" aria-labelledby="kirimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title" id="kirimModalLabel">
                    <i class="bi bi-box-arrow-in-down me-2"></i> Yangi idish kirim qilish
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sclad_add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="idishlar" class="form-label">Yangi idishlar soni</label>
                        <input type="number" class="form-control" name="idishlar" min=1 placeholder="Nechta idish kirim qilinmoqda" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Kirim haqida izoh</label>
                        <textarea name="comment" required class="form-control"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Saqlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chiqimModal" tabindex="-1" aria-labelledby="chiqimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title" id="chiqimModalLabel">
                <i class="bi bi-box-arrow-up me-2"></i> Idish chiqim qilish
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sclad_delete') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="idishlar" class="form-label">Bosh idish soni</label>
                        <input type="number" class="form-control" name="idishlar" max={{ $res['bush'] }} value="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="nosoz_idish" class="form-label">Nosoz idish soni</label>
                        <input type="number" class="form-control" name="nosoz_idish" max={{ $res['nosoz'] }} value="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Chiqim haqida izoh</label>
                        <textarea name="comment" required class="form-control"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-send-check me-1"></i> Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
button[data-bs-toggle="modal"] {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
button[data-bs-toggle="modal"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
</style>



@endsection
