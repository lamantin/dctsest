            <!-- SECTION -->
            <div class="content">

                <!-- SECTION TITLE -->
           
                 <h3 class="block_title" data-translate="register">Create Account</h3>
                <!-- /SECTION TITLE -->
             
                <!-- SECTION TILES -->
                <div class="tile black htmltile w3 h4">
                    <div class="tilecontent">
                        <div class="content">
                            <?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contactme',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),'htmlOptions'=>array(
                    'class'=>'form-dark',
                      'name'=>'cform',
                    'style'=>'font-size:13px;'
                    ),
	)); ?>
                               <div class="form-group">
			  <?php echo $form->labelEx($model,'email'); ?>
                          <?php echo $form->textField($model,'email', array('class'=>'form-control')); ?>
                          <?php echo $form->error($model,'email'); ?>
                                </div>
                               <div class="form-group">
			  <?php echo $form->labelEx($model,'username'); ?>
                          <?php echo $form->textField($model,'username', array('class'=>'form-control')); ?>
                          <?php echo $form->error($model,'username'); ?>
                                </div>



                                <div class="form-group">
                                   <?php echo $form->labelEx($model,'password'); ?>
                                   <?php echo $form->passwordField($model,'password', array('class'=>'form-control')); ?>
                                   <?php echo $form->error($model,'password'); ?>
                                </div>
                                <div class="form-group">
                                  <?php echo $form->labelEx($model,'retype password'); ?>
                                   <?php echo $form->passwordField($model,'retypepasswordpassword', array('class'=>'form-control')); ?>
                                   <?php echo $form->error($model,'retypepasswordpassword'); ?>
                                </div>
 
                                <div class="row-fluid">

                                    <?php echo CHtml::submitButton('Sign in', array('class'=>'btn button_big_register btn-default')); ?>
                                </div>
                        </div>
                    </div>
                    </div>

                 <?php $this->endWidget(); ?>
                <!-- /SECTION TILES -->

            </div>
            <!-- /SECTION -->
