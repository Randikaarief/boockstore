import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toast-notification');

    if (toast) {
        setTimeout(() => {
            // Start fading out
            toast.style.transition = 'opacity 0.5s ease-in-out';
            toast.style.opacity = '0';
            
            // Remove from DOM after fade out
            setTimeout(() => {
                toast.remove();
            }, 500); // 0.5s for fade out
        }, 5000); // 5 seconds
    }
});
