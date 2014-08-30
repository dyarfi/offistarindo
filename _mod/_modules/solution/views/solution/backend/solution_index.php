<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo $module_menu; ?></h2>
<div class="form_wrapper">
    <div id="forms_holder">
        <form id="listing_search" action="<?php echo URL::site(ADMIN.$class_name.'/index'); ?>" method="post">
            <select name="field" id="field">
                <?php foreach ($search_keys as $row => $label) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
            <input type="submit" name="find" id="find" class="btn_find" value="" />
        </form>
        <form id="listing_add" action="<?php echo URL::site(ADMIN.$class_name.'/add'); ?>" method="get">
            <input type="submit" class="btn_add" value="" />
        </form>
    </div>
<div class="ls5"></div>
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
				<th><a href="<?php echo url::site(ADMIN.$class_name.'/index/sort/'.$key.'/order/'.$order.$page_url); ?>" id="active_col"><?php echo $value . $order_sign; ?></a></th>
				<?php else : ?>
				<th><a href="<?php echo url::site(ADMIN.$class_name.'/index/sort/'.$key.'/order/asc/'.$page_url); ?>"><?php echo $value; ?></a></th>
				<?php endif; ?>
				<?php endforeach; ?>
				<th>Functions</th>
			</tr>
		</thead>
		<tbody id="sortable">
			<?php
				$i = $pagination->current_first_item;
				$index = 1;	
				foreach ($listings as $row) :
			?>
				<tr id="<?php echo $row->category_id;?>[row_<?php echo $row->id; ?>]" class="<?php echo ($i % 2) ? 'even_row' : 'odd_row'; ?> <?php echo ($row->status != $statuses[0]) ? 'red_row' : ''; ?>">
					<td align="center"><input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" /></td>
					<td><?php echo $i; ?></td>
					<td class="td_show" data-url="<?php echo URL::site(ADMIN.$class_name.'/order/action/' . $row->id.'/'.$row->order.'/?xhr=1');?>"><?php echo str_repeat('&nbsp;', abs($row->sub_level * 5)); ?><strong><a href="<?php echo url::site(ADMIN.$class_name.'/view/' . $row->id); ?>"><?php echo Text::limit_words(strip_tags($row->title),6);?><?php echo !empty($row->subject) ? ' ('.$row->subject.')' : ''?></a></strong>
					<?php if (Request::$current->param('id1') !== 'sort') { ?>
						
						<?php //echo $row->order; ?>						
						<div class="show_order">
							<?php 
							if ($row->order >= 1 && $row->order != $set_order->set_order($row->category_id,'','MAX')) {
								echo '<a class="odr_down" title="Order Down" rel="'.$class_name.'" href="'.URL::site(ADMIN.$class_name).'/order/down/'.$row->id.'/'.$row->order.'/'.$row->category_id.'"></a>';
							}  
							if ($row->order <= $set_order->set_order($row->category_id,'','MAX') 
									&& $row->order != $set_order->set_order($row->category_id,'','MIN') 
										&& $row->order != $set_order->set_order($row->category_id,'','MAX') + 1){
								echo '<a class="odr_up" title="Order Up" rel="'.$class_name.'" href="'.URL::site(ADMIN.$class_name).'/order/up/'.$row->id.'/'.$row->order.'/'.$row->category_id.'"></a>';
							}
							?>
						</div>
					<?php } ?>	
					</td>
					<td align="center">
					<?php 
					$subject = Model::factory('SolutionCategory')->find_detail(array('id'=>$row->category_id));
					echo ($subject) ? Text::limit_words($subject[0]->title,10) :'-- No Category --'; 
					echo ($subject) ?' ('.$subject[0]->subject.')' : '';
					?>
					</td>
					<td align="center"><?php echo ucfirst($row->status); ?></td>
					<td align="center"><?php echo date(Lib::config('site.date_format'), $row->added); ?></td>
					<td align="center"><?php echo ($row->modified != 0) ? date(Lib::config('site.date_format'), $row->modified) : '-'; ?></td>
					<td width="11%">
                        <a class="view" title="View" href="<?php echo URL::site(ADMIN.$class_name.'/view/' . $row->id); ?>">View</a>
                        <a class="edit" title="Edit" href="<?php echo URL::site(ADMIN.$class_name.'/edit/' . $row->id); ?>">Edit</a>
                        <a class="delete" title="Delete" href="<?php echo URL::site(ADMIN.$class_name.'/delete/' . $row->id); ?>">Delete</a>
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
				<td id="corner"><img src="<?php echo IMG; ?>admin/list-corner.gif" alt="&nbsp;" /></td>
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
	</form>
	<div class="ls4"></div>
	<div>Total Records : <?php echo $total_record;?></div>
	<div class="ls5"></div>
	<?php endif; ?>
	<div class="ls5"></div>
</div>