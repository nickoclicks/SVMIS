<style>
  /* Main Body Styling */
 /* Main Body Styling */
body {
  padding-left: 250px;
  transition: padding-left 0.3s ease;
}

/* Sidebar Styling */
.sidebar {
  background-color: darkblue !important;
  padding: 20px;
  text-align: left;
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
  width: 250px;
  height: 100vh;
  transition: width 0.5s, padding-left 0.5s;
}

.sidebar.collapsed {
  width: 90px;
}

/* Sidebar Navigation Links */
.sidebar .nav-link {
  color: whitesmoke;
  font-size: 17px;
  padding-bottom: 20px;
  display: flex;
  align-items: center;
  transition: all 0.3s ease-in-out;
}

.sidebar .nav-link i {
  margin-right: 10px;
  font-size: 20px;
}

.sidebar.collapsed .nav-link span {
  display: none;
}

.sidebar.collapsed .nav-link:hover span {
  display: block;
  position: absolute;
  left: 100px;
  white-space: nowrap;
  background-color: #1a233a;
  padding: 5px 10px;
  border-radius: 5px;
  z-index: 1;
}

.sidebar .nav-link:hover {
  color: whitesmoke;
  transform: scale(1.1);
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
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

  .sidebar.collapsed .nav-link:hover span {
    left: 60px;
  }
}

/* Sidebar Brand Styling */
.sidebar-brand {
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  cursor: pointer;
}

.sidebar-brand img {
  width: 50px;
  margin-right: 10px;
}

.sidebar-brand h5 {
  margin: 0;
  color: white;
}

.sidebar.collapsed .sidebar-brand h5 {
  display: none;
}

.sidebar-divider {
  border-top: 1px solid #455a64;
  margin-top: 20px;
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
}

.bottom-nav .nav-link i {
  margin-right: 10px;
  font-size: 18px;
}

 /* Ensure hover effect works */
 .nav-item {
        position: relative;
    }

    .hover-buttons {
        display: none;
    }

    .nav-item:hover .hover-buttons {
        display: block;
    }

    /* Styling for the hover buttons */
    .hover-buttons a {
        text-decoration: none;
        color: #000;
        display: block;
        padding: 10px;
    }

    .hover-buttons a:hover {
        background-color: gray;
    }

</style>

<!-- Sidebar Structure -->
<div class="sidebar fixed-top bg-dark">
  <!-- Sidebar Brand -->
  <div class="sidebar-brand" onclick="toggleSidebar()">
    <img src="<?= ROOT ?>/assets/nbsc1.png" alt="Brand Logo">
    <h5>Prefect of Discipline</h5>
  </div>

  <!-- Sidebar Navigation Links -->
  <ul class="nav flex-column">
    <!-- Admin/Super Admin Links -->
    <?php if (Auth::isAdmin() || Auth::isStaff()): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/home">
          <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/users">
          <i class="fas fa-users"></i> <span>Staff</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/students">
          <i class="fas fa-graduation-cap"></i> <span>Students</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/violations">
          <i class="fas fa-exclamation-triangle"></i> <span>Violations</span>
        </a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/analytics">
          <i class="fas fa-chart-bar"></i> <span>Analytics</span>
        </a>
      </li>-->
      <?php if (Auth::canPerformAction()): ?>
      <li class="nav-item" style="position: relative;">
    <a class="nav-link" href="<?= ROOT ?>/Sdcs">
        <i class="fas fa-print"></i> <span>Reports</span>
    </a>
    <?php endif ?>
    
    <!-- Hidden Buttons for Complaints and Violations 
    <div class="hover-buttons" style="position: absolute; top: 100%; left: 0; background-color: gray; z-index: 100; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10%; width: 60%; text-align: center">
        <a class="nav-link" href="<?= ROOT ?>/Sdcs" style="padding: 10px; display: block;">Complaints</a>
        <a class="nav-link" href="<?= ROOT ?>/students" style="padding: 10px; display: block;">Violations</a>
    </div>-->
</li>

      <!--<li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/resolutions">
          <i class="fas fa-check"></i> <span>Resolution</span>
        </a>
      </li>
    <?php endif; ?>
    
    <!-- Student-Specific Links -->
    <?php if (Auth::isStudent() || Auth::isStaff()): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?= ROOT ?>/studentdashboard">
          <i class="fas fa-user-graduate"></i> <span>Student Dashboard</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>

  <div class="sidebar-divider"></div>

  <!-- Bottom Navigation Links -->
  <ul class="nav flex-column bottom-nav">
    <li class="nav-item">

      <a class="nav-link" href="<?= ROOT ?>/profile">
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

// Apply stored sidebar state on page load
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.querySelector('.sidebar');
  const body = document.body;
  const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

  if (isCollapsed) {
    sidebar.classList.add('collapsed');
    body.style.paddingLeft = '90px';
  } else {
    sidebar.classList.remove('collapsed');
    body.style.paddingLeft = '250px';
  }

  // Collapse the sidebar on smaller screens
  if (window.innerWidth <= 768) {
    sidebar.classList.add('collapsed');
    body.style.paddingLeft = '90px';
  }

  // Adjust padding and sidebar on window resize
  window.addEventListener('resize', () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.add('collapsed');
      body.style.paddingLeft = '90px';
    } else {
      sidebar.classList.remove('collapsed');
      body.style.paddingLeft = '250px';
    }
  });
});

</script>
