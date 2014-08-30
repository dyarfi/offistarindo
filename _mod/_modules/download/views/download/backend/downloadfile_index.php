<?php defined('SYSPATH') OR die('No direct access allowed.'); 
?>
<?php //if ($category_id !='') : ?>
<!--h2> <?php //echo ucwords(str_replace('_', ' ', $class_name)); ?> Listings on &quot;<?php //echo HTML::chars($categories[$category_id]->name, TRUE); ?>&quot;</h2-->
<?php //else : ?>
<h2><?php echo $module_menu; ?></h2>
<?php //endif; ?>
<div class="form_wrapper">
    <div id="forms_holder">
        <form id="listing_search" action="<?php echo URL::site() .ADMIN. $class_name; ?>/index" method="post">
            <select name="field" id="field">
                <?php foreach ($search_keys as $row => $label) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="TEXT" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
            <input type="submit" name="find" id="find" class="btn_find" value="" />
        </form>
        <form id="listing_add" action="<?php echo URL::site() .ADMIN. $class_name; ?>/add" method="get">
            <input type="submit" class="btn_add new agent" value="" />
        </form>
    </div>	
<div class="ls5"></div>
<?php if (count($listings) == 0) :?>
<h3>There is not available data to display</h3>
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
				$i				= $page_index + 1;
				foreach ($listings as $row) :
			?>
				<tr id="row_<?php echo $row->id; ?>" class="<?php echo ($i % 2) ? 'even_row' : 'odd_row'; ?> <?php echo ($row->status != $statuses[0]) ? 'red_row' : ''; ?>">
					<td align="center"><input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" /></td>
					<td><?php echo $i; ?></td>
					<td class="td_show">
						<strong>
						<a href="<?php echo URL::site(ADMIN.$class_name.'/view/' . $row->id); ?>">
						<?php
						echo $row->title .' ';
						echo !empty($detail_data[$row->id]) ? ' ('. Text::limit_chars(strip_tags(@$detail_data[$row->id]->subject),22).') ' : '(no language detail)'; ?>
						</a>
						</strong>
						<?php if (in_array($row->file_type, $readable_mime)) : ?>
						<a href="#file_<?php echo $row->id; ?>" class="zoom">
							<img src="<?php echo IMG; ?>admin/<?php //echo $mime_icon[$row->file_type]; ?>" alt="<?php //echo $mime_icon[$row->file_type]; ?>" />
						</a>						
						<a class="download" title="Download <?php echo Text::bytes(@filesize(@$upload_url . $row->file_name));?>" href="<?php echo URL::site(ADMIN.$class_name.'/download/'.base64_encode($upload_url.$row->file_name));?>">
							<img src="<?php echo IMG; ?>admin/disk.png" alt="<?php echo $row->file_name; ?>" />
						</a>
						<div id="file_<?php echo $row->id; ?>" class="hide">
							<?php if (substr($row->file_type, 0, strlen('image/')) == 'image/') : ?>
							<img src="<?php echo URL::base().$upload_url.$row->file_name; ?>" alt="<?php echo URL::base().$upload_url.$row->file_name; ?>" />
							<?php elseif (substr($row->file_type, 0, strlen('audio/')) == 'audio/') : ?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="20" id="FLVPlayer">
								<param name="movie" value="<?php echo ASSETS; ?>flash/singlemp3player.swf" />
								<param name="quality" value="high" />
								<param name="wmode" value="opaque" />
								<param name="scale" value="noscale" />
								<param name="salign" value="lt" />
								<param name="FlashVars" value="file=<?php echo URL::base().$upload_url.$row->file_name; ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
								<param name="swfversion" value="8,0,0,0" />
								<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
								<param name="expressinstall" value="Scripts/expressInstall.swf" />
								<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
								<!--[if !IE]>-->
								<object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/singlemp3player.swf" width="320" height="20">
								<!--<![endif]-->
									<param name="quality" value="high" />
									<param name="wmode" value="opaque" />
									<param name="scale" value="noscale" />
									<param name="salign" value="lt" />
									<param name="FlashVars" value="file=<?php echo URL::base().$upload_url.$row->file_name; ?>&amp;backColor=c2c2c2&amp;frontColor=666666&amp;showDownload=false&amp;repeatPlay=false&songVolume=100" />
									<param name="swfversion" value="8,0,0,0" />
									<param name="expressinstall" value="Scripts/expressInstall.swf" />
									<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
									<div>
									<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
									<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
									</div>
								<!--[if !IE]>-->
								</object>
								<!--<![endif]-->
							</object>
							<?php else : ?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" id="FLVPlayer">
								<param name="movie" value="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" />
								<param name="quality" value="high" />
								<param name="wmode" value="opaque" />
								<param name="scale" value="noscale" />
								<param name="salign" value="lt" />
								<param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$row->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
								<param name="swfversion" value="8,0,0,0" />
								<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don�t want users to see the prompt. -->
								<param name="expressinstall" value="Scripts/expressInstall.swf" />
								<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
								<!--[if !IE]>-->
								<object type="application/x-shockwave-flash" data="<?php echo ASSETS; ?>flash/FLVPlayer_Progressive.swf" width="320" height="240">
								<!--<![endif]-->
									<param name="quality" value="high" />
									<param name="wmode" value="opaque" />
									<param name="scale" value="noscale" />
									<param name="salign" value="lt" />
									<param name="FlashVars" value="skinName=<?php echo ASSETS; ?>flash/Corona_Skin_2&amp;streamName=<?php echo URL::site(ADMIN.$class_name.'/download/'.$row->file_name); ?>&amp;autoPlay=false&amp;autoRewind=false" />
									<param name="swfversion" value="8,0,0,0" />
									<param name="expressinstall" value="Scripts/expressInstall.swf" />
									<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
									<div>
									<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
									<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
									</div>
								<!--[if !IE]>-->
								</object>
								<!--<![endif]-->
							</object>
							<?php endif; ?>
						</div>
						<?php else: 
						if (is_file($upload_url . $row->file_name) && file_exists($upload_url . $row->file_name)) {
						?>
						<a class="download" title="Download | <?php echo Text::bytes(@filesize(@$upload_url . $row->file_name));?>" href="<?php echo URL::site(ADMIN.$class_name.'/download/'.base64_encode($upload_url.$row->file_name));?>">
						<img src="<?php echo IMG; ?>admin/disk.png" alt="<?php echo $row->file_name; ?>" /></a>
						<?php 
						}
						endif; ?>												
						<div class="show_order">
							<?php 
							//echo $row->order;
							if ($row->order >= 1 && $row->order != $set_order->set_order($row->type_id,'','MAX')) {
								echo '<a class="odr_up" title="Order Up" rel="'.$class_name.'" href="'.URL::site(ADMIN.$class_name).'/order/up/'.$row->id.'/'.$row->order.'/'.$row->type_id.'"></a>';
							}  
							if ($row->order <= $set_order->set_order($row->type_id,'','MAX') 
									&& $row->order != $set_order->set_order($row->type_id,'','MIN') 
										&& $row->order != $set_order->set_order($row->type_id,'','MAX') + 1){
								echo '<a class="odr_down" title="Order Down" rel="'.$class_name.'" href="'.URL::site(ADMIN.$class_name).'/order/down/'.$row->id.'/'.$row->order.'/'.$row->type_id.'"></a>';
							}
							?>
						</div>
					</td>
					<td align="right">
						<?php echo ($row->type_id != 0 && isset($downloadtypes[$row->type_id])) ? TEXT::limit_chars(HTML::chars($downloadtypes[$row->type_id]->title, TRUE),18) : 'No Type'; ?>
					</td>				
					<td align="center">
						<?php echo $row->count; ?>
					</td>							
					<td align="center"><?php echo ucfirst($row->status); ?></td>
					<td align="center"><?php echo date(Lib::config('site.date_format'), $row->added); ?></td>
					<td align="center"><?php echo ($row->modified != 0) ? date(Lib::config('site.date_format'), $row->modified) : '-'; ?></td>
					<td>
						<a class="view" title="View" href="<?php echo URL::site(ADMIN.$class_name.'/view/' . $row->id); ?>">View</a>
						<a class="edit" title="Edit" href="<?php echo URL::site(ADMIN.$class_name.'/edit/' . $row->id); ?>">
						Edit</a>
						<a class="delete" title="Delete" href="<?php echo URL::site(ADMIN.$class_name.'/delete/' . $row->id); ?>">Delete</a>
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
