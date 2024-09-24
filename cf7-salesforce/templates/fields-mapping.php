<?php
if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }                                 
 ?>
 <div  class="vx_div">
   <div class="vx_head">
<div class="crm_head_div"> <?php esc_html_e('5. Map Form Fields to Salesforce Fields.', 'cf7-salesforce'); ?></div>
<div class="crm_btn_div" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"><i class="fa crm_toggle_btn vx_action_btn fa-minus"></i></div>
<div class="crm_clear"></div> 
  </div>
  <div class="vx_group">
  <div class="vx_col1">
  <label>
  <?php esc_html_e("Fields Mapping", 'cf7-salesforce'); ?>
  <?php $this->tooltip("vx_map_fields") ?>
  </label>
  </div>
  <div class="vx_col2">
  <div id="vx_fields_div">
  <?php 
   $req_span=" <span class='vx_red vx_required'>(".esc_html__('Required','cf7-salesforce').")</span>";
 $req_span2=" <span class='vx_red vx_required vx_req_parent'>(".esc_html__('Required','cf7-salesforce').")</span>";
  foreach($map_fields as $k=>$v){
        if(isset($v['name_c'])){
  $v['name']=$v['name_c'];      
  $v['label']=__('Custom Field','cf7-salesforce');      
  } 
  if( in_array($v['name'] , array("OwnerId","AccountId","ContractId") )){
  //  continue;
}
if($module == "Order" && in_array($v['name'] , array("Status" ))){
    continue;
} 
  $sel_val=isset($map[$k]['field']) ? $map[$k]['field'] : ""; 
  $val_type=isset($map[$k]['type']) && !empty($map[$k]['type']) ? $map[$k]['type'] : "field"; 

    $display="none"; $btn_icon="fa-plus";
  if(isset($map[$k][$val_type]) && !empty($map[$k][$val_type])){
    $display="block"; 
    $btn_icon="fa-minus";   
  }
  $required=isset($v['req']) && $v['req'] == "true" ? true : false;
   $req_html=$required ? $req_span : ""; $k=esc_attr($k);
  ?>
<div class="crm_panel crm_panel_100">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text crm_text_label">  <?php echo esc_html($v['label']);?></span> <?php echo wp_kses_post($req_html) ?></div>
<div class="crm_btn_div">
<?php
 if(! $required){   
?>
<i class="vx_remove_btn vx_remove_btn vx_action_btn fa fa-trash-o" title="<?php esc_html_e('Delete','cf7-salesforce'); ?>"></i>
<?php } ?>
<i class="fa crm_toggle_btn vx_action_btn vx_btn_inner <?php echo esc_attr($btn_icon) ?>" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"></i>
</div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: <?php echo esc_attr($display) ?>;">
  <?php if(!isset($v['name_c'])){ ?>

  <div class="crm-panel-description">
  <span class="crm-desc-name-div"><?php echo esc_html__('Name:','cf7-salesforce')." ";?><span class="crm-desc-name"><?php echo esc_html($v['name']); ?></span> </span>
  <?php if($this->post('type',$v) !=""){ ?>
    <span class="crm-desc-type-div">, <?php echo esc_html__('Type:','cf7-salesforce')." ";?><span class="crm-desc-type"><?php echo esc_html($v['type']); ?></span> </span>
<?php
   }
  if($this->post('maxlength',$v) !=""){ 
   ?>
   <span class="crm-desc-len-div">, <?php echo esc_html__('Max Length:','cf7-salesforce')." ";?><span class="crm-desc-len"><?php echo esc_html($v['maxlength']); ?></span> </span>
  <?php 
  }
   if($this->post('eg',$v) !=""){ 
   ?>
   <span class="crm-eg-div">, <?php echo esc_html__('e.g:','cf7-salesforce')." ";?><span class="crm-eg"><?php echo esc_html($v['eg']); ?></span> </span>
  <?php 
  }
  ?>
   </div> 
  <?php
  }
  ?>

<div class="vx_margin">

<?php
    if(isset($v['name_c'])){
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><?php esc_html_e('Field API Name','cf7-salesforce') ?></div>
<div class="entry_col2">
<input type="text" name="meta[map][<?php echo esc_attr($k) ?>][name_c]" value="<?php echo esc_attr($v['name_c']) ?>" placeholder="<?php esc_html_e('Field API Name','cf7-salesforce') ?>" class="vx_input_100">
<div class="howto"><?php echo esc_html__('In Salesforce, go to setup -> customize -> leads -> fields and copy API name of a field','cf7-salesforce')?></div>
</div>
<div class="crm_clear"></div>
</div> 
<?php             
    }
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><label  for="vx_type_<?php echo esc_attr($k) ?>"><?php esc_html_e('Field Type','cf7-salesforce') ?></label></div>
<div class="entry_col2">
<select name='meta[map][<?php echo esc_attr($k) ?>][type]'  id="vx_type_<?php echo esc_attr($k) ?>" class='vxc_field_type vx_input_100'>
<?php
  foreach($sel_fields as $f_key=>$f_val){
  $select="";
  if($this->post2($k,'type',$map) == $f_key)
  $select='selected="selected"';
  ?>
  <option value="<?php echo esc_attr($f_key) ?>" <?php echo $select ?>><?php echo esc_attr($f_val); ?></option>    
  <?php } ?> 
</select>
</div>
<div class="crm_clear"></div>
</div>  
<div class="entry_row entry_row2">
<div class="entry_col1 vx_label">
<label for="vx_field_<?php echo esc_attr($k) ?>" style="<?php if($this->post2($k,'type',$map) != ''){echo 'display:none';} ?>" class="vxc_fields vxc_field_"><?php esc_html_e('Select Field','cf7-salesforce') ?></label>

<label for="vx_value_<?php echo esc_attr($k) ?>" style="<?php if($this->post2($k,'type',$map) != 'value'){echo 'display:none';} ?>" class="vxc_fields vxc_field_value"> <?php esc_html_e('Custom Value','cf7-salesforce') ?></label>
</div>
<div class="entry_col2">
<div class="vxc_fields vxc_field_value" style="<?php if($this->post2($k,'type',$map) != 'value'){echo 'display:none';} ?>">

<textarea name='meta[map][<?php echo esc_attr($k)?>][value]'  id="vx_value_<?php echo esc_attr($k) ?>" placeholder='<?php esc_html_e("Custom Value",'cf7-salesforce')?>' class='vx_input_100 vxc_field_input'><?php if(!empty($map[$k]['value'])){ echo htmlentities($map[$k]['value']); } ?></textarea>

<div class="howto"><?php echo sprintf(esc_html__('You can add a form field %s in custom value from following form fields','cf7-salesforce'),'<code>{field_id}</code>')?></div>
</div>


<select name="meta[map][<?php echo esc_attr($k) ?>][field]"  id="vx_field_<?php echo esc_attr($k) ?>" class="vxc_field_option vx_input_100">
<?php echo $this->form_fields_options($form_id,$sel_val,$this->account,$feed['id']); ?>
</select>


</div>
<div class="crm_clear"></div>
</div>  

  </div></div>
  <div class="clear"></div>
  </div>
<?php
  }
  ?> 
 
 <div id="vx_field_temp" style="display:none"> 
  <div class="crm_panel crm_panel_100 vx_fields">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text crm_text_label">  <?php esc_html_e('Custom Field', 'cf7-salesforce');?></span> </div>
