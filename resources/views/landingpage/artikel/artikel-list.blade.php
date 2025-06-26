<link rel="stylesheet" href="{{ asset('assets/css/articles.css') }}">

@if ($posts->count())
    <div id="artikel-list" class="row">
        @foreach ($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card artikel-card h-100" onclick="window.location.href='{{ route('isi-artikel', $post->slug) }}'">
                    <div class="artikel-card-img-wrapper">
                        <img src="{{ asset('images/posts/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ $post->created_at->format('d M Y') }}</p>
                        <p class="card-text artikel-desc">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200) }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $posts->links('components.custom-pagination') }}

    </div>
@else
    <div class="alert alert-warning">Tidak ada artikel ditemukan.</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua card artikel
        const articleCards = document.querySelectorAll('.artikel-card');
        
        articleCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Cari link "Baca Selengkapnya" di dalam card
                const readMoreLink = this.querySelector('a[href*="isi-artikel"]');
                
                if (readMoreLink) {
                    // Redirect ke halaman artikel
                    window.location.href = readMoreLink.href;
                }
            });
            
            // Tambahkan efek hover untuk menunjukkan card bisa diklik
            card.addEventListener('mouseenter', function() {
                this.style.cursor = 'pointer';
            });
        });
    });
</script>