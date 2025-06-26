@extends('dashboard.layouts.app')

@section('title', 'Dashboard')


@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="info-box h-100">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-newspaper"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Artikel</span>
                        <span class="info-box-number">{{ $count }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="info-box h-100">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dumbbell"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Program</span>
                        <span class="info-box-number">{{ $count2 }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="info-box h-100">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-university"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ormas</span>
                        <span class="info-box-number">{{ $count3     }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="info-box h-100">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total User</span>
                        <span class="info-box-number">{{ $count4 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop