<div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <img src="<?php echo getConfig('mediaUrl').'/images/logo.png'?>">

            </div>
            <h3><?php echo __('welcome_to_ctrl');?></h3>
            
            <p><?php echo __('rv');?></p>
            <?php 
        
            if($oSession->getSession('sDisplayMessage'))
            {
               echo "<div class='validation_message'>".$oSession->getSession('sDisplayMessage',true)."</div>";
            }
         ?>
            <form class="m-t" role="form" action="" method="POST">
                <div class="form-group">
                    <input type="text" name="user_email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
            </form>
            <p class="m-t"> <small>CTRL Cunstruction Controller &copy; 2014</small> </p>
        </div>
    </div>