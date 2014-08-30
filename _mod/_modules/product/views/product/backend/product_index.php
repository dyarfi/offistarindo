<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php if ($category_id !='') : ?>
<h2><?php echo $module_menu; ?> on &quot;<?php echo HTML::chars($categories[$category_id]->title, TRUE); ?>&quot;</h2>
<?php else : ?>
<h2><?php echo $module_menu; ?></h2>
<?php endif; ?>
<div class="form_wrapper">
    <div id="forms_holder">
        <form id="listing_search" action="<?php echo URL::site(ADMIN.$module_name.'/index'); ?>" method="post">
            <select name="field" id="field">
                <?php foreach ($search_keys as $row => $label) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
            <input type="submit" name="find" id="find" class="btn_find" value="" />
        </form>
        <form id="listing_add" action="<?php echo URL::site(ADMIN.$module_name.'/add'); ?>" method="get">
            <input type="submit" class="btn_add" value="" />
        </form>
    </div>
    <?php if (count($listings) == 0) :?>
    <h3>There is not available data to display</h3>
    <?php else : ?>
	<?php		
	echo Form::open(ADMIN.$module_name.'/change',array('method'=>'post','class'=>'form_details')); 
	echo Form::hidden('page',$page_index);
	echo Form::hidden('order',$order);
	echo Form::hidden('sort',$sort);
	?> 
        <table class="listing_data">
            <thead>
                <tr>
                    <th><input type="checkbox" name="check_all" id="check_all" /></th>
                    <th><strong>#</strong></th>
                    <?php 
					$category_sorts = $category_id ? $category_id . '/' : ''; 
					foreach ($table_headers as $key => $value) : ?>
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
						<a href="<?php echo URL::site(ADMIN.$module_name.'/index/'.$category_sorts.'sort/'.$key.'/order/'.$order.$page_url); ?>" id="active_col">
							<?php echo $value . $order_sign; ?>
						</a>
					</th>
                    <?php else : ?>
                    <th>
						<a href="<?php echo URL::site(ADMIN.$module_name.'/index/'.$category_sorts.'sort/'.$key.'/order/asc/'.$page_url); ?>">
							<?php echo $value; ?>
						</a>
					</th>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = $page_index + 1;
                    foreach ($listings as $row) :
                ?>
                <tr id="row_<?php echo $row->id; ?>" class="<?php echo ($i % 2) ? 'even_row' : 'odd_row'; ?> <?php 
					$class = '';
					if ($row->status == $statuses[1])
						$class = 'red_row';
					elseif ($row->status == $statuses[1])
						$class = 'blue_row';
					echo $class;
					?>">
                        <td align="center"><input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" /></td>
                        <td><?php echo $i; ?></td>
                        <td class="td_show"><strong><a href="<?php echo URL::site(ADMIN.$module_name.'/view/' . $row->id); ?>"><?php echo Text::limit_words(HTML::chars($row->title, TRUE),4,'').' ('.Text::limit_chars(@$detail_data[$row->id]->subject,20,'').')'; ?></a></strong>
							<?php if (Request::$current->param('id1') !== 'sort') { ?>
							<div class="show_order">
								<?php 
								//echo $row->order;
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
						<td align="center" width="1%"><?php echo Form::checkbox('top_brand', 1, (!empty($row->top_brand) ? TRUE : FALSE), array('class'=>'top_brand','data-url' => URL::site(ADMIN.$class_name.'/top_brand'),'data-id' => $row->id)); ?></td>
						<td align="center" width="1%"><?php echo $row->order; ?></td>
                        <td align="left">
						<?php if (!empty($categories[$row->category_id]) && $categories[$row->category_id]->status !='publish'): ?>
							<?php 
								echo isset($categories[$row->category_id]) ? 
								TEXT::limit_words(strip_tags($categories[$row->category_id]->subject, TRUE),2,'') . ' ('.$categories[$row->category_id]->status.')' : 
								'No Parent'; ?>
						<?php else: ?>
							<?php 
								if (isset($categories[$row->category_id])) {
									echo !empty($categories[$row->category_id]->title) ? TEXT::limit_chars($categories[$row->category_id]->title,18,'..') : '';
									echo ' ('.TEXT::limit_words(strip_tags($categories[$row->category_id]->subject, TRUE),2,'') .')'; 
				
								} else {
									echo 'No Parent';	
								}								
								?>
						<?php endif;?>							
						</td>
						<td align="center"><?php echo ucfirst($row->status); ?></td>
                        <td align="center"><?php echo date(Lib::config('admin.date_format'), $row->added); ?></td>
                        <td align="center"><?php echo ($row->modified != 0) ? date(Lib::config('admin.date_format'), $row->modified) : '-'; ?></td>
                        <td width="11%">
                        <a class="view" title="View" href="<?php echo URL::site(ADMIN.$module_name.'/view/' . $row->id); ?>">View</a>
                        <a class="edit" title="Edit" href="<?php echo URL::site(ADMIN.$module_name.'/edit/' . $row->id); ?>">Edit</a>
                        <a class="delete" title="Delete" href="<?php echo URL::site(ADMIN.$module_name.'/delete/' . $row->id); ?>">Delete</a>
                        </td>
                    </tr>
                <?php
                        $i++;
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
    <?php echo Form::close();?>
	<div class="ls4"></div>
	<div>Total Records : <?php echo $total_record;?></div>
	<div class="ls5"></div>
	<?php endif; ?>
</div>