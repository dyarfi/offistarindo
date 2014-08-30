<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script>
    $(document).ready(function(){
        $('a.delete.setting').click(function(){
			/*
            var pid = $(this).attr('pid');
            if (window.confirm('<?= i18n::get('warning_delete') ?>')){
                $.ajax({
                    type: 'GET',
                    url:server+'admin-cp/setting/delete/'+pid,
                    data: 'ajax=true',
                    datatype: "html",
                    success: function(msg){
                        location.reload();
                    },
                    error: function (request,setting){
                        alert(request+ ' ' + setting);
                    }
                });
            }
			*/
        });
        $('select.status_setting_listing').change(function(){
           var pid = $(this).attr('pid');
           var val = $(this).val();
           var hash= $(this).attr('hash');
           $.ajax({
                type: 'GET',
                url:base_ADM +'setting/aupdate/'+pid+'/'+val,
                data: 'ajax=true&field=status&hash='+hash,
                datatype: "html",
                success: function(msg){
                    location.reload();
                },
                error: function (request,setting){
                    alert(request+ ' ' + setting);
                }
            });
        });
    });
</script>
<h2><?php echo $module_menu; ?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
    <div id="forms_holder">
        <form id="listing_search" action="<?php echo URL::site() .ADMIN. $module_name; ?>/index" method="post">
            <select name="field" id="field">
                <?php foreach ($search_keys as $row => $label) : ?>
                <option value="<?php echo $row; ?>" <?php echo ($row == $field) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
            <input type="submit" name="find" id="find" class="btn_find" value="" />
        </form>
		<?php
		if (Session::instance()->get('level_id') == 1):?>
        <form id="listing_add" action="<?php echo URL::site() .ADMIN. $module_name; ?>/add" method="get">
            <input type="submit" class="btn_add new agent" value="" />
        </form>
		<?php
		endif;
		?>
    </div>	
<div class="ls10"></div>
<?php if (!isset($listings) || empty($listings)) : ?>
	<div class="ls15 clear"></div>
		<h3 class="warning3"><?php echo i18n::get('error_no_data'); ?></h3>
	<div class="ls15"></div>
<?php else: ?>
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
			<th><a href="<?php echo URL::site(ADMIN.$module_name.'/index/sort/'.$key.'/order/'.$order.$page_url); ?>" id="active_col"><?php echo $value . $order_sign; ?></a></th>
			<?php else : ?>
			<th><a href="<?php echo URL::site(ADMIN.$module_name.'/index/sort/'.$key.'/order/asc/'.$page_url); ?>"><?php echo $value; ?></a></th>
			<?php endif; ?>
			<?php endforeach; ?>
			<th>Functions</th>
		</tr>
	</thead>
    <tbody>
    <?php
		$i = $pagination->current_first_item;
        $index = 1;
        foreach ($listings as $row):
            $arr_status = i18n::get('status_value');
            $class      = $index % 2 == 0 ? 'even' : 'odd';
            if ($row->status != 'publish'): $class = 'red'; endif;
			?>
            <tr id="row_<?php echo $row->id; ?>" class="listing_<?php echo $class;?>">
                <td class="center">                   
				   <input type="checkbox" name="check[]" id="check_<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" />
				</td>
                <td class="center"><?php echo $i; ?></td>
                <td class=""><?php echo $row->alias; ?></td>
				<td class=""><?php echo Text::limit_chars(@strip_tags($row->value,'<em>'),60,'...'); ?></td>
				<td class=""><?php echo $row->parameter; ?></td>
				<td class=""><?php echo ucfirst($row->status); ?></td>
                <td><?php echo date("d F Y",@$row->added);?></td>
				<td><?php echo date("d F Y",@$row->modified);?></td>               
                <td>
                    <a class="view" title="View" href="<?php echo URL::site(ADMIN.$module_name);?>/view/<?php echo @$row->id;?>">View</a>
                    <a class="edit" title="Edit" href="<?php echo URL::site(ADMIN.$module_name);?>/edit/<?php echo @$row->id;?>">Edit</a>
                    <?php if (empty($row->is_system)): ?>
					<a class="delete setting" pid="<?php echo @$row->id;?>" href="<?php echo URL::site(ADMIN.$module_name.'/delete/' . $row->id); ?>">Delete</a>
					<?php endif; ?>
				</td>
            </tr>
			<?php
            $index++;
            $i++;
        endforeach;
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td id="corner"><img src="<?= IMG; ?>admin/list-corner.gif"/></td>
            <td colspan="<?php echo (count($table_headers) + 2); ?>">
                <div id="selection_action">
                    <!--?= i18n::get('changed_status');?> : -->
                    <?php
                    echo '<!--select id="status_listing_one_click" name="status_listing_one_click" url="setting/aupdate" lastpid="'.@$row->id.'">';
                        echo '<option value="select"></option>';
                        $arr_status = i18n::get('status_value');
                        foreach ($arr_status as $arr_key=>$arr_val):
                        echo '<option value="'.$arr_key.'">'.$arr_val.'</option>';
                        endforeach;
                    echo '</select-->';
                    ?>
					<?php /*
					<?php echo i18n::get('changed_status'); ?> : 
					<select name="select_action" id="select_action">
						<option value="">&nbsp;</option>
						<?php foreach ($statuses as $row) : ?>
						<option value="<?php echo $row; ?>"><?php echo ucfirst($row); ?></option>
						<?php endforeach; ?>
					</select>
					 * 
					 */
					?>
                </div>
                <div id="selection_page">
                    <?php echo $pagination->render(); ?>
                </div>
				<div id="table_pagination"></div>
                <div class="clear"></div>
            </td>
        </tr>
    </tfoot>
</table>
<?php 
echo Form::close();
?>
<div class="ls4"></div>
<div>Total Records : <?php echo $total_record;?></div>
<div class="ls20"></div>
<h2>
	<?php //echo Helper_Common::label(i18n::get('content_listing'),'Maintenance Setting');?>
	<?php echo __('Maintenance Mode Setting');?>
</h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>
<div> 
	<?php echo Form::open(ADMIN.$module_name.'/index/maintenance_mode',
			array(
				'method'=>'post',
				'class'=>'form_details',
				'name'=>'maintenance_form',
				'id'=>'maintenance_form')
			); ?>
	<?php echo Form::label('maintenance_mode', 'Maintenance Mode'); ?>
	<br/>
	<?php 			 
	$maintenance = $configuration->value;
	$modes = Lib::config('setting.maintenance_mode');
	foreach ($modes as $mode => $value) {
		echo Form::radio('maintenance_mode',$mode,($maintenance == $mode) ? TRUE : FALSE,array('class'=>"maintenance_mode"));
		echo '&nbsp;&nbsp;';
		echo $value;
		echo '&nbsp;&nbsp;';
	}
	echo '<div class="ls15"></div>'; 
	echo Form::submit('save','', array('class'=>'btn_save')); 
	?>
	<?php echo Form::close(); ?>
</div>
<div class="ls5"></div>
<?php endif; ?>
<div class="ls5"></div>
