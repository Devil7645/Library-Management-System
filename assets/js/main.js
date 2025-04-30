// Add interactivity here if needed (e.g., dark mode toggle later)
console.log("Library Management Home Page Loaded");

// Toggle hamburger menu
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
  navMenu.classList.toggle('active');
});