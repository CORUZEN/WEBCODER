import './bootstrap';

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Confirm delete actions
window.confirmDelete = function(message = 'Tem certeza que deseja excluir?') {
    return confirm(message);
};

// Format currency
window.formatCurrency = function(cents) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(cents / 100);
};

// Mobile menu toggle
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
};
