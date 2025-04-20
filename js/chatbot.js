document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotContainer = document.getElementById('chatbotContainer');
    const closeChatbot = document.getElementById('closeChatbot');
    const userInput = document.getElementById('userInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatbotBody = document.getElementById('chatbotBody');
    
    // Toggle chatbot visibility
    chatbotToggle.addEventListener('click', function() {
        chatbotContainer.classList.remove('hidden');
        // Optional: hide the toggle button when chat is open
        // chatbotToggle.classList.add('hidden');
    });
    
    closeChatbot.addEventListener('click', function() {
        chatbotContainer.classList.add('hidden');
        // Optional: show the toggle button when chat is closed
        // chatbotToggle.classList.remove('hidden');
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
        
        // Call API to get bot response
        fetchBotResponse(message)
            .then(response => {
                // Remove typing indicator
                chatbotBody.removeChild(typingIndicator);
                // Add bot response
                addMessage(response, 'bot');
            })
            .catch(error => {
                console.error('Error:', error);
                chatbotBody.removeChild(typingIndicator);
                addMessage("Sorry, I couldn't process your request. Please try again.", 'bot');
            });
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
    
    // Fetch bot response from API
    async function fetchBotResponse(message) {
        // For demonstration, we're simulating a response
        // In a real environment, you would call your API
        return new Promise((resolve) => {
            setTimeout(() => {
                // Predefined responses based on keywords
                const messageLower = message.toLowerCase();
                
                if (messageLower.includes('hello') || messageLower.includes('hi')) {
                    resolve("Hello! How can I help you with your shopping today?");
                } 
                else if (messageLower.includes('price') || messageLower.includes('cost') || messageLower.includes('how much')) {
                    resolve("Our prices are very competitive. Which product are you particularly interested in?");
                } 
                else if (messageLower.includes('shipping') || messageLower.includes('delivery')) {
                    resolve("Shipping is free for all orders over $50. Delivery usually takes 2-3 business days.");
                } 
                else if (messageLower.includes('payment') || messageLower.includes('pay') || messageLower.includes('card')) {
                    resolve("We accept credit cards, PayPal, and bank transfers as payment methods.");
                } 
                else if (messageLower.includes('phone') || messageLower.includes('smartphone') || messageLower.includes('mobile')) {
                    resolve("We have a wide range of smartphones from the best brands. Are you looking for a particular brand like Apple, Samsung, or Xiaomi?");
                } 
                else if (messageLower.includes('computer') || messageLower.includes('laptop') || messageLower.includes('pc')) {
                    resolve("Our laptops are available in different configurations. Do you have a specific budget or brand preference?");
                } 
                else if (messageLower.includes('return') || messageLower.includes('refund')) {
                    resolve("You can return a product within 14 days of receipt for a full refund. Please ensure the product is in its original condition.");
                }
                else if (messageLower.includes('available') || messageLower.includes('stock')) {
                    resolve("All products displayed on our website are generally available in stock. If a product is out of stock, it will be clearly indicated on its page.");
                }
                else if (messageLower.includes('thank')) {
                    resolve("You're welcome! Feel free to ask if you have any other questions.");
                }
                else {
                    resolve("Thank you for your message. How can I further assist you with your shopping? Feel free to ask me about our products, shipping, or payment options.");
                }
            }, 1000);
        });
    }
    
    // Event listeners
    sendMessage.addEventListener('click', sendUserMessage);
    
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendUserMessage();
        }
    });
});