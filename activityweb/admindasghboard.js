window.onload = function() {
    const role = localStorage.getItem('role'); // Retrieve the role from login
    const roleName = document.getElementById('roleName');
    const roleContent = document.getElementById('roleContent');
  
    // Display the role name in the welcome message
    if (role) {
      roleName.textContent = role.charAt(0).toUpperCase() + role.slice(1);
      
      // Generate dynamic content based on role
      switch (role) {
        case 'staff':
          roleContent.innerHTML = `<div class="staff-content">
                                    <h3>Staff Dashboard</h3>
                                    <p>Welcome to the staff dashboard. Here you can manage your daily tasks.</p>
                                  </div>`;
          break;
        case 'manager':
          roleContent.innerHTML = `<div class="manager-content">
                                    <h3>Manager Dashboard</h3>
                                    <p>Welcome to the manager dashboard. You can oversee staff activities here.</p>
                                  </div>`;
          break;
        case 'owner':
          roleContent.innerHTML = `<div class="owner-content">
                                    <h3>Owner Dashboard</h3>
                                    <p>Welcome to the owner dashboard. Here you have full access to all features.</p>
                                  </div>`;
          break;
        default:
          roleContent.innerHTML = `<p>Error: Invalid role.</p>`;
      }
    } else {
      window.location.href = 'adminlog.html'; // Redirect to login if role is not found
    }
  };
  