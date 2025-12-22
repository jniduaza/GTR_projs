// ELEMENTS
const floatingHeader = document.getElementById('floatingHeader');
const floatingSearch = document.getElementById('floatingSearch');
const searchInput = document.getElementById('searchInput');
const menuItems = document.querySelectorAll('.menu-item');

// BOTH category tab sets (main + floating)
const categoryTabs = document.querySelectorAll('.category-tabs .tab');

let lastScrollY = 0;
let currentCategory = 'all';

// SHOW floating header only when scrolling down
window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;

    if (currentScroll > 120 && currentScroll > lastScrollY) {
        floatingHeader.classList.add('show');
    } else if (currentScroll < 80) {
        floatingHeader.classList.remove('show');
    }

    lastScrollY = currentScroll;
});

// SYNC floating search with main search
floatingSearch.addEventListener('input', () => {
    searchInput.value = floatingSearch.value;
    filterItems();
});

// MAIN search
searchInput.addEventListener('input', filterItems);

// CATEGORY TABS (works for BOTH headers)
categoryTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        currentCategory = tab.dataset.category;

        // Set active state on ALL matching tabs
        categoryTabs.forEach(t => {
            t.classList.toggle(
                'active',
                t.dataset.category === currentCategory
            );
        });

        filterItems();
    });
});

// FILTER LOGIC (single source of truth)
function filterItems() {
    const term = searchInput.value.toLowerCase();

    menuItems.forEach(item => {
        const matchName = item.dataset.name.includes(term);
        const matchCategory =
            currentCategory === 'all' ||
            item.dataset.category === currentCategory;

        item.style.display =
            matchName && matchCategory ? 'block' : 'none';
    });
}

// MODAL
function openModal(card) {
    document.getElementById('modalImage').src = card.dataset.image;
    document.getElementById('modalTitle').innerText =
        card.querySelector('.card-title').innerText;
    document.getElementById('modalDescription').innerText =
        card.dataset.description;
    document.getElementById('modalPrice').innerText =
        '₱' + card.dataset.price;

    new bootstrap.Modal(
        document.getElementById('itemModal')
    ).show();
}


