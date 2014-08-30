<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Author       : Daniel Simangunsong
 * Code Name    : Blugol
 * Copywrigth   : 2011
 * Module       : Event
 * Package      : View
**/ 
$arr_lang = i18n::get('system_language');
?>
<script>
    $(document).ready(function(){
        $('a.delete.email').click(function(){
            var pid = $(this).attr('pid');
            if (window.confirm('<?= i18n::get('warning_delete') ?>')){
                $.ajax({
                    type: 'GET',
                    url:server+'admin-cp/email/delete/'+pid,
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
        });
        
        $('select.status_email_listing').change(function(){
           var pid = $(this).attr('pid');
           var val = $(this).val();
           var hash= $(this).attr('hash');
           
           $.ajax({
                type: 'GET',
                url:server+'admin-cp/email/aupdate/'+pid+'/'+val,
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

<h2><?= Helper_Common::label(i18n::get('content_listing'),'Email');?></h2>
<div class="ls10"></div>
<div class="bar"></div>
<div class="ls10"></div>


<div><a class="new agent" href="<?= Kohana::$base_url;?>admin-cp/email/new"></a></div>
<div class="ls5"></div>

<?php if (!isset($var_listing)) : ?>
    <div class="warning3"><?= i18n::get('error_no_data'); ?></div>
<?php else: ?>
<table class="listing_data">
    <thead>
        <tr>
            <?php
                $direction = Request::instance()->param('id3');
                $direction = isset($direction) && $direction == 'desc' ? 'asc' : 'desc';
            ?>
            <th class="checkall"><input type="checkbox" id="ipt_checkall"/></th>
            <th>#</th>
            <th><a href="<?= BS_ADDR;?>admin-cp/email/manage/sort/name/<?=$direction;?>">Name</a></th>
            <th><a href="<?= BS_ADDR;?>admin-cp/email/manage/sort/section/<?=$direction;?>">Section</a></th>
            <th><a href="<?= BS_ADDR;?>admin-cp/email/manage/sort/email/<?=$direction;?>">Email</a></th>
            <th><a href="<?= BS_ADDR;?>admin-cp/email/manage/sort/status/<?=$direction;?>">Status</a></th>
            <th class="function">Function</th>
        </tr>
    </thead>
    
    <tbody>
    <?php
        $index = 1;
        $penomoran_start = empty($_GET['page']) ? 1 : ((int)($_GET['page'])-1)*$perpage+1;
        foreach ($var_listing as $item):
            $arr_status = i18n::get('status_value');
            $class      = $index % 2 == 0 ? 'genap' : 'ganjil';
            if ($item['status'] == 0): $class = 'merah'; endif;
            echo '<tr class="listing_'.$class.'">';
                echo '<td class="center">';
                    echo '<input type="checkbox" class="ipt_tocheck"  pid="'.$item['email_id'].'" hash="'.Helper_Common::encript($item['email_id']).'"/>';
                echo '</td>';
                echo '<td>'.$penomoran_start.'</td>';
                echo '<td class="bold">'.$item['name'].'</td>';
                echo '<td>'.$item['section'].'</td>';
                echo '<td>'.$item['email'].'</td>';
                echo '<td>';
                    echo '<select name="status" class="status_email_listing" pid="'.$item['email_id'].'" hash="'.Helper_Common::encript($item['email_id']).'">';
                        $arr_status = i18n::get('status_value');
                        foreach ($arr_status as $arr_key=>$arr_val):
                        echo '<option value="'.$arr_key.'" ';
                        if ($arr_key == $item['status']) echo 'selected="selected" ';
                        echo '>'.$arr_val.'</option>';
                        endforeach;
                    echo '</select>';
                echo '</td>';
                echo '<td>';
                    echo '<a class="view" href="'.Kohana::$base_url.'admin-cp/email/view/'.$item['email_id'].'"></a>';
                    echo '<a class="edit" href="'.Kohana::$base_url.'admin-cp/email/edit/'.$item['email_id'].'"></a>';
                    echo '<a class="delete email" pid="'.$item['email_id'].'"></a>';
                echo '</td>';      
            echo '</tr>';
            $index++;
            $penomoran_start++;
        endforeach;
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td id="corner"><img src="<?= IMG; ?>admin/list-corner.gif"/></td>
            <td colspan="6">
                <div id="selection_action">
                    <?= i18n::get('changed_status');?> : 
                    <?php
                    echo '<select id="status_listing_one_click" name="status_listing_one_click" url="email/aupdate" lastpid="'.$item['email_id'].'">';
                        echo '<option value="select"></option>';
                        $arr_status = i18n::get('status_value');
                        foreach ($arr_status as $arr_key=>$arr_val):
                        echo '<option value="'.$arr_key.'">'.$arr_val.'</option>';
                        endforeach;
                    echo '</select>';
                    ?>
                </div>
                <div id="selection_page">
                    <?= isset($var_paging) ? $var_paging : ''; ?>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="ls4"></div>
<div>Total Records : <?= $total_record;?></div>

<div class="ls10"></div>
<?= isset($var_paging) ? $var_paging.'<div class="ls10"></div>' : ''; ?>
<?php endif; ?>
<div class="ls10"></div>
<div class="bar"></div>