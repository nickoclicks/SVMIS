<?php
          $image = $row->image;
          if(!file_exists($image)){
              $image = 'assets/female.png';
            if($row->gender == 'male'){
              $image = 'assets/male.png';
            }
          }
        ?>

    <div class="card m-2 shadow" style="max-width: 12rem; min-width: 12rem;">
      <div class="card-header">User Profile</div>
      <center><img src="<?=$image?>" class="card-img-top" style="width: 150px;" alt="Card image cap"></center>
      <div class="card-body">
        <center><h5 class="card-title"><?=$row->firstname?> <?=$row->lastname?></h5></center>
        <center><p class="card-text" style="margin-bottom: 10px; margin-top: -10px"><?=ucwords(str_replace("_", " ", $row->rank))?></p></center>
       <a href="<?=ROOT?>/profile/<?=$row->user_id?>" class="btn btn-primary">Profile</a>

       <?php if(isset($_GET['select'])):?>
       <button name="selected" value="<?=$row->user_id?>" class="btn btn-danger float-end">Select</button>
          <?php endif;?>
      </div>
    </div>