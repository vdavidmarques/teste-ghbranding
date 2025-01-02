//Search Function
document.getElementById('search-breeds').addEventListener('submit', function (e) {
    e.preventDefault();

    const searchTerm = this.querySelector('[name="s"]').value.trim();

    if (searchTerm === '') {
        alert('Por favor, insira um termo de busca.');
        return;
    }

    const searchUrl = `${window.location.origin}/teste-ghbranding/?s=${encodeURIComponent(searchTerm)}`;

    window.location.href = searchUrl;
});

//Favorite function
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

function setCookie(name, value, days = 7) {
    if (!value || value.length === 0) {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax`;
    } else {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${value}; expires=${expires}; path=/; SameSite=Lax`;
    }
}

function toggleFavorite(breedId, button) {
    let favorites = getCookie('favorites') ? getCookie('favorites').split(',') : [];
    favorites = [...new Set(favorites.filter(fav => fav.trim() !== ''))];

    if (favorites.includes(breedId)) {
        favorites = favorites.filter(fav => fav !== breedId);
        button.classList.remove('liked');
        button.classList.add('like');
    } else {
        favorites.push(breedId);
        button.classList.remove('like');
        button.classList.add('liked');
    }

    if (favorites.length > 0) {
        setCookie('favorites', favorites.join(','), 7);
    } else {
        setCookie('favorites', '', 7);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const favoriteButtons = document.querySelectorAll('.favorite-button');
    const favorites = getCookie('favorites') ? getCookie('favorites').split(',') : [];

    favoriteButtons.forEach(button => {
        const breedId = button.getAttribute('data-breed-id');

        if (favorites.includes(breedId)) {
            button.classList.add('liked');
            button.classList.remove('like');
        } else {
            button.classList.add('like');
            button.classList.remove('liked');
        }

        button.addEventListener('click', function () {
            toggleFavorite(breedId, button);
        });
    });
});

//Button Load more info
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.more-info-button');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const breedId = this.getAttribute('data-breed-id');
            const featuresList = document.querySelector(`#features-${breedId}`);
            const features = featuresList.querySelectorAll('.feature');

            let showingMore = false;
            
            features.forEach((feature, index) => {
                if (index >= 6) {
                    if (feature.style.display === 'none' || feature.style.display === '') {
                        showingMore = true;
                    }
                }
            });
            
            features.forEach((feature, index) => {
                if (index >= 6) {
                    feature.style.display = showingMore ? 'list-item' : 'none';
                }
            });
            
            this.textContent = showingMore ? 'Show Less' : 'More Info';
        });
    });
});

//Pagination
document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 12; // Quantidade de itens por página
    const items = document.querySelectorAll(".breed-item");
    const paginationContainer = document.getElementById("pagination-container");

    const totalItems = items.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let currentPage = 1;

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        items.forEach((item, index) => {
            if (index >= start && index < end) {
                item.setAttribute("data-visible", "true");
            } else {
                item.setAttribute("data-visible", "false");
            }
        });

        updatePagination(page);
    }

    function createPagination() {
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.textContent = i;
            button.dataset.page = i;
            button.classList.add("pagination-button");

            button.addEventListener("click", function () {
                currentPage = parseInt(this.dataset.page, 10);
                showPage(currentPage);
            });

            paginationContainer.appendChild(button);
        }
    }

    function updatePagination(activePage) {
        const buttons = paginationContainer.querySelectorAll(".pagination-button");
        buttons.forEach((button) => {
            button.classList.toggle("active", parseInt(button.dataset.page, 10) === activePage);
        });
    }

    createPagination();
    showPage(currentPage);
});

