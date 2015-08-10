<h3> Test application</h3>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->isGuest) { ?>
<div class="btn-group" role="group" aria-label="main">
  <a href="/site/login"><button type="button" class="btn btn-default btn-success">Login</button></a>
  <a href="/register"><button type="button" class="btn btn-default btn-danger">Register</button></a>
  
</div>
<?php } else { ?>
<h1 style="color:white;">Welcome  <?php  echo (Yii::app()->user->username());?>!</h1>
<p style="color:white;">This is a protected content what you can't see if you are not logged in .</p>
  <a href="/site/logout"><button type="button" class="btn btn-default btn-success">Logout</button></a>

<?php } ?>