<div class="crm_btn_div">
<i class="vx_remove_btn vx_action_btn fa fa-trash-o" title="<?php esc_html_e('Delete','cf7-salesforce'); ?>"></i>
<i class="fa crm_toggle_btn vx_action_btn vx_btn_inner fa-minus" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"></i>
</div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: block;">

<?php
    if($api_type  != 'web'){
?>

  <div class="crm-panel-description">
  <span class="crm-desc-name-div"><?php echo esc_html__('Name:','cf7-salesforce')." ";?><span class="crm-desc-name"></span> </span>
  <span class="crm-desc-type-div">, <?php echo esc_html__('Type:','cf7-salesforce')." ";?><span class="crm-desc-type"></span> </span>
  <span class="crm-desc-len-div">, <?php echo esc_html__('Max Length:','cf7-salesforce')." ";?><span class="crm-desc-len"></span> </span>
 <span class="crm-eg-div">, <?php echo esc_html__('e.g:','cf7-salesforce')." ";?><span class="crm-eg"></span> </span>
   </div> 

<?php
    }
?>
<div class="vx_margin">

<?php
    if($api_type  == 'web'){
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><?php esc_html_e('Field API Name','cf7-salesforce') ?></div>
<div class="entry_col2">
<input type="text" name="name_c" placeholder="<?php esc_html_e('Field API Name','cf7-salesforce') ?>" class="vx_input_100">
<div class="howto"><?php echo esc_html__('In Salesforce, go to setup -> customize -> leads -> fields and copy API name of a field','cf7-salesforce')?></div>
</div>
<div class="crm_clear"></div>
</div> 
<?php
    }
