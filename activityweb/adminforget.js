document.getElementById("adminForgetPasswordForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const email = document.querySelector('input[name="email"]').value.trim();

  if (!email) {
    alert("Please enter your email address.");
    return;
  }

  alert("Password reset link sent to your email.");

  // Redirect back to login page after showing alert
  window.location.href = "adminlog.html"; 
});
