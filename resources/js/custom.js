// Custom JavaScript for ModernRestaurant theme
import AOS from 'aos';

document.addEventListener('DOMContentLoaded', function() {
    AOS.init();

    // Dark Mode Toggle
    const toggleButton = document.getElementById('darkModeToggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        });
    }

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
});
