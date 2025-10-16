@extends('layouts.app')
@section('title','Aktiv buyurtmalar')

@section('content')
<div class="pagetitle">
    <h1>Aktiv buyurtmalar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Aktiv buyurtmalar</li>
        </ol>
    </nav>
</div>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h3 class="card-title mb-0 pb-0">
                    <i class="bi bi-bag-check-fill text-primary me-2"></i> Aktiv buyurtmalar
                </h3>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addKlentModal">
                    <i class="bi bi-plus-circle me-1"></i> Yangi buyurtma
                </button>
            </div>

            <div class="modal fade" id="addKlentModal" tabindex="-1" aria-labelledby="addKlentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-3">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addKlentModalLabel">
                                <i class="bi bi-person-plus me-2"></i> Yangi buyurtma qo‘shish
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                        </div>
                        <form action="{{ route('create_clent') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label mt-2">Buyurtmachi FIO</label>
                                        <input type="text" id="name" name="name" class="form-control" value="FIO" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="phone" class="form-label mt-2">Telefon raqam</label>
                                        <input type="text" id="phone" name="phone" class="form-control phone" value="+998" placeholder="+998 90 123 45 67" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="region_id" class="form-label mt-2">Hudud</label>
                                        <select name="region_id" id="region_id" class="form-select" required>
                                            <option value="">Tanlang...</option>
                                            @foreach ($Region as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address" class="form-label mt-2">Yetqazish manzil</label>
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Paxtazor 32/16" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="order_count" class="form-label mt-2">Buyurtma soni</label>
                                        <input type="number" id="order_count" name="order_count" class="form-control" min="1" value="1">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3">
                                    <i class="bi bi-save2 me-1"></i> Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('aktive_kent') }}" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Telefon raqam orqali qidirish...">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('aktive_kent') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Ism</th>
                        <th>Telefon raqam</th>
                        <th>Manzil</th>
                        <th>Buyurtma soni</th>
                        <th>Buyurtma vaqti</th>
                        <th>Holati</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($klents as $index => $klent)
                        <tr>
                            <td>{{ $klents->firstItem() + $index }}</td>
                            <td><a href="{{ route('kent_show',$klent->id) }}">{{ $klent->name }}</a></td>
                            <td><i class="bi bi-telephone me-1 text-success"></i> {{ $klent->phone }}</td>
                            <td>{{ $klent->address ?? '—' }}</td>
                            <td><span class="badge bg-info">{{ $klent->order_count }}</span></td>
                            <td>
                                @if($klent->start_data)
                                    {{ \Carbon\Carbon::parse($klent->start_data)->format('Y-m-d H:i') }}
                                @else
                                    <span class="text-muted">Belgilanmagan</span>
                                @endif
                            </td>
                            <td>
                                @if($klent->status === 'active')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktiv</span>
                                @elseif($klent->status === 'pedding')
                                    <span class="badge bg-warning text-white"><i class="bi bi-hourglass-split me-1"></i> Yetqazilmoqda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Hozircha hech qanday aktiv buyurtma yo‘q
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Sahifalash --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $klents->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
