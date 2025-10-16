@extends('layouts.app')
@section('title', 'Xaydovchilar kirim chiqim tarixi')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif

<div class="pagetitle mb-4">
    <h1 class="fw-bold">Xaydovchilar kirim chiqim tarixi</h1>
    <nav>
        <ol class="breadcrumb bg-light p-2 rounded">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sclad') }}" class="text-decoration-none">Omborxona</a></li>
            <li class="breadcrumb-item active">Xaydovchilar kirim chiqim tarixi</li>
        </ol>
    </nav>
</div>

<div class="card g-4 mt-3">
    <div class="card-body">
        <h3 class="card-title">Xaydovchilar kirim chiqim tarixi</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center" style="font-size:14px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kirim / Chiqim</th>
                        <th>Xaydovchi</th>
                        <th>Tayyor idishlar</th>
                        <th>Bo'sh idishlar</th>
                        <th>Nosoz</th>
                        <th>Sotildi</th>
                        <th>Summa(Naqt)</th>
                        <th>Summa(Plastik)</th>
                        <th>Amaliyot holati</th>
                        <th>Amaliyot haqida</th>
                        <th>Amaliyot vaqti</th>
                        <th>Omborchi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($res as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>{{ $item['xaydovchi'] }}</td>
                            <td>{{ $item['tayyor'] }}</td>
                            <td>{{ $item['yarim_tayyor'] }}</td>
                            <td>{{ $item['nosoz'] }}</td>
                            <td>{{ $item['sotildi'] }}</td>
                            <td>{{ $item['summa_naqt'] }}</td>
                            <td>{{ $item['summa_plastik'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>{{ $item['comment'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['omborchi'] }}</td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
