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

    <div class="dashboard-container">
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
                           
                                <input type="text" name="course" class="form-control" value="<?= $row->course ?>">
                        </div>

                        <div class="col-md-3">
                            <label for="year_level_id">Year Level:</label>
                            
                                <input type="text" name="year_level_id" class="form-control" value="<?= $row->year_level_id ?>">
                            </div>

                            <div class="form-group col-md-3">
                            <label for="rank">Rank:</label>
                           
                                <input type="text" name="rank" class="form-control" value="<?= $row->rank ?>">
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