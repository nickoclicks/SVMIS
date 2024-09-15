<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
<?php $this->view('includes/crumbs',['crumbs'=>$crumbs]); ?>

    <?php if($row):?>
    <div class="card-group justify-content-center">

    
        <form method="post">
            <h3>Edit School</h3>



            <?php if(count($errors) > 0): ?>

              <div class="alert alert-warning alert-dismissable fade show" role="alert">
                <strong>Error:</strong>
                <?php foreach($errors as $error): ?>
                  <br><?=$error?>
                <?php endforeach;?>
                <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </span>
              </div>

              <?php endif;?>

            <input autofocus class="form-control" type="text" value="<?=get_var('schools',$row->school) ?>" name="school" placeholder="Schoolname"> <br><br>
           
            <input class="btn btn-primary float-end" type="submit" value="Save">
            </a>  
            <a href="<?=ROOT?>/schools"> 
            <input class="btn btn-warning text-white" type="button" value="Cancel">
            </a>
          </form>
    </div>

    <?php else:?>
      <div style="text-align: center;">
            <h3>That school was not found </h3>

            <a href="<?=ROOT?>/schools"> 
            <input class="btn btn-warning text-white" type="button" value="Cancel">
            </a>
            <br><br>
            </div>
          <?php endif;?>
</div>

<?php $this->view('includes/footer'); ?>
