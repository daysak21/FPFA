<!-- Chatbot Button -->
<div class="chatbot-toggle" id="chatbotToggle">
    <img src="assets/images/robot-icon.png" alt="Robot Assistant" class="robot-icon">
</div>

<!-- Chatbot Container -->
<div class="chatbot-container hidden" id="chatbotContainer">
    <div class="chatbot-header">
        <div class="chatbot-title">
            <img src="assets/images/robot-icon.png" alt="Robot Assistant" class="robot-icon-small">
            <span>Shopping Assistant</span>
        </div>
        <button class="chatbot-close" id="closeChatbot">&times;</button>
    </div>
    <div class="chatbot-body" id="chatbotBody">
        <div class="bot-message message">Hello! I'm your shopping assistant. How can I help you today?</div>
    </div>
    <div class="chatbot-input">
        <input type="text" class="form-control" id="userInput" placeholder="Type your message...">
        <button class="btn btn-send" id="sendMessage">
            <i class="fa fa-paper-plane"></i>
        </button>
    </div>
</div>

<!-- Chatbot Scripts -->
<link rel="stylesheet" href="assets/css/chatbot.css">

<!-- Add this CSS for product recommendations -->
<style>
.recommendations-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin: 15px 0;
    max-width: 100%;
}

.product-recommendation {
    display: flex;
    background: #f9f9f9;
    border-radius: 10px;
    padding: 12px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-recommendation:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.product-recommendation img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 12px;
    border: 1px solid #eaeaea;
}

.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-info h4 {
    margin: 0 0 5px 0;
    font-size: 14px;
    color: #333;
    line-height: 1.3;
}

.product-info p {
    margin: 0 0 8px 0;
    font-size: 14px;
    font-weight: bold;
    color: #e44d26;
}

.product-info button {
    background: #4a69bd;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    transition: background-color 0.2s;
    align-self: flex-start;
    font-weight: 500;
}

.product-info button:hover {
    background: #3c5aa6;
}

.typing-indicator {
    display: flex;
    padding: 10px;
}

.typing-indicator span {
    height: 8px;
    width: 8px;
    float: left;
    margin: 0 1px;
    background-color: #9E9EA1;
    display: block;
    border-radius: 50%;
    opacity: 0.4;
}

.typing-indicator span:nth-of-type(1) {
    animation: 1s blink infinite 0.3333s;
}

.typing-indicator span:nth-of-type(2) {
    animation: 1s blink infinite 0.6666s;
}

.typing-indicator span:nth-of-type(3) {
    animation: 1s blink infinite 0.9999s;
}

@keyframes blink {
    50% {
        opacity: 1;
    }
}

.chatbot-container {
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.chatbot-header {
    background: #4a69bd;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.chatbot-title span {
    font-weight: 600;
}

.message {
    border-radius: 18px;
    padding: 10px 15px;
    margin: 8px 0;
    max-width: 85%;
}

.bot-message {
    background-color: #f0f2f5;
    border-bottom-left-radius: 4px;
}

.user-message {
    background-color: #4a69bd;
    color: white;
    border-bottom-right-radius: 4px;
    align-self: flex-end;
}

.chatbot-input {
    border-top: 1px solid #eaeaea;
    padding: 12px;
}

.chatbot-input input {
    border-radius: 20px;
    padding: 10px 15px;
    border: 1px solid #ddd;
}

.btn-send {
    background: #4a69bd;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

.btn-send:hover {
    background: #3c5aa6;
}
</style>

<!-- Inline script to ensure it works -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chatbot script loaded');
    
    // Get DOM elements
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotContainer = document.getElementById('chatbotContainer');
    const closeChatbot = document.getElementById('closeChatbot');
    const userInput = document.getElementById('userInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatbotBody = document.getElementById('chatbotBody');
    
    // Debug check if elements exist
    if (!chatbotToggle) console.error('chatbotToggle element not found');
    if (!chatbotContainer) console.error('chatbotContainer element not found');
    
    // Toggle chatbot visibility
    chatbotToggle.addEventListener('click', function() {
        console.log('Chatbot toggle clicked');
        chatbotContainer.classList.remove('hidden');
    });
    
    closeChatbot.addEventListener('click', function() {
        console.log('Close button clicked');
        chatbotContainer.classList.add('hidden');
    });
    
    // Send message function
    function sendUserMessage() {
        const message = userInput.value.trim();
        if (message === '') return;
        
        // Add user message to chat
        addMessage(message, 'user');
        userInput.value = '';
        
        // Show typing indicator
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        chatbotBody.appendChild(typingIndicator);
        scrollToBottom();
        
        // Call recommendation engine API
        fetchRecommendations(message, typingIndicator);
    }
    
    // Function to call recommendation engine API
    async function fetchRecommendations(message, typingIndicator) {
        try {
            console.log('Fetching recommendations for:', message);
            
            // Make API call to recommendation engine
            const response = await fetch('http://127.0.0.1:5000/recommend', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });
            
            // Remove typing indicator
            if (typingIndicator && typingIndicator.parentNode) {
                chatbotBody.removeChild(typingIndicator);
            }
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Recommendation response:', data);
            
            if (data.status === 'success' && data.recommendations && data.recommendations.length > 0) {
                // Add message before recommendations
                addMessage("Here are some products you might be interested in:", 'bot');
                
                // Display recommendations
                displayRecommendations(data.recommendations);
            } else {
                // No recommendations found
                let responseMessage = data.message || "I couldn't find any products matching your criteria. Can you try a different search?";
                addMessage(responseMessage, 'bot');
            }
        } catch (error) {
            console.error('Error fetching recommendations:', error);
            
            // Remove typing indicator if it still exists
            if (typingIndicator && typingIndicator.parentNode) {
                chatbotBody.removeChild(typingIndicator);
            }
            
            // Fallback to basic responses if API call fails
            let response = "I'm having trouble connecting to our product database. Please try again later.";
            
            if (message.toLowerCase().includes('hello') || message.toLowerCase().includes('hi')) {
                response = "Hello! How can I help you with your shopping today?";
            } 
            else if (message.toLowerCase().includes('price')) {
                response = "Our prices are very competitive. Which product are you interested in?";
            }
            else if (message.toLowerCase().includes('shipping')) {
                response = "Shipping is free for all orders over $50. Delivery usually takes 2-3 business days.";
            }
            
            addMessage(response, 'bot');
        }
    }
    
    // Function to display product recommendations
    function displayRecommendations(recommendations) {
        const recommendationsDiv = document.createElement('div');
        recommendationsDiv.className = 'recommendations-container';
        
        recommendations.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'product-recommendation';
            
            // Create HTML for product with image
            // Adjust the image path to point to the correct location
            productDiv.innerHTML = `
            <img src="admin/product_images/${product.image}" alt="${product.title}" onerror="this.src='assets/images/placeholder.png'">
            <div class="product-info">
                <h4>${product.title}</h4>
                <p>${product.price} DT</p>
                <button onclick="window.location.href='products.php?id=${product.id}'">View Product</button>
            </div>
    `;
    
        recommendationsDiv.appendChild(productDiv);
    });
    
    chatbotBody.appendChild(recommendationsDiv);
    scrollToBottom();
}
    
    // Add message to chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = sender === 'user' ? 'user-message message' : 'bot-message message';
        messageDiv.textContent = text;
        chatbotBody.appendChild(messageDiv);
        scrollToBottom();
    }
    
    // Scroll chat to bottom
    function scrollToBottom() {
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }
    
    // Event listeners
    sendMessage.addEventListener('click', sendUserMessage);
    
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendUserMessage();
        }
    });
});
</script>
