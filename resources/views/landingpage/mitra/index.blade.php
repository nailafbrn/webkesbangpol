@extends('landingpage.layouts.app')
@section('title', 'Mitra Kami')

@section('content')


    <!-- Mitra Kerja Sama Section -->
    <section class="mitra-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-3">Mitra Strategis</h2>
                <p class="section-lead">Lembaga dan instansi yang bekerja sama dengan Badan Kesbangpol</p>
                <div class="section-divider mx-auto"></div>
            </div>
            
            <div class="row g-4">
                @forelse ($mitraKerjaSama as $mitra)
                    <div class="col-md-6 col-lg-3 d-flex">
                        <a href="{{ route('mitra.show.detail', $mitra->id) }}" class="mitra-card-link">
                            <div class="mitra-card">
                                <div class="mitra-card-header">
                                    <div class="mitra-logo-container">
                                        @if($mitra->logo_lembaga)
                                            <img src="{{ asset('images/mitras/logo/' . $mitra->logo_lembaga) }}" 
                                                 alt="Logo {{ $mitra->nama_lembaga }}" 
                                                 class="mitra-logo">
                                        @else
                                            <div class="mitra-logo-placeholder">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mitra-card-body">
                                    <h5 class="mitra-card-title">{{ $mitra->nama_lembaga }}</h5>
                                    <p class="mitra-card-subtitle">{{ $mitra->ketua }}</p>
                                    <div class="mitra-card-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Data mitra strategis belum tersedia</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>



    <style>
        /* Section Styling */
        .mitra-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .partai-section {
            background: linear-gradient(135deg, #ffffff 0%, #f1f3f4 100%);
        }

        /* Section Header */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .section-lead {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .section-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #dc3545, #c82333);
            border-radius: 2px;
            margin-top: 1.5rem;
        }

        /* Mitra Card Styling */
        .mitra-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            width: 100%;
            height: 100%;
            transition: all 0.3s ease;
        }

        .mitra-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            position: relative;
        }

        .mitra-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .mitra-card-header {
            padding: 2rem 1.5rem 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .mitra-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .mitra-logo {
            max-height: 80px;
            max-width: 120px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .mitra-logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 2rem;
        }

        .mitra-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
        }

        .mitra-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            text-align: center;
            flex-grow: 1;
        }

        .mitra-card-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
            text-align: center;
            font-weight: 500;
        }

        .mitra-card-arrow {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            opacity: 0;
            transition: all 0.3s ease;
            color: #dc3545;
        }

        .mitra-card:hover .mitra-card-arrow {
            opacity: 1;
            transform: translateX(4px);
        }

        /* Partai Politik CTA */
        .partai-cta {
            background: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .partai-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            box-shadow: 0 4px 6px -1px rgba(220, 53, 69, 0.3);
        }

        .partai-cta-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .partai-cta-desc {
            color: #6c757d;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .btn-partai {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(220, 53, 69, 0.3);
        }

        .btn-partai:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(220, 53, 69, 0.4);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 400px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            
            .mitra-card-header {
                padding: 1.5rem 1rem 0.75rem;
            }
            
            .mitra-logo-container {
                height: 80px;
            }
            
            .mitra-logo {
                max-height: 60px;
            }
            
            .partai-cta {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.75rem;
            }
            
            .partai-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .partai-cta-title {
                font-size: 1.25rem;
            }
        }
    </style>
@endsection