document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchButton = searchInput.nextElementSibling;
    const resultsContainer = document.getElementById('results');
    
    // Function to perform search
    async function performSearch(query) {
        if (!query || query.length < 2) {
            resultsContainer.classList.remove('show');
            return;
        }
        
        try {
            const response = await fetch(`http://localhost:5000/search?q=${encodeURIComponent(query)}`);
            const results = await response.json();
            
            displayResults(results);
        } catch (error) {
            console.error('Search error:', error);
            resultsContainer.innerHTML = '<div class="p-3 text-danger">Error connecting to search service</div>';
            resultsContainer.classList.add('show');
        }
    }
    
    // Function to display results
    function displayResults(results) {
        if (!results || results.length === 0) {
            resultsContainer.innerHTML = '<div class="p-3 text-muted">No results found</div>';
            resultsContainer.classList.add('show');
            return;
        }
        
        let html = '';
        
        results.forEach(product => {

            html += `
                <a href="product.php?id=${product.product_id}" class="dropdown-item p-2 text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" style="width: 50px; height: 50px;">
                            <img src="images/${product.product_one}" alt="${product.product_title}" 
                                 class="img-fluid" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">${product.product_title}</div>
                            <div class="small text-truncate">${product.product_description}</div>
                            <div class="text-primary fw-bold">${formatPrice(product.product_price)}</div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            `;
        });
        
        // Remove the last divider
        html = html.replace(/<div class="dropdown-divider"><\/div>$/, '');
        
        resultsContainer.innerHTML = html;
        resultsContainer.classList.add('show');
    }
    
    // Format price with currency symbol
    function formatPrice(price) {
        return '$' + parseFloat(price).toFixed(2);
    }
    
    // Event listeners
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            performSearch(query);
        } else {
            resultsContainer.classList.remove('show');
        }
    });
    
    searchButton.addEventListener('click', function() {
        const query = searchInput.value.trim();
        if (query.length >= 2) {
            performSearch(query);
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchButton.contains(event.target) && !resultsContainer.contains(event.target)) {
            resultsContainer.classList.remove('show');
        }
    });
    
    // Prevent dropdown from closing when clicking inside it
    resultsContainer.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});