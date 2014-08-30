<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div id="middle">
	<div class="outerwrapper">
	  <div class="wrapper">
		<div id="side-menu">
		  <h3><?php echo __('contact_us');?></h3>
		  <ul class="form-control-button">
			<li><a href="#form-personal" class="btn-form" rel="form-personal">
				<?php echo __('contact_personal');?>
			</a></li>
			<li><a href="#form-corporate" class="btn-form" rel="form-corporate">
				<?php echo __('contact_corporate');?>
			</a></li>
		  </ul>
		</div>
		<div id="main-content" class="right">
			<div class="left clearfix">				
				<section id="form-personal">
					<h3><?php echo __('contact_personal');?></h3>
					<?php echo Form::open(URL::site('xhr_contact'),
							array('name'=>'personal','id'=>'personal-form','class'=>'contact','method'=>'POST')); ?>
					<?php echo Form::hidden('contact','personal');?>		
					  <table width="100%" border="0" cellpadding="0" class="table-condensed">
						<tr>
						  <td colspan="2"><?php echo __('send_email');?></td>
						</tr>
						<tr>
							<td colspan="4">								
							<div class="loader"><img src="<?php echo IMG; ?>themes/loading.gif" alt="preloader"/>Submitting...</div>
							<div class="callback"></div>
							</td>
						</tr>
						<tr>
						  <td width="150"><label for="name"><?php echo __('name');?><span>*</span></label></td>
						  <td>
							<?php echo Form::input('name','',array('placeholder'=>__('name') . '...'));?>
						  </td>
						</tr>
						<tr>
						  <td><label for="email"><?php echo __('email');?><span>*</span></label></td>
						  <td><?php echo Form::input('email','',array('placeholder'=>__('email') . '...'));?></td>
						</tr>
						<tr>
						  <td><label for="phone"><?php echo __('phone');?><span>*</span></label></td>
						  <td><?php echo Form::input('phone','',array('placeholder'=>__('phone') . '...'));?></td>
						</tr>
						<tr>
						  <td style="vertical-align:top !important;">
							 <label for="message"><?php echo __('message');?><span>*</span></label>
						  </td>
						  <td><?php echo Form::textarea('message', '', array('placeholder'=> __('message') . '...'), TRUE);?></td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>
					  <a href="<?php echo URL::site('contact-us/captcha_reload'); ?>" id="reload_captcha" title="<?php echo __('captcha_reload');?>" class="reload_captcha inpLogin"><?php echo $captcha->render(); ?>
					  </a>
						  </td>
						</tr>
						<tr>
						  <td><label for="captcha"><?php echo __('captcha');?><span>*</span></label></td>
						  <td><?php echo Form::input('captcha','',array('placeholder'=>__('captcha') . '...','style'=>'width:90px'));?></td>
						</tr>
						<tr>
							<td>&nbsp;<div class="label label-danger"></div></td>
						  <td>
								<?php echo Form::button('button', __('submit'), array('class'=>'button','type'=>'submit'));?>
								<?php echo Form::button('reset', __('reset'), array('class'=>'button','type'=>'reset'));?>
						  </td>
						</tr>
					  </table>
					<?php echo Form::close();?>		
				</section>	
				<section id="form-corporate" class="left clearfix">
					<h3><?php echo __('contact_corporate');?></h3>
					<?php echo Form::open(URL::site('xhr_contact'),
							array('name'=>'corporate','id'=>'corporate-form','class'=>'contact','method'=>'POST')); ?>
					<?php echo Form::hidden('contact','corporate');?>							
					  <table width="100%" border="0" cellpadding="0" class="table-condensed">
						<tr>
						  <td colspan="2"><?php echo __('send_email');?></td>
						</tr>
						<tr>
							<td colspan="4">								
							<div class="loader"><img src="<?php echo IMG; ?>themes/loading.gif" alt="preloader"/></div>
							<div class="callback"></div>
							</td>
						</tr>
						<tr>
						  <td width="150"><label for="name"><?php echo __('name');?><span>*</span></label></td>
						  <td>
							<?php echo Form::input('name','',array('placeholder'=>__('name') . '...'));?>
						  </td>
						</tr>
						<tr>
						  <td width="150"><label for="corporatemobile"><?php echo __('mobile');?><span>*</span></label></td>
						  <td>
							<?php echo Form::input('corporatemobile','',array('placeholder'=>__('mobile') . '...'));?>
						  </td>
						</tr>
						<tr>						
						  <td width="150"><label for="corporatephone"><?php echo __('phone');?><span>*</span></label></td>
						  <td>
							<?php echo Form::input('corporatephone','',array('placeholder'=>'021','style'=>'width:275px'));?>
						  </td>								
						</tr>
						<tr>
						  <td><?php echo __('fax');?><span></span></td>
						  <td>
							  <?php echo Form::input('corporatefax','',array('placeholder'=>__('corporatefax') . '...'));?>						  
						  </td>
						</tr>
						<tr>
						  <td><label for="corporateemail"><?php echo __('email');?><span>*</span></label></td>
						  <td>
						  <?php echo Form::input('corporateemail','',array('placeholder'=>__('corporateemail') . '...'));?>
						  </td>
						</tr>
						<tr>
						  <td><label for="corporateemail"><?php echo __('corporatename');?><span>*</span></label></td>
						  <td>
						  <?php echo Form::input('corporatename','',array('placeholder'=>__('corporatename') . '...'));?>
						  </td>
						</tr>
						<tr>
						  <td style="vertical-align:top !important;"><?php echo __('corporateaddress');?><span></span></td>
						  <td>
							  <?php echo Form::textarea('corporateaddress','',array('placeholder'=>__('corporateaddress') . '...'));?>						  
						  </td>
						</tr>
						<tr>
						  <td><?php echo __('corporatewebsite');?><span></span></td>
						  <td>
							  <?php echo Form::input('corporatewebsite','',array('placeholder'=>'http://'));?>
						  </td>
						</tr>
						<tr>
						  <td style="vertical-align:top !important;"><label for="corporatemessage"><?php echo __('message');?> <span>*</span></label></td>
						  <td>
							  <?php echo Form::textarea('corporatemessage','',array('placeholder'=>__('message') . '...'));?>						  
						  </td>
						</tr>
						<tr>
						  <td><label for="captcha"><?php echo __('captcha');?><span>*</span></label></td>
						  <td>
							  <a href="<?php echo URL::site('contact-us/captcha_reload'); ?>" id="reload_captcha" title="<?php echo __('captcha_reload');?>" class="reload_captcha inpLogin"><?php echo $captcha->render(); ?>
							  </a>
								<br/>
								<?php echo Form::input('captcha','',array('placeholder'=>__('captcha') . '...','style'=>'width:90px'));?>
						  </td>
						</tr>
						<tr>
							<td>&nbsp;<div class="label label-danger"></div></td>
							<td>
								<?php echo Form::button('button', __('submit'), array('class'=>'button','type'=>'submit'));?>
								<?php echo Form::button('reset', __('reset'), array('class'=>'button','type'=>'reset'));?>
							</td>
						</tr>
					  </table>
					<?php echo Form::close();?>
				  </section>
				</div>	  
			<div class="clear"></div>	
			  <div id="address" class="row">
				<div class="col-xs-5 left"> 
				  <h6><strong><?php echo __('address');?>:</strong></h6>
				  <?php echo strip_tags(@$address);?>
				</div>
				<div class="right">
					<?php if (!empty($no_contact)) { ?>
					<h6><?php echo __('support_division');?></h6>			
					<?php foreach ($no_contact as $contact){ ?>
						<div>
							<?php 
							echo Lib::_trim_strip($contact->alias) .'&nbsp;: ';
							echo Lib::_trim_strip($contact->value);
							?>
						</div>						
					<?php } 
					}
						if (!empty($sales_email)) { echo Lib::_trim_strip($sales_email->alias);?> : <?php echo Lib::_trim_strip($sales_email->value); } 
					?>
				</div>
			  </div>
			</div>
			<div class="clear"></div>
		  </div>
		</div>
	</div>
