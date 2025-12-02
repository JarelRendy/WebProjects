document.getElementById("adminLoginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent the form from submitting the traditional way

  const email = document.querySelector('input[name="email"]').value.trim();
  const phone = document.querySelector('input[name="phone"]').value.trim();
  const role = document.querySelector('select[name="role"]').value;
  const password = document.querySelector('input[name="password"]').value.trim();

  // Validate email and phone format
  const phoneRegex = /^\d{10,15}$/; // Validates phone number (10-15 digits)

  if (!email || !phone || !role || !password) {
    alert("Please fill in all fields.");
    return;
  }

  if (!phoneRegex.test(phone)) {
    alert("Please enter a valid phone number (10-15 digits).");
    return;
  }

  // Store the role in localStorage
  localStorage.setItem('role', role);

  // If everything is valid, proceed to login
  alert(`Logged in successfully as ${role}!`);
  window.location.href = "admindashboard.html"; // Redirect to the admin dashboard
});

// Toggle the visibility of the password field
document.getElementById("togglePassword").addEventListener("click", function () {
  const passwordField = document.getElementById("password");
  const icon = document.getElementById("togglePassword");

  // Toggle the password visibility
  if (passwordField.type === "password") {
    passwordField.type = "text";
    icon.innerHTML = "&#128065;"; // Eye open icon
  } else {
    passwordField.type = "password";
    icon.innerHTML = "&#128065;"; // Eye closed icon
  }
});

// Redirect to admin signup page when the signup link is clicked
document.querySelector(".signup-link a").addEventListener("click", function (e) {
  e.preventDefault();
  window.location.href = "adminsignup.html"; // Redirect to the admin signup page
});
