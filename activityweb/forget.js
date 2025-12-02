document.getElementById("resetForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission
  
    const userInput = document.querySelector('input[name="user_input"]').value;
  
    // Simulate sending login link (replace this with real backend logic)
    if (userInput) {
      alert("Login link sent! Redirecting to login...");
      window.location.href = "log.html";
    } else {
      alert("Please enter your email, phone, or username.");
    }
  });
  