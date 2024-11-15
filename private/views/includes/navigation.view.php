
<style>
  /* Main Body Styling */
 
  /* Sidebar Styling */
  .sidebar {
    background: linear-gradient(45deg, darkblue, #1a233a);
    padding: 10px;
    text-align: left;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    width: 100px; /* Always collapsed */
    height: 100vh;
    transition: width 0.3s ease, padding-left 0.3s ease;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
  }

  /* Sidebar Navigation Links */
  .sidebar .nav-link {
    color: #fff;
    font-size: 14px;
    padding: 15px;
    margin: 5px 0;
    display: flex;
    align-items: center;
    transition: all 0.3s ease-in-out;
    border-radius: 8px;
    position: relative;
  }

  .sidebar .nav-link i {
    margin-right: 10px;
    font-size: 18px;
    margin-left: 10px;
  }

  .sidebar .nav-link span {
  display: none;
  opacity: 0;
  transform: translateX(-10px);
  transition: opacity 0.3s, transform 0.3s; /* Add transition to opacity and transform */
}

  .sidebar .nav-link:hover span {
    display: block;
    position: absolute;
    left: 83px;
    white-space: nowrap;
    background-color: #1a233a;
    padding: 5px 10px;
    border-radius: 5px;
    opacity: 1;
    z-index: 1;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1); /* Enhanced hover effect */
    transform: translateX(0px);
  }

  .sidebar .nav-link:hover {
    color: #fff;
    transform: scale(1.2);
   
    box-shadow: 0 3px 15px rgba(255, 255, 255, 0.1); /* Soft glow effect */
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    body {
      padding-left: 90px;
    }

    .sidebar {
      width: 90px;
      padding: 10px;
    }

    .sidebar .nav-link span {
      display: none;
    }

    .sidebar .nav-link:hover span {
      left: 60px;
    }
  }

  /* Sidebar Brand Styling */
  .sidebar-brand {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    justify-content: center;
    margin-top: 10px;
  }

  .sidebar-brand img {
    width: 60px;
    margin-right: 10px;
    
  }

  /* Bottom Navigation */
  .bottom-nav {
    position: absolute;
    bottom: 0;
    width: 100%;
  }

  .bottom-nav .nav-link {
    display: flex;
    align-items: center;
    padding: 15px;
  }

  .bottom-nav .nav-link i {
    margin-right: 10px;
    font-size: 18px;
  }

  

  /* Divider */
  .sidebar-divider {
    border-top: 1px solid #455a64;
    margin: 20px 0;
  }
  .nav-link.active {
  background-color: #2f55a4; /* A lighter blue shade that complements the dark blue sidebar */
  color: #fff;
}
.notification-count {
  position: absolute;
  top: -5px; /* Adjust to position it above the icon */
  right: -10px; /* Adjust to position it to the right of the icon */
  background-color: red; /* Background color for the count */
  color: white; /* Text color */
  border-radius: 50%; /* Make it circular */
  padding: 2px 6px; /* Padding for the count */
  font-size: 12px; /* Font size */
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

<?php $upcomingCount = countUpcomingAppointmentsForNextWeek(); ?>
<!-- Sidebar Structure -->
<div class="sidebar fixed-top bg-dark">
  <!-- Sidebar Brand -->
  <div class="sidebar-brand">
    <img src="<?= ROOT ?>/assets/nbsc1.png" alt="Brand Logo">
  </div>

  <!-- Sidebar Navigation Links -->
  <ul class="nav flex-column">
    <?php if (Auth::isAdmin() || Auth::isStaff()): ?>
      <li class="nav-item">
      <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'home') ? 'active' : '' ?>" href="<?= ROOT ?>/home">
          <i class="fas fa-home"></i> <span>Dashboard</span>
          
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'users') ? 'active' : '' ?>" href="<?= ROOT ?>/users">
          <i class="fas fa-users"></i> <span>Staff</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'students') ? 'active' : '' ?>" href="<?= ROOT ?>/students">
          <i class="fas fa-graduation-cap"></i> <span>Students</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'violations') ? 'active' : '' ?>" href="<?= ROOT ?>/violations">
          <i class="fas fa-exclamation-triangle"></i> <span>Violations</span>
        </a>
      </li>
      <?php if (Auth::canPerformAction()): ?>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'reports') ? 'active' : '' ?>" href="<?= ROOT ?>/reports">
          <i class="fas fa-chart-line"></i> <span>Reports</span>
        </a>
      </li>
      <?php endif; ?>
      <?php if (Auth::canPerformAction()): ?>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'Printmoral') ? 'active' : '' ?>" href="<?= ROOT ?>/Printmoral">
          <i class="fas fa-certificate"></i> <span>Print Good Moral Certificate</span>
        </a>
      </li>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (Auth::isStudent()): ?>

      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'studentdashboard') ? 'active' : '' ?>" href="<?= ROOT ?>/studentdashboard">
          <i class="fas fa-user-graduate"></i> <span>Student Dashboard</span>
        </a>
      </li>
      <?php endif; ?>
    
      <?php if (Auth::isAdmin()): ?>
      <li class="nav-item">
      <a class="nav-link <?= (basename($_SERVER['REQUEST_URI']) == 'settings') ? 'active' : '' ?>" href="<?= ROOT ?>/settings">
        <i class="fas fa-bell"><h6 style="margin-top: -30px; margin-left: 16px; color: red; font-weight: bold"><?= htmlspecialchars($upcomingCount ) ?></h6></i>
        <span>Notification</span>
      </a>
    </li>
    <?php endif; ?>
  </ul>

  <div class="sidebar-divider"></div>

  <!-- Bottom Navigation Links -->
  <ul class="nav flex-column bottom-nav">
  <li class="nav-item">
  <a class="nav-link" href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?>">
    <i class="fas fa-user"></i> <span>Profile</span>
  </a>
</li>
    <li class="nav-item">
      <a class="nav-link" href="<?= ROOT ?>/logout">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
      </a>
    </li>
  </ul>
</div>

<script>

  
 // Toggle the sidebar only when the brand or toggle element is clicked
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const body = document.body;
  const isCollapsed = sidebar.classList.toggle('collapsed');

  if (isCollapsed) {
    body.style.paddingLeft = '90px';
  } else {
    body.style.paddingLeft = '250px';
  }

  // Store sidebar state in localStorage
  localStorage.setItem('sidebarCollapsed', isCollapsed);
}

// Apply the stored sidebar state on page load
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.querySelector('.sidebar');
  const body = document.body;
  const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

  // Apply the stored state on page load
  if (isCollapsed) {
    sidebar.classList.add('collapsed');
    body.style.paddingLeft = '90px';
  } else {
    sidebar.classList.remove('collapsed');
    body.style.paddingLeft = '250px';
  }

  // Only collapse on smaller screens initially, not after navigation clicks
  if (window.innerWidth <= 768) {
    sidebar.classList.add('collapsed');
    body.style.paddingLeft = '90px';
  }

  // Listen for window resize but don't toggle automatically on clicks
  window.addEventListener('resize', () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.add('collapsed');
      body.style.paddingLeft = '90px';
    } else if (!localStorage.getItem('sidebarCollapsed')) {
      sidebar.classList.remove('collapsed');
      body.style.paddingLeft = '250px';
    }
  });

  // Prevent sidebar toggling when clicking navigation links
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.stopPropagation();  // Ensure no toggle or animation happens
    });
  });
});

</script>
