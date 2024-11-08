<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<form method="post">
    <?php if(count($errors) > 0): ?>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="dashboard-container" style="margin-left: -150px;">
    <div class="row"">
        <div class="">
            <div class="card  style="max-width: 1700px;">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post">

                    <h5 class="fw-bold text-black">Personal Information</h5>
                    <div class="form-group row">
                      
                        

                        <div class="form-group col-md-4">
                            <label for="firstname">Name:</label>
                                <input type="text" name="firstname" class="form-control" value="<?= $row->firstname ?>">
                            </div>
                      

                        <div class="form-group col-md-4">
                            <label for="middlename">Middle Name:</label>
                            
                                <input type="text" name="middlename" class="form-control" value="<?= $row->middlename ?>">
                          
                        </div>
                  

                        <div class="form-group col-md-4">
                            <label for="lastname">Last Name:</label>
                            
                                <input type="text" name="lastname" class="form-control" value="<?= $row->lastname ?>">
                            </div>

                    </div>

                        <div class="form-group row">

                        <div class="form-group col-md-4">
                            <label for="gender">Gender:</label>
                           
                                <input type="text" name="gender" class="form-control" value="<?= $row->gender ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="email">Email:</label>
                         
                                <input type="email" name="email" class="form-control" value="<?= $row->email ?>">
                                </div>
                            <div class="form-group col-md-4">
                            <label for="phone">Phone:</label>
                           
                                <input type="text" name="phone" class="form-control" value="<?= $row->phone ?>">
                                </div>
                        </div>

                        <h5 class="fw-bold text-black">Academic Information</h5>
                        <div class="form-group row">
                        <div class="col-md-3">
                            <label for="name">Student ID:</label>
                                <input type="text" name="name" class="form-control" value="<?= $row->std_id ?>">
                            </div>

                            <div class="form-group col-md-3">
    <label for="course">Course:</label>
    <select name="course" id="courseSelect" class="form-control">
        <option value="" disabled>Select a course</option>
        <option value="BSBA" <?php echo (isset($row->course) && $row->course == 'BSBA') ? 'selected' : ''; ?>>BSBA</option>
        <option value="BSIT" <?php echo (isset($row->course) && $row->course == 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
        <option value="TEP" <?php echo (isset($row->course) && $row->course == 'TEP') ? 'selected' : ''; ?>>TEP</option>
    </select>
</div>

<div class="form-group col-md-3">
    <label for="year_level_id">Year Level:</label>
    <select name="year_level_id" id="year_level_id" class="form-control">
        <option value="" disabled>Select a Year Level</option>
        <option value="1" <?php echo (isset($row->year_level_id) && $row->year_level_id == '1') ? 'selected' : ''; ?>>1st Year</option>
        <option value="2" <?php echo (isset($row->year_level_id) && $row->year_level_id == '2') ? 'selected' : ''; ?>>2nd Year</option>
        <option value="3" <?php echo (isset($row->year_level_id) && $row->year_level_id == '3') ? 'selected' : ''; ?>>3rd Year</option>
        <option value="4" <?php echo (isset($row->year_level_id) && $row->year_level_id == '4') ? 'selected' : ''; ?>>4th Year</option>             
    </select>           
</div>
<div class="form-group col-md-3">
    <label for="rank">Rank:</label>
    <select name="rank" id="rank" class="form-control">
        <option value="admin" <?php echo (isset($row->rank) && $row->rank == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="staff" <?php echo (isset($row->rank) && $row->rank == 'staff') ? 'selected' : ''; ?>>Staff</option>
        <option value="student" <?php echo (isset($row->rank) && $row->rank == 'student') ? 'selected' : ''; ?>>Student</option>
    </select>
</div>
</div>

                        <h5 class="fw-bold text-black">Address</h5>

                       
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="street">Street:</label>
                            
                                <input type="text" name="street" class="form-control" value="<?= $row->street ?>">
                
                        </div>

                        <div class="form-group col-md-6">
                            <label for="barangay">Barangay:</label>
                            
                                <input type="text" name="barangay" class="form-control" value="<?= $row->barangay ?>">
                        </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="city">City:</label>
                           
                                <input type="text" name="city" class="form-control" value="<?= $row->city ?>">
                       
                        </div>

                        <div class="form-group col-md-6">
                            <label for="municipality">Municipality:</label>
                            
                                <input type="text" name="municipality" class="form-control" value="<?= $row->municipality ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                           
                                <button type="submit" class="btn btn-primary mx-auto" style="width: 8%;">Update</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<?php $this->view('includes/footer'); ?>

