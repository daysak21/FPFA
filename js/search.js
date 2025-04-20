document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("search")
  const resultsDiv = document.getElementById("results")

  if (!searchInput || !resultsDiv) {
    console.error("Search input or results container not found")
    return
  }

  // Add a small delay to prevent too many requests while typing
  let searchTimeout

  searchInput.addEventListener("keyup", function () {
    const query = this.value.trim()

    clearTimeout(searchTimeout)

    searchTimeout = setTimeout(() => {
      if (query.length > 2) {
        // Show loading indicator
        resultsDiv.innerHTML = '<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Searching...</div>'
        resultsDiv.classList.add("show")

        // Log the request for debugging
        console.log("Searching for:", query)

        fetch("./functions/live_search.php?q=" + encodeURIComponent(query))
          .then((res) => {
            console.log("Search response status:", res.status)
            return res.text()
          })
          .then((data) => {
            console.log("Search response received")
            resultsDiv.innerHTML = data
            if (data.trim() !== "") {
              resultsDiv.classList.add("show")
            } else {
              resultsDiv.classList.remove("show")
            }
          })
          .catch((error) => {
            console.error("Search error:", error)
            resultsDiv.innerHTML = '<div class="p-3 text-danger">Error connecting to search service</div>'
          })
      } else {
        resultsDiv.innerHTML = ""
        resultsDiv.classList.remove("show")
      }
    }, 300) // 300ms delay
  })

  // Close search results when clicking outside
  document.addEventListener("click", (e) => {
    if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
      resultsDiv.classList.remove("show")
    }
  })
})
