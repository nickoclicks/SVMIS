<?php $this->view('includes/header'); ?>


<div class="container-fluid">
  <form method="post" class="needs-validation" novalidate>
    <div class="p-4 mx-auto shadow rounded" style="width: 100%; max-width: 900px; margin-top: 10px; overflow: hidden;">
      <h2 class="text-center mb-4">NBSC - Prefect of Discipline</h2>
      <img src="assets/nbsc1.png" class="border d-block mx-auto mb-4" style="width: 100px;">

      <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error:</strong>
          <?php foreach($errors as $error): ?>
            <br><?=$error?>
          <?php endforeach; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- Personal Information Section -->
      <h5 class="mt-3 mb-2">Personal Information</h5>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group my-2">
            <label for="firstname" class="form-label">Firstname</label>
            <input class="form-control" id="firstname" value="<?=get_var('firstname')?>" type="text" name="firstname" placeholder="Firstname" required>
            <div class="invalid-feedback">Please provide a firstname.</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group my-2">
            <label for="middlename" class="form-label">Middlename</label>
            <input class="form-control" id="middlename" value="<?=get_var('middlename')?>" type="text" name="middlename" placeholder="Middlename" required>
            <div class="invalid-feedback">Please provide a middlename.</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group my-2">
            <label for="lastname" class="form-label">Lastname</label>
            <input class="form-control" id="lastname" value="<?=get_var('lastname')?>" type="text" name="lastname" placeholder="Lastname" required>
            <div class="invalid-feedback">Please provide a lastname.</div>
          </div>
        </div>
      </div>

      <div class="row">
      <div class="col-md-4">
          <div class="form-group my-2">
            <label for="std_id" class="form-label">ID</label>
            <input class="form-control" id="std_id" value="<?=get_var('std_id')?>" type="text" name="std_id" placeholder="<?= ($mode == 'students') ? 'Student ID' : 'Staff ID' ?>" required>
            <div class="invalid-feedback">Please provide a valid ID.</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group my-2">
            <label for="email" class="form-label">Email</label>
            <input class="form-control" id="email" value="<?=get_var('email')?>" type="email" name="email" placeholder="Email" required>
            <div class="invalid-feedback">Please provide a valid email address.</div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="form-group my-2">
              <label for="phone" class="form-label">Phone</label>
              <input class="form-control" id="phone" value="<?=get_var('phone')?>" type="tel" name="phone" placeholder="Phone" required>
              <div class="invalid-feedback">Please provide a valid phone number.</div>
            </div>
          
        </div>
      </div>

      <!-- Address Section -->
      <h5 class="mt-4">Address</h5>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group my-2">
            <label for="street" class="form-label">Street</label>
            <input class="form-control" id="street" value="<?=get_var('street')?>" type="text" name="street" placeholder="Street" required>
            <div class="invalid-feedback">Please provide a valid street address.</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group my-2">
            <label for="barangay" class="form-label">Barangay</label>
            <input class="form-control" id="barangay" value="<?=get_var('barangay')?>" type="text" name="barangay" placeholder="Barangay" required>
            <div class="invalid-feedback">Please provide a valid barangay.</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group my-2">
            <label for="city" class="form-label">City</label>
            <input class="form-control" id="city" value="<?=get_var('city')?>" type="text" name="city" placeholder="City" required>
            <div class="invalid-feedback">Please provide a valid city.</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group my-2">
            <label for="municipality" class="form-label">Municipality</label>
            <input class="form-control" id="municipality" value="<?=get_var('municipality')?>" type="text" name="municipality" placeholder="Municipality" required>
            <div class="invalid-feedback">Please provide a valid municipality.</div>
          </div>
        </div>
      </div>

      <!-- Academic Information Section -->
      <?php if ($mode == 'students'): ?>
        <h5 class="mt-4">Academic Information</h5>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group my-2">
              <label for="year_level" class="form-label">Year Level</label>
              <input class="form-control" id="year_level" value="<?=get_var('year_level')?>" type="text" name="year_level" placeholder="Year Level" required>
              <div class="invalid-feedback">Please provide a valid year level.</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group my-2">
              <label for="course" class="form-label">Course</label>
              <input class="form-control" id="course" value="<?=get_var('course')?>" type="text" name="course" placeholder="Course" required>
              <div class="invalid-feedback">Please provide a valid course.</div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Gender Selection -->
      <div class="row">
        <div class="col-md-6">
          <div class="form-group my-2">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
              <option <?=get_select('gender', '')?> value="">-----SELECT SEX-----</option>
              <option <?=get_select('gender', 'male')?> value="male">Male</option>
              <option <?=get_select('gender', 'female')?> value="female">Female</option>
            </select>
            <div class="invalid-feedback">Please select a gender.</div>
          </div>
        </div>

        <div class="col-md-6">
          <?php if($mode == 'students'): ?>
            <input type="hidden" value="student" name="rank">
          <?php else: ?>
            <div class="form-group my-2">
              <label for="rank" class="form-label">Rank</label>
              <select class="form-control" id="rank" name="rank" required>
                <option <?=get_select('rank', '')?> value="">-----SELECT RANK-----</option>
                <?php if(Auth::getRank() == 'super_admin'): ?>
                  <option <?=get_select('rank', 'super_admin')?> value="super_admin">Super Admin</option>
                <?php endif; ?>
                <option <?=get_select('rank', 'admin')?> value="admin">Admin</option>
                <option <?=get_select('rank', 'staff')?> value="admin">Staff</option>
                <?php if(Auth::getRank() == 'super_admin'): ?>
                <option <?=get_select('rank', 'student')?> value="student">Student</option>
                <?php endif ?>
              </select>
              <div class="invalid-feedback">Please select a rank.</div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Account Information Section -->
       <div class="row">
       <div class="col-md-6">
      <div class="form-group mb-4">
        <label for="password" class="form-label">Password</label>
        <input class="form-control" id="password" value="<?=get_var('password')?>" type="password" name="password" placeholder="Password" required>
        <div class="invalid-feedback">Please provide a password.</div>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group mb-4">
        <label for="password2" class="form-label">Retype Password</label>
        <input class="form-control" id="password2" value="<?=get_var('password2')?>" type="password" name="password2" placeholder="Retype Password" required>
        <div class="invalid-feedback">Please retype the password.</div>
      </div>
      </div>
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-between mt-4">
        <button class="btn btn-primary" type="submit">Add User</button>
        <a href="<?=ROOT?>/<?=($mode == 'students') ? 'students' : 'users'?>" class="btn btn-danger">CANCEL</a>
      </div>
    </div>
  </form>
</div>

<script>
// Bootstrap form validation script
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})();
</script>

<?php $this->view('includes/footer'); ?>
