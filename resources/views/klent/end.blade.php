@extends('layouts.app')
@section('title','Yakunlangan buyurtmalar')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Yopish"></button>
    </div>
@endif
<div class="pagetitle">
    <h1>Yakunlangan buyurtmalar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Yakunlangan buyurtmalar</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title w-100 text-center mb-0 pb-0">Yakunlangan buyurtmalar</h3>
        <div class="accordion accordion-flush" id="faq-group-2">

        </div>
    </div>
</div>

@endsection
