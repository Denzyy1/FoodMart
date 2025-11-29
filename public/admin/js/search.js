document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchForm = document.getElementById('searchForm');
    let searchTimeout;

    if (!searchInput || !searchResults) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/search/ajax?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    if (products.length === 0) {
                        searchResults.innerHTML = '<div class="p-3 text-center text-muted">No products found</div>';
                    } else {
                        let html = '';
                        products.forEach(product => {
                            html += `
                                <a href="/search?q=${encodeURIComponent(product.name)}" class="d-flex align-items-center p-2 border-bottom text-decoration-none text-dark search-result-item">
                                    <img src="${product.image}" alt="${product.name}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 fw-bold">${product.name}</h6>
                                        <small class="text-muted">${product.type} • ${product.stock} in stock</small>
                                    </div>
                                    <span class="text-success fw-bold">$${product.price}</span>
                                </a>
                            `;
                        });
                        html += `<a href="/search?q=${encodeURIComponent(query)}" class="d-block p-2 text-center text-primary fw-bold">View all results →</a>`;
                        searchResults.innerHTML = html;
                    }
                    searchResults.style.display = 'block';
                })
                .catch(() => searchResults.style.display = 'none');
        }, 300);
    });

  
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

 
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            searchResults.style.display = 'block';
        }
    });
});
