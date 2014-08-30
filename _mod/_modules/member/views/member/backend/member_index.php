<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo $module_menu; ?></h2>
<div class="form_wrapper">
    <div id="forms_holder">
        <form id="listing_search" action="<?php echo URL::site() .'admin-cp/'. $module_name; ?>/index" method="post">
            <select name="field" id="field">
                <?php foreach ($search_keys as $row => $label) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
            <input type="submit" name="find" id="find" class="btn_find" value="" />
        </form>
        <form id="listing_add" action="<?php echo URL::site() .'admin-cp/'. $module_name; ?>/add" method="get">
            <input type="submit" class="btn_add new agent" value="" />
        </form>
    </div>	
<div class="ls5"></div>
<?php if (count($listings) == 0) :?>
<h3>There is not available data to display</h3>
<?php else : ?>
<?php		
echo Form::open('admin-cp/'.$module_name.'/change',array('method'=>'post','class'=>'form_details')); 
echo Form::hidden('page',$page_index);
echo Form::hidden('order',$order);
echo Form::hidden('sort',$sort);
?> 
	<table class="listing_table listing_data">
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
				<th>
					<?php if (!is_numeric($key)) : ?>
					<a href="<?php echo URL::site('admin-cp/'.$module_name.'/index/sort/'.$key.'/order/'.$order.$page_url); ?>" id="active_col"><?php echo $value.$order_sign; ?></a>
					<?php else : ?>
					<?php echo $value; ?>
					<?php endif; ?>
				</th>
				<?php else : ?>
				<th>
					<?php if (!is_numeric($key)) : ?>
					<a href="<?php echo URL::site('admin-cp/'.$module_name.'/index/sort/'.$key.'/order/asc/'.$page_url); ?>"><?php echo $value; ?></a>
					<?php else : ?>
					<?php echo $value; ?>
					<?php endif; ?>
				</th>
				<?php endif; ?>
				<?php endforeach; ?>
				<th>Functions</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i	= $page_index + 1;
				$item_list		= $pagination->current_first_item;
				$index = 1;
				foreach ($listings as $row) :
					$class      = $index % 2 == 0 ? 'even' : 'odd';
					if ($row->status == 'verified' ) { $class = 'green'; }
					if ($row->status == 'inactive' ) { $class = 'yellow'; }
					if ($row->status == 'blocked' ) { $class = 'red_row'; }
                ?>
                <tr id="row_<?php echo $row->id; ?>" class="<?php echo ($i % 2) ? 'even_row' : 'odd_row'; ?> <?php echo ($row->status != $statuses[0]) ? 'red_row' : ''; ?> <?php echo !empty($class) ? 'listing_'.$class : '';?>">
					<td align="center">
						<?php if (!$row->is_system && Session::instance()->get('user_id') != $row->id) { ?>
							<input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" />
						<?php } ?>
					</td>
					<td><?php echo $item_list; ?></td>
					<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
					<td>
						<strong><a href="<?php echo URL::site('admin-cp/'.$module_name.'/view/' . $row->id); ?>">
						<?php echo ucfirst($row->name); ?></a>
						</strong>
					</td>
					<td><?php echo (!empty($profiles[$row->id]->gender)) ? ucfirst($profiles[$row->id]->gender) : '-'; ?></td>	
					<td><?php echo (!empty($profiles[$row->id]->birthday)) ? ucfirst($profiles[$row->id]->birthday) : '-'; ?></td>	
					<td><?php echo (!empty($profiles[$row->id]->country)) ? ucfirst($profiles[$row->id]->country) : '-'; ?></td>
					<td><?php echo (!empty($profiles[$row->id]->state)) ? ucfirst($profiles[$row->id]->state) : '-'; ?></td>
					<td><?php echo (!empty($profiles[$row->id]->city)) ? ucfirst($profiles[$row->id]->city) : '-'; ?></td>
					<td><?php echo (!empty($profiles[$row->id]->phone)) ? ucfirst($profiles[$row->id]->phone) : '-'; ?></td>
					<td><?php echo (!empty($profiles[$row->id]->status)) ? ucfirst($profiles[$row->id]->status) : '-'; ?></td>
					<td align="center"><?php echo (!empty($profiles[$row->id]->added)) ? date(Lib::config('admin.date_format'), $profiles[$row->id]->added) : '-'; ?></td>
					<td align="center"><?php echo (!empty($profiles[$row->id]->modified)) ? date(Lib::config('admin.date_format'), $profiles[$row->id]->modified) : '-'; ?></td>
					<td align="center" width=11%">
						<a class="view" title="View" href="<?php echo URL::site('admin-cp/'.$module_name.'/view/' . $row->id); ?>">View</a>
						<a class="edit" title="Edit" href="<?php echo URL::site('admin-cp/'.$module_name.'/edit/' . $row->id); ?>">Edit</a>
						<a class="delete" title="Delete" href="<?php echo URL::site('admin-cp/'.$module_name.'/delete/' . $row->id); ?>">Delete</a>
					</td>
				</tr>
			<?php
					$index++;	
					$item_list++;
					$i++;
				endforeach;
			?>
		</tbody>
		<tfoot>
			<tr>
				<td id="corner"><img src="<?php echo IMG; ?>admin/list-corner.gif"/></td>
				<td colspan="<?php echo (count($table_headers) + 2); ?>">
					<div id="selection">
                            Change status :
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
<?php echo Form::close();?>
<div class="ls4"></div>
<div>Total Records : <?php echo $total_record;?></div>
<?php endif; ?>
</div>