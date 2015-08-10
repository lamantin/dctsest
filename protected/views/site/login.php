<div class="content">
                <!-- SECTION TITLE -->
            
                <h3 class="block_title" data-translate="login">Login</h3>
                <!-- /SECTION TITLE -->

                <!-- SECTION TILES -->
                <div class="tile black htmltile w3 h4">
                    <div class="tilecontent">
                        <div class="content" >
                            <?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contactme',
		'enableClientValidation'=>false,
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
			<?php echo $form->textField($model,'email', array('class'=>'form-control','id'=>'email')); ?>
			<?php echo $form->error($model,'email'); ?>
                                </div>


                                <div class="form-group">
                                   <?php echo $form->labelEx($model,'password'); ?>
                                   <?php echo $form->passwordField($model,'password', array('class'=>'form-control')); ?>
                                   <?php echo $form->error($model,'password'); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->checkBox($model,'rememberMe'); ?>
                                    <?php echo $form->label($model,'rememberMe'); ?>
                                    <?php echo $form->error($model,'rememberMe'); ?>
                                </div>
    
                                <div class="row-fluid">

                                    <?php echo CHtml::submitButton('Login', array('class'=>'button_big_register')); ?>
                                </div>
                        </div>
                    </div>
                    </div>
    <?php if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget('CCaptcha'); ?>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                </div>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        <?php endif; ?>
                 <?php $this->endWidget(); ?>
                <!-- /SECTION TILES -->

            </div>
            <!-- /SECTION -->
