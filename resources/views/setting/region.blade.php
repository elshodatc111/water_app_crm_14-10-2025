@extends('layouts.app')
@section('title','Hududlar')
@section('content')
<div class="pagetitle">
    <h1>Hududlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Hududlar</li>
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
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Barcha hududlar</div>
                <p style="color: red">Hudud o'chirilganda barcha aktiv buyurtmalar ham ochib ketadi.Ochirishdan oldin aktiv buyurtmalarni yakunlang.</p>
                <table class="table table-bordered">
                    <thead class="text-center">
                        <th>#</th>
                        <th>Hudud nomi</th>
                        <th>Hudud yaratildi</th>
                        <th>Meneger</th>
                        <th>Hududni o'chirish</th>
                    </thead>
                    <tbody>
                        @forelse ($region as $item)
                            <tr>
                                <td class="text-center">{{ $loop->index+1 }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['created_at'] }}</td>
                                <td>{{ $item['user']['name'] }}</td>
                                <td class="text-center">
                                    <form action="{{ route('setting_region_delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan=5 class="text-center">Hududlar mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Yangi hudud qo'shish</h4>
                <form action="{{ route('setting_region_create') }}" method="POST">
                    @csrf
                    <label for="name">Hudud nomi</label>
                    <input type="text" name="name" required class="form-control my-2">
                    <button class="btn btn-primary w-100 mt-2">Yangi hududni saqlash</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