?>
<div class="entry_row">
<div class="entry_col1 vx_label"><label  for="vx_type"><?php esc_html_e('Field Type','cf7-salesforce') ?></label></div>
<div class="entry_col2">
<select name='type' class='vxc_field_type vx_input_100'>
<?php
  foreach($sel_fields as $f_key=>$f_val){
  ?>
  <option value="<?php echo esc_attr($f_key) ?>"><?php echo esc_html($f_val)?></option>    
  <?php } ?> 
</select>
</div>
<div class="crm_clear"></div>
</div>  

  

<div class="entry_row entry_row2">
<div class="entry_col1 vx_label">
<label for="vx_field" class="vxc_fields vxc_field_"><?php esc_html_e('Select Field','cf7-salesforce') ?></label>

<label for="vx_value" style="display:none" class="vxc_fields vxc_field_value"> 
<?php esc_html_e('Custom Value','cf7-salesforce') ?></label>
</div>
<div class="entry_col2">
<div class="vxc_fields vxc_field_value" style="display:none">
<textarea name='value'  placeholder='<?php esc_html_e("Custom Value",'cf7-salesforce')?>' class="vx_input_100 vxc_field_input"></textarea>
<div class="howto"><?php echo sprintf(esc_html__('You can add a form field %s in custom value from following form fields','cf7-salesforce'),'<code>{field_id}</code>')?></div>
</div>

<select name="field"  id="vx_field" class="vxc_field_option vx_input_100">
<?php echo  $this->form_fields_options($form_id,'',$this->account,$id); ?>
</select>


</div>
<div class="crm_clear"></div>
</div> 

  </div></div>
  <div class="clear"></div>
  </div>
   </div>
   <!--end field box template--->
     <?php
  if($api_type =="web"){
  if(vxcf_sales::$is_pr){
   ?>
  <div class="vx_fields_footer">
  <div class="vx_row">
  <div class="vx_col1"> &nbsp;</div><div class="vx_col2">
  <button type="button" class="button button-default" id="xv_add_custom_field"><i class=" fa fa-plus-circle" ></i> <?php esc_html_e('Add Custom Field','cf7-salesforce')?></button></div>
  <div class="clear"></div></div>
   </div>
 <?php } }else{ ?> 
   <div class="crm_panel crm_panel_100">
<div class="crm_panel_head2">
<div class="crm_head_div"><span class="crm_head_text ">  <?php esc_html_e("Add New Field", 'cf7-salesforce');?></span> </div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn vx_btn_inner fa-minus" style="display: none;" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce'); ?>"></i></div>
<div class="crm_clear"></div> </div>
<div class="more_options crm_panel_content" style="display: block;">

<div class="vx_margin">
<div style="display: table">
  <div style="display: table-cell; width: 85%; padding-right: 14px;">
<select id="vx_add_fields_select" class="vx_input_100" autocomplete="off">
<option value=""></option>
<?php
$json_fields=array(); 
 foreach($fields as $k=>$v){
     $v['type']=ucfirst($v['type']);
     $ops=array();
     if(!empty($v['options'])){
    foreach($v['options'] as $op){
        $ops[$op['value']]=$op['label'];
        
    }     
   $v['options']=$ops;  

     }
     $json_fields[$k]=$v;
   $disable='';
   if(isset($map_fields[$k])){
    $disable='disabled="disabled"';   
   } 
echo '<option value="'.esc_html($k).'" '.$disable.' >'.esc_html($v['label']).'</option>';   
} ?>
</select>
  </div><div style="display: table-cell;">
 <button type="button" class="button button-default" style="vertical-align: middle;" id="xv_add_custom_field"><i class="fa fa-plus-circle" ></i> <?php esc_html_e('Add Field','cf7-salesforce')?></button>
  
  </div></div>
 

  </div></div>
  <div class="clear"></div>
  </div>
  <!--add new field box template--->
  <script type="text/javascript">
var crm_fields=<?php echo json_encode($json_fields); ?>;

</script> 
  <?php
 }
 ?>
  </div>
  </div>
  <div class="clear"></div>
  </div>
  </div>
  <div class="vx_div">
   <div class="vx_head">
