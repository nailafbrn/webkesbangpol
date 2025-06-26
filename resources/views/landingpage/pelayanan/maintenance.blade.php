@extends('landingpage.layouts.app')

@section('title', 'Halaman Belum Tersedia')

@section('content')
<div class="coming-soon-wrapper">
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="coming-soon-content">
        <div class="coming-soon-icon">🚧</div>
        
        <h1>Halaman Belum Tersedia</h1>
        
        <p>
            Halaman yang Anda cari sedang dalam tahap pengembangan. Kami bekerja keras 
            untuk segera menyelesaikannya dan memberikan fitur terbaik untuk Anda.
        </p>

        <div class="coming-soon-features">
            <div class="feature-item">
                <div class="feature-icon">💻</div>
                <div class="feature-text">Sedang Dikembangkan</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🎯</div>
                <div class="feature-text">Fitur Canggih</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🚀</div>
                <div class="feature-text">Segera Hadir</div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-text">Progress Pengembangan: 50%</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 50%;"></div>
            </div>
        </div>

        <p>
            <strong>Estimasi waktu rilis:</strong> 1-2 bulan ke depan<br>
            Nantikan update selanjutnya dari kami!
        </p>

    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .coming-soon-wrapper {
        min-height: 80vh;
        background: #B40D14;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Animated background elements */
    .bg-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    .shape:nth-child(4) {
        width: 100px;
        height: 100px;
        top: 10%;
        right: 30%;
        animation-delay: 1s;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 1;
        }
    }

    .coming-soon-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        max-width: 600px;
        padding: 40px 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 1s ease-out;
        margin: 20px;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .coming-soon-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .coming-soon-content h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .coming-soon-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 30px;
        opacity: 0.9;
    }

    .coming-soon-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .feature-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .feature-text {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .progress-container {
        margin: 30px 0;
    }

    .progress-text {
        margin-bottom: 10px;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #ff6b6b, #feca57);
        border-radius: 10px;
        width: 75%;
        position: relative;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }
        100% {
            background-position: 200px 0;
        }
    }

    .contact-info {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .contact-info a {
        color: #feca57;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .contact-info a:hover {
        color: #ff6b6b;
    }

    .social-links {
        margin-top: 20px;
    }

    .social-links a {
        display: inline-block;
        margin: 0 10px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: transform 0.3s ease, background 0.3s ease;
        text-decoration: none;
        color: white;
    }

    .social-links a:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .coming-soon-content {
            margin: 20px;
            padding: 30px 20px;
        }
        
        .coming-soon-content h1 {
            font-size: 2rem;
        }
        
        .coming-soon-icon {
            font-size: 3rem;
        }
        
        .coming-soon-features {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .coming-soon-content h1 {
            font-size: 1.5rem;
        }
        
        .coming-soon-content p {
            font-size: 1rem;
        }
    }
</style>


<script>
    // Optional: Show current time for development tracking
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleString('id-ID');
        console.log('Page checked at:', timeString);
    }
    
    setInterval(updateTime, 60000); // Update setiap menit
    updateTime(); // Initial call

    // Optional: Simple visitor tracking (for development purposes)
    console.log('Coming Soon page loaded successfully');
</script>
@endsection
