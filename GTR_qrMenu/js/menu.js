// ===== ELEMENTS =====
const floatingHeader = document.getElementById('floatingHeader');
const floatingSearch = document.getElementById('floatingSearch');
const searchInput = document.getElementById('searchInput');
const menuHeading = document.getElementById('menuHeading');
const categoryButtons = document.querySelectorAll('.tab');
const menuItems = document.querySelectorAll('.menu-item');

let lastScrollY = 0;
let currentCategory = 'all';

// ===== FLOATING HEADER =====
window.addEventListener('scroll', () => {
    const y = window.scrollY;

    if (y > 120 && y > lastScrollY) {
        floatingHeader.classList.add('show');
    } else if (y < 80) {
        floatingHeader.classList.remove('show');
    }

    lastScrollY = y;
});

// ===== SEARCH SYNC =====
floatingSearch.addEventListener('input', () => {
    searchInput.value = floatingSearch.value;
    filterItems();
});

searchInput.addEventListener('input', filterItems);

// ===== CATEGORY TABS =====
categoryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        currentCategory = btn.dataset.category;

        // Sync active state
        categoryButtons.forEach(b => {
            b.classList.toggle(
                'active',
                b.dataset.category === currentCategory
            );
        });

        // Update heading
        menuHeading.textContent =
            currentCategory === 'all'
                ? 'OUR MENU'
                : btn.textContent.trim().toUpperCase();

        filterItems();
    });
});

// ===== FILTER LOGIC =====
function filterItems() {
    const term = searchInput.value.toLowerCase();

    menuItems.forEach(item => {
        const matchName = item.dataset.name.includes(term);
        const matchCategory =
            currentCategory === 'all' ||
            item.dataset.category === currentCategory;

        item.style.display =
            matchName && matchCategory ? '' : 'none';
    });
}

// ===== MODAL =====
function openModal(card) {
    const parent = card.closest('.menu-item');

    document.getElementById('modalImage').src = parent.dataset.image;
    document.getElementById('modalTitle').innerText =
        card.querySelector('.card-title').innerText;
    document.getElementById('modalDescription').innerText =
        parent.dataset.description;
    document.getElementById('modalPrice').innerText =
        '₱' + parent.dataset.price;

    new bootstrap.Modal(
        document.getElementById('itemModal')
    ).show();
}

// MOdal image
let scale = 1;
let lastTap = 0;
let startX = 0;
let startY = 0;
let translateX = 0;
let translateY = 0;

function openPhotoViewer() {
    const img = document.getElementById('photoViewer');
    img.src = document.getElementById('modalImage').src;

    resetZoom();

    new bootstrap.Modal(
        document.getElementById('photoModal')
    ).show();
}

function resetZoom() {
    scale = 1;
    translateX = 0;
    translateY = 0;
    applyTransform();
}

function applyTransform() {
    const img = document.getElementById('photoViewer');
    img.style.transform =
        `translate(${translateX}px, ${translateY}px) scale(${scale})`;
}

/* DOUBLE TAP ZOOM */
document.getElementById('photoViewer').addEventListener('touchend', e => {
    const now = Date.now();
    if (now - lastTap < 300) {
        scale = scale > 1 ? 1 : 2;
        translateX = 0;
        translateY = 0;
        applyTransform();
    }
    lastTap = now;
});

/* DRAG IMAGE */
document.getElementById('photoViewer').addEventListener('touchstart', e => {
    if (scale === 1) return;
    const t = e.touches[0];
    startX = t.clientX - translateX;
    startY = t.clientY - translateY;
});

document.getElementById('photoViewer').addEventListener('touchmove', e => {
    if (scale === 1) return;
    const t = e.touches[0];
    translateX = t.clientX - startX;
    translateY = t.clientY - startY;
    applyTransform();
});

