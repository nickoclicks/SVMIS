<form method="post" class="form mx-auto" style="width: 100%; max-width: 400px">
  <h4>Remove Violators</h4>
  <input value="<?=get_var('name')?>" autofocus class="form-control" type="text" name="name" placeholder="Students">
  <br>
  <a href="<?=ROOT?>/single_violations/<?=$row->violation_id?>?tab=violators">
    <button type="button" class="btn btn-danger">Cancel</button>
  </a>
  <button class="btn btn-primary float-end" name="search">Search</button>
  <div class="clearfix"></div>
</form>

<br>

<div class="card-group justify-content-center">
  
  <form method="post">

  <?php if(isset($_POST['search']) && empty($_POST['name'])):?>
    <center><hr><h4>Please enter a name to search</h4></center>
  <?php elseif(isset($results) && is_array($results)):?>
    
        <?php foreach ($results as $row):?>

          <?php include(views_path('user'))?>

          
      <?php endforeach;?>
      <?php else:?>

        <?php if(count($_POST) > 0):?>

        <center><hr><h4>No results were found</h4></center>
  <?php endif?>
  <?php endif?>

  </form>
</div>