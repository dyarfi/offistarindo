<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript"></script>
<h2><?php echo $module_menu;?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
	<div id="forms_holder">
	<?php
		echo Form::open(ADMIN.$class_name.'/index',array('method'=>'post','id'=>'listing_search'));
	?>
		<select name="field" id="field">
			<?php foreach ($search_keys as $row => $label) : ?>
			<option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
		</select>
	<?php
		echo Form::input('keyword',$keyword,array('class'=>'','id'=>'keyword'));
		echo Form::submit('find','',array('class'=>'btn_find','id'=>'find'));
		echo Form::close();
	?>
	<?php		
		echo Form::open(ADMIN.$class_name.'/add',array('method'=>'post','id'=>'listing_add'));
		echo Form::submit('','',array('class'=>'btn_add'));
		echo Form::close();
	?>
	</div>
<?php if (count($listings) == 0) :?>
	<div class="ls15 clear"></div>
		<h3 class="warning3"><?php echo i18n::get('error_no_data'); ?></h3>
	<div class="ls15"></div>
<?php else : ?>
<?php		
echo Form::open(ADMIN.$class_name.'/change',array('method'=>'post','class'=>'form_details')); 
echo Form::hidden('page',$page_index);
echo Form::hidden('order',$order);
echo Form::hidden('sort',$sort);
?> 
        <table class="listing_data">
            <thead>
                <tr>
                    <th><input type="checkbox" name="check_all" id="check_all" /></th>
                    <th><strong>#</strong></th>
                    <?php foreach ($table_headers as $key => $value) : ?>
                    <?php
                        if ($sort == $key) :
                            if ($order == 'asc') :
                                $order = 'desc';
                                $order_sign	= '&nbsp;<img src="'.IMG.'admin/order-asc.gif" alt="&or;" />';
                            else :
                                $order = 'asc';
                                $order_sign	= '&nbsp;<img src="'.IMG.'admin/order-desc.gif" alt="&and;" />';
                            endif;
                    ?>
                    <th><a href="<?php echo URL::site(ADMIN.$class_name.'/index/sort/'.$key.'/order/'.$order.$page_url); ?>" id="active_col"><?php echo $value . $order_sign; ?></a></th>
                    <?php else : ?>
                    <th><a href="<?php echo URL::site(ADMIN.$class_name.'/index/sort/'.$key.'/order/asc/'.$page_url); ?>"><?php echo $value; ?></a></th>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = $pagination->current_first_item;
					$index = 1;	
                    foreach ($listings as $row) :
						$class      = $index % 2 == 0 ? 'even' : 'odd';
						if ($row->status == 'verified' ) { $class = 'green'; }
						if ($row->status == 'inactive' ) { $class = 'yellow'; }
						if ($row->status == 'blocked' ) { $class = 'red_row'; }
                ?>
                <tr class="<?php echo ($i % 2) ? 'even_row' : 'odd_row'; ?> <?php echo ($row->status != $statuses[0]) ? 'red_row' : ''; ?> <?php echo !empty($class) ? 'listing_'.$class : '';?>">
                        <td align="center">
                        <?php if (!$row->is_system && Session::instance()->get('user_id') != $row->id) { ?>
                            <input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" />
                        <?php } ?>
                        </td>
                        <td align="center"><?php echo $i; ?></td>
                        <!--td><strong><a href="<?php echo URL::site(ADMIN.'user/view/' . $row->id); ?>"><?php echo $row->email; ?></a></strong></td-->
						<td><strong><?php echo $row->name; ?></strong></td>
                        <td><a href="mailto:<?php echo $row->email; ?>" title="Send e-mail to <?php echo $row->name; ?>"><?php echo $row->email; ?></a></td>
                        <td align="center">
						<?php 
							echo !empty($user_level[$row->level_id]) ? $user_level[$row->level_id] : '(No Level)';
						?>
						</td>
						<td align="center">
						<?php 
							$arr_status = i18n::get('status_value_user');
							//echo ucfirst($arr_status[$row->status]); 
							echo ucfirst($row->status); 
						?>
						</td>
						<td align="center"><?php echo date(Lib::config('admin.date_format'), $row->last_login); ?></td>
                        <td><?php echo date(Lib::config('admin.date_format'), $row->added); ?></td>
                        <td>
                            <a class="view" title="View" href="<?php echo URL::site(ADMIN.$class_name.'/view/' . $row->id); ?>">View</a>
                            <a class="edit" title="Edit" href="<?php echo URL::site(ADMIN.$class_name.'/edit/' . $row->id); ?>">Edit</a>
                            <?php if (!$row->is_system && Session::instance()->get('user_id') != $row->id) { ?>
                                <a class="delete <?php echo $class_name;?>" title="Inactive" href="<?php echo URL::site(ADMIN.$class_name.'/delete/' . $row->id); ?>" pid="<?php echo $row->id;?>">Inactive</a>
								<?php if ($row->status != 'active'):?>
									<!--a class="delete users" pid="<?php echo $row->id;?>"></a-->
								<?php endif;?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                        $i++;
						$index++;
                    endforeach;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td id="corner"><img src="<?php echo IMG; ?>admin/list-corner.gif"/></td>
                    <td colspan="<?php echo (count($table_headers) + 2); ?>">
                        <div id="selection">
                            <?php echo i18n::get('changed_status'); ?> : 
                            <select name="select_action" id="select_action">
                                <option value="">&nbsp;</option>
                                <?php foreach ($statuses as $row) : ?>
                                <option value="<?php echo $row; ?>"><?php echo ucfirst($row); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="table_pagination"><?php echo $pagination->render(); ?></div>
                    </td>
                </tr>
            </tfoot>
        </table>
<?php 
echo Form::close();
?>
<div class="ls4"></div>
<div>Total Records : <?php echo $total_record;?></div>
<div class="ls5"></div>
<?php endif; ?>
<div class="ls5"></div>
<div class="bar"></div>