<div class="crm_head_div"> <?php esc_html_e('6. When to Send Entry to Salesforce.', 'cf7-salesforce'); ?></div>
<div class="crm_btn_div" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"><i class="fa crm_toggle_btn vx_action_btn fa-minus"></i></div>
<div class="crm_clear"></div> 
  </div>
 
  <div class="vx_group">
  <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_manual_export">
  <?php esc_html_e('Disable Automatic Export', 'cf7-salesforce'); ?>
  <?php $this->tooltip("vx_manual_export") ?>
  </label>
  </div>
  <div class="vx_col2">
  <fieldset>
  <legend class="screen-reader-text"><span>
  <?php esc_html_e('Disable Automatic Export', 'cf7-salesforce'); ?>
  </span></legend>
  <label for="crm_manual_export">
  <input name="meta[manual_export]" id="crm_manual_export" type="checkbox" value="1" <?php echo isset($meta['manual_export'] ) ? 'checked="checked"' : ''; ?>>
  <?php esc_html_e( 'Manually send the entries to Salesforce.', 'cf7-salesforce'); ?> </label>
  </fieldset>
  </div>
  <div style="clear: both;"></div>
  </div>
  <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_optin">
  <?php esc_html_e("Opt-In Condition", 'cf7-salesforce'); ?>
  <?php $this->tooltip("vx_optin_condition") ?>
  </label>
  </div>
  <div class="vx_col2">
  <div>
  <input type="checkbox" style="margin-top: 0px;" id="crm_optin" class="crm_toggle_check" name="meta[optin_enabled]" value="1" <?php echo !empty($meta["optin_enabled"]) ? "checked='checked'" : ""?>/>
  <label for="crm_optin">
  <?php esc_html_e("Enable", 'cf7-salesforce'); ?>
  </label>
  </div>
  <div style="clear: both;"></div>
  <div id="crm_optin_div"  style="margin-top: 16px; <?php echo empty($meta["optin_enabled"]) ? "display:none" : ""?>">
  <div>
  <?php
  $sno=0;
  foreach($filters as $filter_k=>$filter_v){ $filter_k=esc_attr($filter_k);
  $sno++;
                              ?>
  <div class="vx_filter_or" data-id="<?php echo esc_attr($filter_k) ?>">
  <?php if($sno>1){ ?>
  <div class="vx_filter_label">
  <?php esc_html_e('OR','cf7-salesforce') ?>
  </div>
  <?php } ?>
  <div class="vx_filter_div">
  <?php
  if(is_array($filter_v)){
  $sno_i=0;
  foreach($filter_v as $s_k=>$s_v){   $s_k=esc_attr($s_k);
  $sno_i++;
  
  ?>
  <div class="vx_filter_and">
  <?php if($sno_i>1){ ?>
  <div class="vx_filter_label">
  <?php esc_html_e('AND','cf7-salesforce') ?>
  </div>
  <?php } ?>
  <div class="vx_filter_field vx_filter_field1">
  <select id="crm_optin_field" name="meta[filters][<?php echo esc_attr($filter_k) ?>][<?php echo esc_attr($s_k) ?>][field]">
  <?php 
  echo $this->form_fields_options($form_id,$this->post('field',$s_v),$this->account,$id);
                ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field2">
  <select name="meta[filters][<?php echo esc_attr($filter_k) ?>][<?php echo esc_attr($s_k) ?>][op]" >
  <?php
                 foreach($vx_op as $k=>$v){
  $sel="";
  if($this->post('op',$s_v) == $k)
  $sel='selected="selected"';
                   echo "<option value='".esc_attr($k)."' $sel >".esc_html($v)."</option>";
               } 
              ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field3">
  <input type="text" class="vxc_filter_text" placeholder="<?php esc_html_e('Value','cf7-salesforce') ?>" value="<?php echo $this->post('value',$s_v) ?>" name="meta[filters][<?php echo esc_attr($filter_k) ?>][<?php echo esc_attr($s_k) ?>][value]">
  </div>
  <?php if( $sno_i>1){ ?>
  <div class="vx_filter_field vx_filter_field4"><i class="vx_icons-h vx_trash_and vxc_tips fa fa-trash-o" data-tip="Delete"></i></div>
  <?php } ?>
  <div style="clear: both;"></div>
  </div>
  <?php
  } }
                     ?>
  <div class="vx_btn_div">
  <button class="button button-default button-small vx_add_and" title="<?php esc_html_e('Add AND Filter','cf7-salesforce'); ?>"><i class="vx_icons-s vx_trash_and fa fa-hand-o-right"></i>
  <?php esc_html_e('Add AND Filter','cf7-salesforce') ?>
  </button>
  <?php if($sno>1){ ?>
  <a href="#" class="vx_trash_or">
  <?php esc_html_e('Trash','cf7-salesforce') ?>
  </a>
  <?php } ?>
  </div>
  </div>
  </div>
  <?php
                          }
                      ?>
  <div class="vx_btn_div">
  <button class="button button-default  vx_add_or" title="<?php esc_html_e('Add OR Filter','cf7-salesforce'); ?>"><i class="vx_icons vx_trash_and fa fa-check"></i>
  <?php esc_html_e('Add OR Filter','cf7-salesforce') ?>
  </button>
  </div>
  </div>
  <!--------- template------------>
  <div style="display: none;" id="vx_filter_temp">
  <div class="vx_filter_or">
  <div class="vx_filter_label">
  <?php esc_html_e('OR','cf7-salesforce') ?>
  </div>
  <div class="vx_filter_div">
  <div class="vx_filter_and">
  <div class="vx_filter_label vx_filter_label_and">
  <?php esc_html_e('AND','cf7-salesforce') ?>
  </div>
  <div class="vx_filter_field vx_filter_field1">
  <select id="crm_optin_field" name="field">
  <?php 
  echo $this->form_fields_options($form_id,'',$this->account,$id);
                ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field2">
  <select name="op" >
  <?php
                 foreach($vx_op as $k=>$v){
  
                   echo "<option value='".esc_attr($k)."' >".esc_html($v)."</option>";
               } 
              ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field3">
  <input type="text" class="vxc_filter_text" placeholder="<?php esc_html_e('Value','cf7-salesforce') ?>" name="value">
  </div>
  <div class="vx_filter_field vx_filter_field4"><i class="vx_icons vx_trash_and vxc_tips fa fa-trash-o"></i></div>
  <div style="clear: both;"></div>
  </div>
  <div class="vx_btn_div">
  <button class="button button-default button-small vx_add_and" title="<?php esc_html_e('Add AND Filter','cf7-salesforce'); ?>"><i class="vx_icons vx_trash_and  fa fa-hand-o-right"></i>
  <?php esc_html_e('Add AND Filter','cf7-salesforce') ?>
  </button>
  <a href="#" class="vx_trash_or">
  <?php esc_html_e('Trash','cf7-salesforce') ?>
  </a> </div>
  </div>
  </div>
  </div>
  <!--------- template end ------------>
  </div>
  </div>
  <div style="clear: both;"></div>
  </div>
