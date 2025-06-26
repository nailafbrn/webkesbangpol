import $ from 'jquery';
import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import * as pdfjsLib from 'pdfjs-dist';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import html2canvas from 'html2canvas';
import Chart from 'chart.js/auto';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css'; // biar stylenya ikut


window.Chart = Chart;

window.$ = $;
window.jQuery = $;
window.toastr = toastr;
window.html2canvas = html2canvas;

// Set the worker path correctly for Vite
pdfjsLib.GlobalWorkerOptions.workerSrc = new URL(
    'pdfjs-dist/build/pdf.worker.mjs',
    import.meta.url
).toString();

// Make pdfjsLib available globally if needed
window.pdfjsLib = pdfjsLib;

// Inisialisasi AOS (animasi scroll)
AOS.init();



document.addEventListener('DOMContentLoaded', function () {


    // ===== CKEDITOR5 =====
    const editorElement = document.querySelector('#editor');

    if (editorElement) {
        ClassicEditor
        .create(editorElement, {
            toolbar: [
            'undo', 'redo', '|',
            'heading', '|',
            'bold', 'italic', '|', 'link', 'blockQuote','|',
            'bulletedList', 'numberedList',  '|',
            'indent', 'outdent', '|',   // 👈 ini tambahan indent/outdent
            ]
        })
        .then(editor => {
            console.log('Editor berhasil diinisialisasi', editor);
        })
        .catch(error => {
            console.error(error);
        });
    }

    const editorIDs = ['editor1', 'editor2', 'editor3', 'editor4', 'tentang'];

    editorIDs.forEach(id => {
        const editorElement = document.getElementById(id);
        if (editorElement) {
        ClassicEditor
            .create(editorElement, {
                toolbar: [
                'undo', 'redo', '|',
                'heading', '|',
                'bold', 'italic', '|', 'link', 'blockQuote','|',
                'bulletedList', 'numberedList',  '|',
                'indent', 'outdent', '|',   // 👈 ini tambahan indent/outdent
                ]
            })
            .then(editor => {
            console.log(`Editor untuk ${id} berhasil`, editor);
            })
            .catch(error => {
            console.error(`Editor untuk ${id} gagal:`, error);
            });
        }
    });


    // ===== SWIPER ARTIKEL =====
    const artikelSwiperElement = document.querySelector('.artikelSwiper');
    const btnArtikelPrev = document.querySelector('.swiper-prev');
    const btnArtikelNext = document.querySelector('.swiper-next');
    const artikelIndicator = document.querySelector('.swiper-current-index');

    if (artikelSwiperElement) {
        const artikelSwiper = new Swiper(artikelSwiperElement, {
            loop: document.querySelectorAll('.artikelSwiper .swiper-slide').length >= 2,
            autoplay: document.querySelectorAll('.artikelSwiper .swiper-slide').length >= 2 ? {
                delay: 5000,
                disableOnInteraction: false,
            } : false,
            effect: 'slide',
            speed: 1000,
            allowTouchMove: document.querySelectorAll('.artikelSwiper .swiper-slide').length >= 2,
            // Add spacing control options
            spaceBetween: 0, // Remove space between slides
            slidesPerView: 1, // Show exactly one slide at a time
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            on: {
                init: function () {
                    updateArtikelPagination(this);
                    toggleArtikelNavigation(this);
                },
                slideChange: function () {
                    updateArtikelPagination(this);
                },
            },
        });

        // Make window.artikelSwiper available globally for external updates
        window.artikelSwiper = artikelSwiper;

        function updateArtikelPagination(swiperInstance) {
            const current = swiperInstance.realIndex + 1;
            const total = document.querySelectorAll('.artikelSwiper .swiper-slide').length;
            if (artikelIndicator) {
                artikelIndicator.textContent = `${current} dari ${total}`;
            }
        }

        function toggleArtikelNavigation(swiperInstance) {
            const totalSlides = document.querySelectorAll('.artikelSwiper .swiper-slide').length;
            const isActive = totalSlides >= 2;
            if (btnArtikelPrev && btnArtikelNext) {
                btnArtikelPrev.style.display = isActive ? 'inline-block' : 'none';
                btnArtikelNext.style.display = isActive ? 'inline-block' : 'none';
            }
            if (artikelIndicator) {
                artikelIndicator.style.display = isActive ? 'inline-block' : 'none';
            }
        }
    }



    // ===== SWIPER CAROUSEL =====
    const carouselSwiper = new Swiper('.mySwiperCarousel', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'slide',
        speed: 1000,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        on: {
            init: function () {
                updateCustomPagination(this);
                // Show navigation on hover
                document.querySelector('.mySwiperCarousel').addEventListener('mouseenter', function() {
                    document.querySelectorAll('.custom-swiper-button').forEach(btn => {
                        btn.style.display = 'flex';
                    });
                });
                document.querySelector('.mySwiperCarousel').addEventListener('mouseleave', function() {
                    document.querySelectorAll('.custom-swiper-button').forEach(btn => {
                        btn.style.display = 'none';
                    });
                });
            },
            slideChange: function () {
                updateCustomPagination(this);
            }
        }
    });

    function updateCustomPagination(swiperInstance) {
        const current = swiperInstance.realIndex + 1;
        const total = swiperInstance.slides.length - swiperInstance.loopedSlides * 2;
        const indicator = document.querySelector('.swiper-custom-indicator');
        if (indicator) {
            indicator.textContent = `${current} dari ${total}`;
        }
    }

    // === FANCYBOX GALERI ===
    Fancybox.bind('[data-fancybox="gallery"]', {
        Thumbs: false,
        Toolbar: true,
    });



    const items = document.querySelectorAll(".galeri-item.hidden");
    const loadMoreBtn = document.getElementById("lihat-lebih-btn");
    let index = 0;
    const perLoad = 3;
    
    loadMoreBtn?.addEventListener("click", () => {
        for (let i = 0; i < perLoad; i++) {
            const item = items[index + i];
            if (item) {
                setTimeout(() => {
                    item.classList.remove("hidden");
                    item.style.display = "block";
                    requestAnimationFrame(() => {
                        item.classList.add("show");
                    });
                }, i * 800); // Delay 100ms antar gambar (bisa diubah sesuai selera)
            }
        }
    
        index += perLoad;
    
        if (index >= items.length) {
            loadMoreBtn.style.display = "none";
        }
    });

    // === SCROLL TO TOP BUTTON === //
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            scrollTopBtn.style.display = window.scrollY > 300 ? 'block' : 'none';
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // ===== Article Page =====
    $(document).ready(function () {
        const route = '/filter-artikel';
    
        function showLoading() {
            $('#artikel-list').hide().html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `).fadeIn();
        }
    
        function fetchFilteredData(page = 1) {
            const search = $('#search-input').val();
            const bidang = $('#filter-bidang').val();
            const sort = $('#filter-sort').val();
    
            showLoading();
    
            $.ajax({
                url: `${route}?page=${page}`,
                method: 'GET',
                data: {
                    search: search,
                    bidang_id: bidang,
                    sort: sort,
                },
                success: function (response) {
                    if (response.html) {
                        $('#artikel-list').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.error("AJAX Error:", xhr);
                }
            });
        }
    
        // Trigger saat filter atau search berubah
        $('#filter-bidang, #filter-sort, #search-input').on('change keyup', function () {
            fetchFilteredData(1);
        });
    
        // Reset filter
        $('#reset-filter').on('click', function () {
            $('#search-input').val('');
            $('#filter-bidang').val('');
            $('#filter-sort').val('');
            fetchFilteredData(1);
        });
    
        // Tangani klik pagination link
        const ajaxPages = ['/articles', '/filter-artikel'];
        if (ajaxPages.includes(window.location.pathname)) {
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const page = $(this).attr('href').split('page=')[1];
                fetchFilteredData(page);
            });
        }
    });
});
