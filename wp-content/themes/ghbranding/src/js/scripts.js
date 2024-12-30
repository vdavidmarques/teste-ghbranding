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