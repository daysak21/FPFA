document.addEventListener('DOMContentLoaded', function() {
    // Animation de l'image
    const imageInput = document.getElementById('user_image');
    const previewContainer = document.createElement('div');
    previewContainer.className = 'image-preview-container';
    const imagePreview = document.createElement('img');
    imagePreview.className = 'image-preview';
    previewContainer.appendChild(imagePreview);
    imageInput.parentNode.insertBefore(previewContainer, imageInput.nextSibling);
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.style.display = 'block';
                imagePreview.src = e.target.result;
                
                // Animation d'apparition
                imagePreview.style.opacity = '0';
                imagePreview.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    imagePreview.style.transition = 'all 0.4s ease';
                    imagePreview.style.opacity = '1';
                    imagePreview.style.transform = 'scale(1)';
                }, 10);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Effet de focus amélioré
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.querySelector('.form-label').style.color = '#DB4444';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            if (!this.value) {
                this.parentElement.querySelector('.form-label').style.color = '#495057';
            }
        });
    });
    
    // Effet de saisie
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.style.borderColor = '#DB4444';
                setTimeout(() => {
                    this.style.borderColor = '#e9ecef';
                }, 1000);
            }
        });
    });
});