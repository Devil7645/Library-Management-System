// Get references to necessary DOM elements
const container = document.getElementById("container");
const signUpBtn = document.getElementById("signUp");
const signInBtn = document.getElementById("signIn");

// Handle sign-up button click (for desktop overlay)
// Adds the class to shift the form to the signup panel
signUpBtn.addEventListener("click", () => {
  container.classList.add("right-panel-active");
  window.location.hash = "#signup"; // Update URL hash
});

// Handle sign-in button click (for desktop overlay)
// Removes the class to show the login panel
signInBtn.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
  window.location.hash = "#login"; // Update URL hash
});

// Mobile: Handle "Already have an account? Login" link
document.getElementById("mobileToLogin").addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Mobile: Handle "Don't have an account? Sign Up" link
document.getElementById("mobileToSignup").addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// When the page loads, show the correct form based on the hash in URL
// If "#signup" is in the URL, show signup panel, otherwise show login
window.addEventListener("load", () => {
  if (window.location.hash === "#signup") {
    container.classList.add("right-panel-active");
  } else {
    container.classList.remove("right-panel-active"); // Default to login
  }
});

// Optional: Handle manual hash changes (user changes #login/#signup in the URL)
// This ensures the form updates accordingly without reloading the page
window.addEventListener("hashchange", () => {
  if (window.location.hash === "#signup") {
    container.classList.add("right-panel-active");
  } else {
    container.classList.remove("right-panel-active");
  }
});