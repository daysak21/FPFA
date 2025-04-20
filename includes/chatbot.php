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
        
        // Simulate bot response
        setTimeout(() => {
            // Remove typing indicator
            chatbotBody.removeChild(typingIndicator);
            
            // Simple response logic
            let response = "Thank you for your message. How can I help you with your shopping today?";
            
            if (message.toLowerCase().includes('hello') || message.toLowerCase().includes('hi')) {
                response = "Hello! How can I help you with your shopping today?";
            } 
            else if (message.toLowerCase().includes('price')) {
                response = "Our prices are very competitive. Which product are you interested in?";
            }
            else if (message.toLowerCase().includes('shipping')) {
                response = "Shipping is free for all orders over $50. Delivery usually takes 2-3 business days.";
            }
            
            // Add bot response
            addMessage(response, 'bot');
        }, 1000);
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