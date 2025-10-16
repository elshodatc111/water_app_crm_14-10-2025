@extends('layouts.app01')
@section('title','Hodim haqida')
@section('content')
<div class="pagetitle">
    <h1>Hodim haqida</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hodimlar') }}">Hodimlar</a></li>
            <li class="breadcrumb-item">Hodim haqida</li>
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
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Hodim haqida</div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: 14px">
                        <tr>
                            <th>FIO</th>
                            <td style="text-align: right">{{ $user['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Telefon raqam</th>
                            <td style="text-align: right">{{ $user['phone'] }}</td>
                        </tr>
                        <tr>
                            <th>Login</th>
                            <td style="text-align: right">{{ $user['email'] }}</td>
                        </tr>
                        <tr>
                            <th>Lavozimi</th>
                            <td style="text-align: right">
                                @if($user['type']=='admin')
                                    Drektor
                                @elseif($user['type']=='operator')
                                    Operator
                                @elseif($user['type']=='omborchi')
                                    Omborchi
                                @else
                                    Xaydovchi
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Holati</th>
                            <td style="text-align: right">
                                @if($user['status']=='true')
                                    Aktiv
                                @else
                                    Ish faoliyati yakunlangan
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Hisoblangan ish haqi</th>
                            <td style="text-align: right">{{ number_format($user['balans'], 0, ',', ' ') }} UZS</td>
                        </tr>
                        <tr>
                            <th>Mavjud idishlar soni</th>
                            <td style="text-align: right">{{ number_format($user['idishlar'], 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <th>Qarzdorlik</th>
                            <td style="text-align: right">{{ number_format($user['currer_balans'], 0, ',', ' ') }} UZS</td>
                        </tr>
                    </table>
                    <a href="{{ route('hodim_password_update',$user['id']) }}" class="btn btn-primary w-100">Parolni yangilash</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Hodim ish haqi to'lash</div>
                <form action="{{ route('create_paymart') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                    <label for="amount">To‘lov summasi</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" class="form-control my-2" required>
                    @error('amount') <div class="text-danger small">{{ $message }}</div> @enderror
                    <label for="type">To‘lov turi</label>
                    <select name="type" class="form-select my-2" required>
                        <option value="">Tanlang</option>
                        <option value="naqt" {{ old('type') == 'naqt' ? 'selected' : '' }}>Naqt</option>
                        <option value="plastik" {{ old('type') == 'plastik' ? 'selected' : '' }}>Plastik</option>
                    </select>
                    @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                    <label for="description">To‘lov haqida</label>
                    <textarea name="description" class="form-control my-2" required>{{ old('description') }}</textarea>
                    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                    <button type="submit" class="btn btn-primary w-100 mt-2">To‘lovni saqlash</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Hodim ma'lumotlarini yangilash</h4>
                <form action="{{ route('hodim_update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                    <label for="name" class="form-label">Hodim F.I.O</label>
                    <input type="text" name="name" id="name" value="{{ $user['name'] }}" class="form-control my-2 @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    <label for="phone" class="form-label">Telefon raqami</label>
                    <input type="text" name="phone" id="phone" value="{{ $user['phone'] }}" class="form-control my-2 @error('phone') is-invalid @enderror phone" required >
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <label for="type" class="form-label">Lavozimi</label>
                    <select name="type" id="type" class="form-control my-2 @error('type') is-invalid @enderror" required >
                        <option value="">Tanlang</option>
                        <option value="admin" {{ $user['type'] == 'admin' ? 'selected' : '' }}>Direktor</option>
                        <option value="operator" {{ $user['type'] == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="omborchi" {{ $user['type'] == 'omborchi' ? 'selected' : '' }}>Omborchi</option>
                        <option value="currer" {{ $user['type'] == 'currer' ? 'selected' : '' }}>Haydovchi</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary w-100 mt-3"> O'zgarishlarni saqlash </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Hodim uchun to'langan ish haqi tarixi</div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>To'lov summasi</th>
                                <th>To'lov turi</th>
                                <th>To'lov haqida</th>
                                <th>Drektor</th>
                                <th>To'lov vaqti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paymarts as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ number_format($item['summa'], 0, ',', ' ') }} UZS</td>
                                    <td>{{ $item['type'] }}</td>
                                    <td>{{ $item['comment'] }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Ish haqi to'lovlari mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
