// import './bootstrap';

// import Alpine from 'alpinejs';

// import Swiper from 'swiper'; // <-- ADD THIS LINE
// import 'swiper/css'; 

// window.Alpine = Alpine;

// Alpine.start();

import './bootstrap';

// Import Alpine.js for interactivity
import Alpine from 'alpinejs';

// Import Swiper JS
import Swiper from 'swiper';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination'; // Import pagination styles

// Make Swiper available globally if needed, or initialize it directly
// For our use case, we will initialize it in the Blade file.
window.Swiper = Swiper;

window.Alpine = Alpine;
Alpine.start();