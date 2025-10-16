@extends('layouts.app')
@section('title','Tasdiqmangan chiqimlar')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif
<div class="pagetitle">
    <h1>Tasdiqmangan chiqimlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kassa') }}">Kassa</a></li>
            <li class="breadcrumb-item">Tasdiqmangan chiqimlar</li>
        </ol>
    </nav>
</div>


<div class="card">
    <div class="card-body text-center">
        <h5 class="card-title"><i class="bi bi-hourglass-split text-warning"></i> Tasdiqmangan chiqimlar</h5>
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
                        <th>Drektor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($res as $item)
                        <tr>
                            <td>{{ $loop->index+1  }}</td>
                            <td>{{ $item['omborchi'] }}</td>
                            <td>{{ number_format($item['summa_naqt'], 0, ',', ' ') }} UZS</td>
                            <td>{{ number_format($item['summa_plastik'], 0, ',', ' ') }} UZS</td>
                            <td>{{ $item['comment'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['drejtor'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan=7 class="text-center">Tasdiqlangan chiqmlar mavjud emas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
