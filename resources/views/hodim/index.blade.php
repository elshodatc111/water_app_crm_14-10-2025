@extends('layouts.app')
@section('title','Aktiv hodimlar')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif
<div class="pagetitle">
    <h1>Hodimlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hodimlar</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Aktiv hodimlar</div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>#</th>
                            <th>FIO</th>
                            <th>Login</th>
                            <th>Lavozimi</th>
                            <th>Telefon raqami</th>
                            <th>Hisoblangan ish haqi</th>
                            <th>Idishlar soni</th>
                            <th>Hisoblangan qarzdorlik</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @forelse ($users_active as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left"><a href="{{ route('hodimlar_show', $item['id']) }}">{{ $item['name'] }}</a></td>
                                    <td>{{ $item['email'] }}</td>
                                    <td>
                                        @if($item['type']=='admin')
                                            Drektor
                                        @elseif($item['type']=='operator')
                                            Operator
                                        @elseif($item['type']=='omborchi')
                                            Omborchi
                                        @else
                                            Xaydovchi
                                        @endif
                                    </td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ number_format($item['balans'], 0, ',', ' ') }} UZS</td>
                                    <td>{{ number_format($item['idishlar'], 0, ',', ' ') }}</td>
                                    <td>{{ number_format($item['currer_balans'], 0, ',', ' ') }} UZS</td>
                                    <td>
                                        <form action="{{ route('hodim_status_update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name='id' value="{{ $item['id'] }}">
                                            <button type="submit" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan=8 class="text-center">
                                    Aktiv hodimlar mavjud emas.
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">Faoliyatini yakunlagan hodimlar</div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>#</th>
                            <th>FIO</th>
                            <th>Login</th>
                            <th>Lavozimi</th>
                            <th>Telefon raqami</th>
                            <th>Hisoblangan ish haqi</th>
                            <th>Hisoblangan qarzdorlik</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @forelse ($users_delete as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left"><a href="{{ route('hodimlar_show', $item['id']) }}">{{ $item['name'] }}</a></td>
                                    <td>{{ $item['email'] }}</td>
                                    <td>
                                        @if($item['type']=='admin')
                                            Drektor
                                        @elseif($item['type']=='operator')
                                            Operator
                                        @elseif($item['type']=='omborchi')
                                            Omborchi
                                        @else
                                            Xaydovchi
                                        @endif
                                    </td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ number_format($item['balans'], 0, ',', ' ') }} UZS</td>
                                    <td>{{ number_format($item['currer_balans'], 0, ',', ' ') }} UZS</td>
                                    <td>
                                        <form action="{{ route('hodim_status_update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name='id' value="{{ $item['id'] }}">
                                            <button type="submit" class="btn btn-success px-1 py-0"><i class="bi bi-check"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=8 class="text-center">
                                        Faoliyatin yakunlagan hodimlar mavjud emas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Yangi hodim qo'shish</h4>
                <form action="{{ route('hodim_create') }}" method="POST">
                    @csrf
                    <label for="name" class="form-label">Hodim F.I.O</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control my-2 @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    <label for="phone" class="form-label">Telefon raqami</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', '+998') }}" class="form-control my-2 @error('phone') is-invalid @enderror phone" required >
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <label for="type" class="form-label">Lavozimi</label>
                    <select name="type" id="type" class="form-control my-2 @error('type') is-invalid @enderror" required >
                        <option value="">Tanlang</option>
                        <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Direktor</option>
                        <option value="operator" {{ old('type') == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="omborchi" {{ old('type') == 'omborchi' ? 'selected' : '' }}>Omborchi</option>
                        <option value="currer" {{ old('type') == 'currer' ? 'selected' : '' }}>Haydovchi</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary w-100 mt-3"> Yangi hodimni saqlash </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
