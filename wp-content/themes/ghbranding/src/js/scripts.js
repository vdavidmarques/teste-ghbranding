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

 // Funções de cookies
 function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return '';
}

function setCookie(name, value, days = 7) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/`;
}

function toggleFavorite(id) {
    let favorites = getCookie('favorites') ? getCookie('favorites').split(',') : [];
    
    if (favorites.includes(id)) {
        favorites = favorites.filter(fav => fav !== id); 
    } else {
        favorites.push(id); 
    }

    setCookie('favorites', favorites.join(','), 7);
    
    alert('Favorites updated!');
    location.reload(); 
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

    // Função para exibir os itens da página atual
    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Atualiza visibilidade dos itens
        items.forEach((item, index) => {
            if (index >= start && index < end) {
                item.setAttribute("data-visible", "true");
            } else {
                item.setAttribute("data-visible", "false");
            }
        });

        // Atualiza os botões da paginação
        updatePagination(page);
    }

    // Função para criar os botões de paginação
    function createPagination() {
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.textContent = i;
            button.dataset.page = i;
            button.classList.add("pagination-button");

            // Adiciona evento de clique
            button.addEventListener("click", function () {
                currentPage = parseInt(this.dataset.page, 10);
                showPage(currentPage);
            });

            paginationContainer.appendChild(button);
        }
    }

    // Função para atualizar o botão ativo na paginação
    function updatePagination(activePage) {
        const buttons = paginationContainer.querySelectorAll(".pagination-button");
        buttons.forEach((button) => {
            button.classList.toggle("active", parseInt(button.dataset.page, 10) === activePage);
        });
    }

    // Inicializar
    createPagination();
    showPage(currentPage);
});

