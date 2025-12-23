document.addEventListener('DOMContentLoaded', () => {
    // === ACTIVE LINK ===
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links a').forEach(link => {
        if (link.getAttribute('href') === currentPage) link.classList.add('active');
    });

    // === SLIDESHOW ===
    const slideshow = document.querySelector('.slideshow');
    if (slideshow) {
        const slides = slideshow.querySelectorAll('.slide');
        let current = 0;
        setInterval(() => {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }, 4500);
    }

    // === ΧΑΡΤΗΣ ===
    const mapElement = document.getElementById('leaflet-map');
    if (mapElement) {
        const map = L.map('leaflet-map').setView([37.935, 23.745], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([37.935, 23.745], { icon: L.divIcon({ className: 'campus-icon', html: '🏫', iconSize: [30, 30] }) })
            .addTo(map).bindPopup('<b>Πανεπιστήμιο Ηλιούπολης</b>').openPopup();
        L.marker([37.92964, 23.7445], { icon: L.divIcon({ className: 'metro-icon', html: '🚇', iconSize: [28, 28] }) })
            .addTo(map).bindPopup('<b>Μετρό Ηλιούπολης</b>');
        L.marker([37.932, 23.740], { icon: L.divIcon({ className: 'bus-icon', html: '🚌', iconSize: [28, 28] }) })
            .addTo(map).bindPopup('<b>Λεωφορείο - Βεΐκου</b>');
        L.marker([37.936, 23.747], { icon: L.divIcon({ className: 'bus-icon', html: '🚌', iconSize: [28, 28] }) })
            .addTo(map).bindPopup('<b>Λεωφορείο - Ειρήνης</b>');
        L.marker([37.933, 23.742], { icon: L.divIcon({ className: 'bus-icon', html: '🚌', iconSize: [28, 28] }) })
            .addTo(map).bindPopup('<b>Λεωφορείο - Πλατεία</b>');
    }

    // === FIX: ΕΠΑΝΑΦΟΡΑ ΣΕ (0,0) ΣΕ ΑΛΛΑΓΗ TAB ===
    window.addEventListener('focus', () => {
        window.scrollTo(0, 0);
    });
});