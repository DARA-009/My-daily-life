import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.Chart = Chart;
window.createIcons = createIcons;
window.lucideIcons = icons;

// Initialize Lucide SVG icons on initial load and when DOM updates
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Re-render icons on Alpine morph / navigation updates
document.addEventListener('alpine:initialized', () => {
    createIcons({ icons });
});

Alpine.start();
