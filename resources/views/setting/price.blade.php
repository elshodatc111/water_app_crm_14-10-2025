@extends('layouts.app')
@section('title','Narxlar')
@section('content')
<div class="pagetitle">
    <h1>Narxlar sozlamalari</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Narxlar sozlamalari</li>
        </ol>
    </nav>
</div>
<div class="row ">
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title"></i>Narxlar sozlamasi</h4>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
                    </div>
                @endif
                <form action="{{ route('setting_price_update') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-droplet me-1 text-primary"></i> Suv narxi (1 dona)</label>
                        <input type="number" name="water_price" value="{{ old('water_price', $Setting['water_price'] ?? 0) }}" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-bucket me-1 text-info"></i> Suv idish narxi (1 dona)</label>
                        <input type="number" name="idish_price" value="{{ old('idish_price', $Setting['idish_price'] ?? 0) }}" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-truck me-1 text-success"></i> Haydovchi (1 dona suv uchun ish haqi)</label>
                        <input type="number" name="currer_price" value="{{ old('currer_price', $Setting['currer_price'] ?? 0) }}" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-box-seam me-1 text-warning"></i> Omborxona (1 dona suv ishlab chiqarish uchun ish haqi)</label>
                        <input type="number" name="sclad_price" value="{{ old('sclad_price', $Setting['sclad_price'] ?? 0) }}" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="bi bi-headset me-1 text-danger"></i> Operator (1 dona buyurtma uchun ish haqi)</label>
                        <input type="number" name="operator_price" value="{{ old('operator_price', $Setting['operator_price'] ?? 0) }}" class="form-control form-control-lg" required>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 w-100"> O'zgarishlarni saqlash</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