<?php
   if($api_type != "web"){ 
         $settings=get_option($this->type.'_settings',array());
         if(!empty($settings['notes'])){
?>

  <div class="vx_row">
  <div class="vx_col1">
  <label for="vx_notes"><?php esc_html_e('Entry Notes ', 'cf7-salesforce');  $this->tooltip('vx_entry_notes');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="vx_notes" class="crm_toggle_check" name="meta[entry_notes]" value="1" <?php echo !empty($meta['entry_notes']) ? 'checked="checked"' : ''?> autocomplete="off"/>
    <label for="vx_notes"><?php esc_html_e('Add / delete notes to Salesforce when added / deleted in Contact Form Entries Plugin', 'cf7-salesforce'); ?></label>
  
  </div>
  <div class="clear"></div>
  </div>
<?php
         }
    }
?>

  </div> 
  </div>
  <?php

   $panel_count=6;
  if($api_type != "web"){ 
      $panel_count++;
         $key_fields=array();
      if(is_array($fields)){
          foreach($fields as $k=>$v){
         $key_fields[$k]=$v;
          if($k == 'FirstName' && isset($fields['LastName'])){
              $key_fields['FirstName+LastName']=array('label'=>'First Name & Last Name');
                 if(isset($fields['Email'])){
              $key_fields['FirstName+LastName+Email']=array('label'=>'First Name & Last Name & Email');
          }
          }    
          }
      }
  ?>     
  <div class="vx_div "> 
  <div class="vx_head ">
<div class="crm_head_div"> <?php  echo sprintf(esc_html__('%s. Choose Primary Key.',  'cf7-salesforce' ),$panel_count); ?></div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn fa-minus" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"></i></div>
<div class="crm_clear"></div> 
  </div>                    
    <div class="vx_group">
  <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_primary_field"><?php esc_html_e('Select Primary Key','cf7-salesforce') ?></label>
  </div><div class="vx_col2">
  <select id="crm_primary_field" name="meta[primary_key]" class="vx_sel vx_input_100" autocomplete="off">
  <?php echo $this->crm_select($key_fields,$this->post('primary_key',$meta)); ?>
  </select> 
  <div class="description" style="float: none; width: 90%"><?php esc_html_e('If you want to update a pre-existing object, select what should be used as a unique identifier ("Primary Key"). For example, this may be an email address, lead ID, or address. When a new entry comes in with the same "Primary Key" you select, a new object will not be created, instead the pre-existing object will be updated.', 'cf7-salesforce'); ?></div>
  </div>
  <div class="clear"></div>
  </div>
      <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_primary_custom"><?php esc_html_e('Custom Primary Key','cf7-salesforce') ?></label>
  </div><div class="vx_col2">
  <input type="text" id="crm_primary_custom" name="meta[primary_key_custom]" class="vx_sel vx_input_100" autocomplete="off" value="<?php echo $this->post('primary_key_custom',$meta) ?>">
  <div class="description" style="float: none; width: 90%"><?php esc_html_e('You can Override Parimary key with your custom key, you set multiple fields as Primary key e.g Title+email+custom_text', 'cf7-salesforce'); ?></div>
  </div>
  <div class="clear"></div>
  </div>
  
     <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_primary_field2"><?php esc_html_e('Second Primary Key','cf7-salesforce') ?></label>
  </div><div class="vx_col2">
  <select id="crm_primary_field2" name="meta[primary_key2]" class="vx_sel vx_input_100" autocomplete="off">
  <?php echo $this->crm_select($key_fields,$this->post('primary_key2',$meta)); ?>
  </select> 
  <div class="description" style="float: none; width: 90%"><?php esc_html_e('(optional) If you set second key then plugin will find results matching with first primary key OR second primary key', 'cf7-salesforce'); ?></div>
  </div>
  <div class="clear"></div>
  </div>
  
  
 <div class="vx_row">
  <div class="vx_col1">
  <label for="vx_update"><?php esc_html_e('Update Entry ', 'cf7-salesforce');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="vx_update" class="crm_toggle_check" name="meta[update]" value="1" <?php echo !empty($meta['update']) ? 'checked="checked"' : ''?> autocomplete="off"/>
    <label for="vx_update"><?php esc_html_e('Do not update entry, if already exists', 'cf7-salesforce'); ?></label>
  
  </div>
  <div class="clear"></div>
  </div>
  
   <div class="vx_row">
  <div class="vx_col1">
  <label for="vx_new_entry"><?php esc_html_e('Create New Entry ', 'cf7-salesforce');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="vx_new_entry" class="crm_toggle_check" name="meta[new_entry]" value="1" <?php echo !empty($meta['new_entry']) ? 'checked="checked"' : ''?> autocomplete="off"/>
    <label for="vx_new_entry"><?php esc_html_e('Do not create new entry in Salesforce', 'cf7-salesforce'); ?></label>
  
  </div>
  <div class="clear"></div>
  </div>
    
  </div>

  </div>
  <div class="vx_div">
     <div class="vx_head">
<div class="crm_head_div"> <?php echo sprintf(esc_html__('%s. Add Note.', 'cf7-salesforce'),$panel_count+=1); ?></div>
<div class="crm_btn_div" title="<?php esc_html_e('Expand / Collapse','cf7-salesforce') ?>"><i class="fa crm_toggle_btn fa-minus"></i></div>
<div class="crm_clear"></div> 
  </div>


  <div class="vx_group">

    <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_note">
  <?php esc_html_e("Add Note ", 'cf7-salesforce'); ?>
  <?php $this->tooltip('vx_entry_note') ?>
  </label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="crm_note" class="crm_toggle_check" name="meta[note_check]" value="1" <?php echo !empty($meta['note_check']) ? "checked='checked'" : ""?>/>
  <label for="crm_note_div">
  <?php esc_html_e("Enable", 'cf7-salesforce'); ?>
  </label>
  </div>
  <div style="clear: both;"></div>
  </div>
  <div id="crm_note_div" style="margin-top: 16px; <?php echo empty($meta["note_check"]) ? "display:none" : ""?>">
 
  
    <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_note_fields">
  <?php esc_html_e( 'Note Fields ', 'cf7-salesforce' ); $this->tooltip("vx_note_fields") ?>
  </label>
  </div>
  <div class="vx_col2 entry_col2">
  <textarea name="meta[note_val]"  placeholder="<?php esc_html_e("{field-id} text",'cf7-salesforce')?>" class="vx_input_100 vxc_field_input" style="height: 60px"><?php
  if(!empty($meta['note_fields']) && is_array($meta['note_fields'])){
          $meta['note_val']='{'.implode("}\n{",$meta['note_fields'])."}";
}
   echo $this->post('note_val',$meta); ?></textarea>
<div class="howto"><?php echo sprintf(esc_html__('You can add a form field %s in custom value from following form fields. You can use %s for separating note title from body','cf7-salesforce'),'<code>{field_id}</code>','<code>?</code>')?></div>

<select name="field"  class="vxc_field_option vx_input_100">
<?php echo $this->form_fields_options($form_id,'',$this->account,$id); ?>
</select>
   </div>
  <div style="clear: both;"></div>
  </div>
  
 
    <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_note_list">
  <?php esc_html_e( 'Salesforce Related List ', 'cf7-salesforce' ); ?>
  </label>
  </div>
  <div class="vx_col2">
  <select name="meta[note_list]" id="crm_note_list" class="vx_input_100" style="width: 100%"  autocomplete="off">
  <?php 
  $note_lists=array(''=>'Notes and Attachments list','notes'=>'Notes List');
  echo $this->gen_select($note_lists,$this->post('note_list',$meta)); ?>
  </select>
    <span class="howto">
  <?php esc_html_e('Note will be added to selected related list in salesforce.', 'cf7-salesforce'); ?>
  </span>
   </div>
  <div style="clear: both;"></div>
  </div>
   
  <div class="vx_row">
  <div class="vx_col1">
  <label for="crm_disable_note">
  <?php esc_html_e( 'Disable Note ', 'cf7-salesforce' ); $this->tooltip("vx_disable_note") ?>
  </label>
  </div>
  <div class="vx_col2">
  
  <input type="checkbox" style="margin-top: 0px;" id="crm_disable_note" class="crm_toggle_check" name="meta[disable_entry_note]" value="1" <?php echo !empty($meta['disable_entry_note']) ? "checked='checked'" : ""?>/>
  <label for="crm_disable_note">
  <?php esc_html_e('Do not Add Note if entry already exists in Salesforce', 'cf7-salesforce'); ?>
  </label>
    
   </div>
  <div style="clear: both;"></div>
  </div>
  
  </div>

  </div>
  </div>
  <!-------------------------- lead owner -------------------->
<?php  
  }  
$file=self::$path.'pro/pro-mapping.php';
if(self::$is_pr && file_exists($file)){
include_once($file);
}  
?>

  <div class="button-controls submit" style="padding-left: 5px;">
  <input type="hidden" name="form_id" value="<?php echo esc_attr($form_id) ?>">
  <button type="submit" title="<?php esc_html_e('Save Feed','cf7-salesforce'); ?>" name="<?php echo esc_attr($this->id) ?>_submit" class="button button-primary button-hero"> <i class="vx_icons vx vx-arrow-50"></i> <?php echo empty($fid) ? esc_html__("Save Feed", 'cf7-salesforce') : esc_html__("Update Feed", 'cf7-salesforce'); ?> </button>
  </div>

  <?php
 do_action('vx_plugin_upgrade_notice_plugin_'.$this->type);
  ?>

