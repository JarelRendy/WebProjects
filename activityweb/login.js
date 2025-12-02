document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Stop form from refreshing the page

  const emailOrPhone = document.querySelector('input[name="emailOrPhone"]').value.trim();
  const password = document.querySelector('input[name="password"]').value.trim();
  
  // Validate phone number format (10-15 digits)
  const phoneRegex = /^\d{10,15}$/;

  if (phoneRegex.test(emailOrPhone)) {
    if (password) {
      // Store the user type and last login time
      localStorage.setItem("userType", "User"); 
      localStorage.setItem("lastLogin", new Date().toLocaleString());

      // Redirect to the user dashboard
      window.location.href = "dashboard.html";
    } else {
      alert("Please enter your Password.");
    }
  } else if (/\S+@\S+\.\S+/.test(emailOrPhone)) {
    // If it's an email, continue as usual
    if (password) {
      // Store the user type and last login time
      localStorage.setItem("userType", "User"); 
      localStorage.setItem("lastLogin", new Date().toLocaleString());

      // Redirect to the user dashboard
      window.location.href = "dashboard.html";
    } else {
      alert("Please enter your Password.");
    }
  } else {
    alert("Please enter a valid Email or Phone Number.");
  }
});
