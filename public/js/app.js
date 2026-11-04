document.addEventListener('DOMContentLoaded', function () {
    // 1. Bayangan navbar saat halaman digulir
    const header = document.querySelector('.site-header');
    if (header) {
        const toggleShadow = () => header.classList.toggle('is-scrolled', window.scrollY > 12);
        toggleShadow();
        window.addEventListener('scroll', toggleShadow, { passive: true });
    }

    // 2. Animasi muncul saat elemen masuk viewport
    const revealItems = document.querySelectorAll('.reveal');
    if (revealItems.length) {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealItems.forEach((item) => observer.observe(item));
        } else {
            revealItems.forEach((item) => item.classList.add('is-visible'));
        }
    }

    // 3. Konfirmasi sebelum menghapus data
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm || 'Yakin ingin menghapus data ini?')) {
                event.preventDefault();
            }
        });
    });

    // 4. Pratinjau gambar sebelum upload (admin)
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        const target = document.querySelector(input.dataset.preview);
        if (!target) return;

        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            if (!file) return;
            target.src = URL.createObjectURL(file);
        });
    });

    // 5. Sidebar admin untuk layar kecil
    const sidebar = document.querySelector('.admin-sidebar');
    const backdrop = document.querySelector('.sidebar-backdrop');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            sidebar?.classList.toggle('show');
            backdrop?.classList.toggle('show');
        });
    });
    backdrop?.addEventListener('click', () => {
        sidebar?.classList.remove('show');
        backdrop.classList.remove('show');
    });

    // 6. Tooltip Bootstrap (jika dipakai)
    if (window.bootstrap && window.bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => new window.bootstrap.Tooltip(el));
    }

    // 7. Lightbox galeri: isi modal sesuai foto yang diklik
    const galleryModal = document.getElementById('galleryModal');
    if (galleryModal) {
        galleryModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const image = document.getElementById('galleryModalImage');
            const title = document.getElementById('galleryModalTitle');
            const desc = document.getElementById('galleryModalDesc');

            image.src = trigger.dataset.src || '';
            image.alt = trigger.dataset.title || 'Foto galeri';
            title.textContent = trigger.dataset.title || '';
            desc.textContent = trigger.dataset.desc || '';
        });
    }

    document.querySelectorAll('.gallery-video-preview').forEach((preview) => {
        preview.addEventListener('click', () => {
            const embedUrl = preview.dataset.videoEmbed;
            if (!embedUrl) return;

            const url = new URL(embedUrl);
            url.searchParams.set('autoplay', '1');
            url.searchParams.set('origin', preview.dataset.videoOrigin || window.location.origin);

            const iframe = document.createElement('iframe');
            iframe.title = preview.dataset.videoTitle || 'Video galeri';
            iframe.loading = 'lazy';
            iframe.referrerPolicy = 'origin';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframe.allowFullscreen = true;
            iframe.src = url.toString();

            preview.replaceWith(iframe);
        });
    });
});
