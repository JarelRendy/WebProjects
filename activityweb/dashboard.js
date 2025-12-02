// Handle booking form submission
document.getElementById("bookingForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const service = document.querySelector('select[name="service"]').value;
  const appointmentTime = document.querySelector('input[name="appointmentTime"]').value;

  if (service && appointmentTime) {
    // Simulate booking success
    document.getElementById("bookingStatus").textContent = `Your appointment for ${service} has been booked for ${appointmentTime}.`;
  } else {
    document.getElementById("bookingStatus").textContent = "Please fill out all fields.";
  }
});

// Handle real-time status button
document.getElementById("realTimeButton").addEventListener("click", function () {
  // Simulate a real-time status update (this could be an API call in a real-world scenario)
  const statuses = [
    "Your stylist is available.",
    "There is a 15-minute wait.",
    "Booking system is temporarily down. Please try again later."
  ];
  
  const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
  document.getElementById("realTimeStatus").textContent = randomStatus;
});
