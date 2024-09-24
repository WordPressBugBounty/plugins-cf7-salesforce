<?php
  if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }
 $self_dir=admin_url().'?'.$this->id.'_tab_action=get_code'; 
  ?><div class="crm_fields_table">
    <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_name"><?php esc_html_e("Account Name",'cf7-salesforce'); ?></label>
  </div>
  <div class="crm_field_cell2">
  <input type="text" name="crm[name]" value="<?php echo !empty($name) ? esc_html($name) : 'Account #'.esc_html($id); ?>" id="vx_name" class="crm_text">

  </div>
  <div class="clear"></div>
  </div>
       <div class="crm_field">
  <div class="crm_field_cell1">
  <label for="vx_env"><?php esc_html_e('Environment','cf7-salesforce'); ?></label>
  </div>
  <div class="crm_field_cell2">
<select name="crm[env]" class="crm_text" id="vx_env" data-save="no" <?php if( $api!='web' && !empty($info['access_token'])){ echo 'disabled="disabled"'; } ?> >
  <?php $envs=array(''=>__('Production','cf7-salesforce'),'test'=>__('Sandbox','cf7-salesforce'));
foreach($envs as $k=>$v){
    $sel='';
if(!empty($info['env']) && $info['env'] == $k){ $sel='selected="selected"'; }
echo '<option value="'.esc_attr($k).'" '.$sel.'>'.esc_html($v).'</option>';
}
 ?>
 </select>
  </div>
  <div class="clear"></div>
  </div>
  <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_api"><?php esc_html_e("Integration Method",'cf7-salesforce'); ?></label>
  </div>
  <div class="crm_field_cell2">
  <label for="vx_api"><input type="radio" name="crm[api]" value="api" id="vx_api" class="vx_tabs_radio" <?php if($this->post('api',$info) != "web"){echo 'checked="checked"';} ?>> <?php esc_html_e('API','cf7-salesforce'); $this->tooltip('vx_api'); ?></label>
  <label for="vx_web" style="margin-left: 15px;"><input type="radio" name="crm[api]" value="web" id="vx_web" class="vx_tabs_radio" <?php if($this->post('api',$info) == "web"){echo 'checked="checked"';} ?>> <?php esc_html_e('Web-to-Lead or Web-to-Case (use this if API is not enabled for your Org) ','cf7-salesforce'); $this->tooltip('vx_web'); ?></label> 
  </div>
  <div class="clear"></div>
  </div>
  <div class="vx_tabs" id="tab_vx_web" style="<?php if($this->post('api',$info) != "web"){echo 'display:none';} ?>">
  <div class="crm_field">
  <div class="crm_field_cell1"><label for="org_id"><?php esc_html_e('Salesforce Org. ID','cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
  <div class="vx_tr" >
  <div class="vx_td">
  <input type="password" id="org_id" name="crm[org_id]" class="crm_text" placeholder="<?php esc_html_e('Salesforce Organization ID','cf7-salesforce'); ?>" value="<?php echo esc_html($this->post('org_id',$info)); ?>">
  </div><div class="vx_td2">
  <a href="#" class="button vx_toggle_btn vx_toggle_key" title="<?php esc_html_e('Toggle Key','cf7-salesforce'); ?>"><?php esc_html_e('Show Key','cf7-salesforce') ?></a>
  </div></div>
  <span class="howto"><?php esc_html_e("in salesforce Go to Setup -> Company information -> Organization ID",'cf7-salesforce'); ?></span>
  </div>
  <div class="clear"></div>
  </div> 
    <div class="crm_field">
  <div class="crm_field_cell1"><label for="org_url"><?php esc_html_e('Salesforce URL (optional)','cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
  <input type="url" id="org_url" name="crm[org_url]" class="crm_text" placeholder="<?php esc_html_e('Keep it empty','cf7-salesforce'); ?>" value="<?php echo esc_html($this->post('org_url',$info)); ?>">
  <span class="howto"><?php esc_html_e('Only set this url , if you do not receive data in salesforce, Copy your salesforce domain name with https from browser(e.g: https://my-instance.salesforce.com)','cf7-salesforce'); ?></span>
  </div>
  <div class="clear"></div>
  </div> 
  <div class="crm_field">
  <div class="crm_field_cell1"><label for="debug_email"><?php esc_html_e('Salesforce Debugging Emails','cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
  <input type="text" name="crm[debug_email]" id="debug_email" placeholder="<?php esc_html_e('Debugging Email','cf7-salesforce'); ?>" class="crm_text" value="<?php echo $this->post('debug_email',$info) ?>" />
  
  <span class="howto"><?php esc_html_e('Recommended - Salesforce will send notification about success or failure of lead/case to debug email.','cf7-salesforce'); ?></span> 
  </div>
  <div class="clear"></div>
  </div>   
  </div>
  <div class="vx_tabs" id="tab_vx_api" style="<?php if($this->post('api',$info) == "web"){echo 'display:none';} ?>">
  
  <div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e('Salesforce Access','cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
  <?php  if(isset($info['access_token'])  && $info['access_token']!="") {
  ?>
  <div style="padding-bottom: 8px;" class="vx_green"><i class="fa fa-check"></i> <?php
                            $instance_url=esc_url(str_replace("https://","",$info["instance_url"]));
  echo sprintf(esc_html__("Authorized Connection to %s on %s",'cf7-salesforce'),'<code>'.$instance_url.'</code>',date('F d, Y h:i:s A',$info['sales_token_time']));
        ?></div>
  <?php
  }else{
  $test_link='https://test.salesforce.com/services/oauth2/authorize?response_type=code&state='.urlencode($link."&".$this->id."_tab_action=get_token&id=".esc_html($id)."&vx_nonce=".$nonce.'&vx_env=test').'&client_id='.esc_html($client['client_id']).'&redirect_uri='.urlencode(esc_url($client['call_back'])).'&scope='.urlencode('api refresh_token'); 
      
 $link_href=$link='https://login.salesforce.com/services/oauth2/authorize?response_type=code&state='.urlencode($link."&".$this->id."_tab_action=get_token&id=".$id."&vx_nonce=".$nonce.'&vx_env=').'&client_id='.esc_html($client['client_id']).'&redirect_uri='.urlencode(esc_url($client['call_back'])).'&scope='.urlencode('api refresh_token'); 
 if(!empty($info['env'])){ $link_href=$test_link; }    
  ?>
  <a class="button button-default button-hero sf_login" id="vx_login_btn" target="_self" data-id="<?php echo esc_html($client['client_id']) ?>" href="<?php echo $link_href ?>" data-login="<?php echo $link ?>" data-test="<?php echo $test_link ?>"> <i class="fa fa-lock"></i> <?php esc_html_e("Login with Salesforce",'cf7-salesforce'); ?></a>
  <?php
  }
  ?></div>
  <div class="clear"></div>
  </div>                  
    <?php if(isset($info['access_token'])  && $info['access_token']!="") {
  ?>
    <div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e("Revoke Access",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">  <a class="button button-secondary" id="vx_revoke" href="<?php echo esc_url($link."&".$this->id."_tab_action=get_token&vx_nonce=".$nonce.'&id='.$id); ?>"><i class="fa fa-unlock"></i> <?php esc_html_e("Revoke Access",'cf7-salesforce'); ?></a>
  </div>
  <div class="clear"></div>
  </div> 
      <div class="crm_field">
  <div class="crm_field_cell1"><label><?php esc_html_e("Test Connection",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">      <button type="submit" class="button button-secondary" name="vx_test_connection"><i class="fa fa-refresh"></i> <?php esc_html_e("Test Connection",'cf7-salesforce'); ?></button>
  </div>
  <div class="clear"></div>
  </div> 
  <?php
    }
  ?>
  <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_error_email"><?php esc_html_e("Notify by Email on Errors",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2"><textarea name="crm[error_email]" id="vx_error_email" placeholder="<?php esc_html_e("Enter comma separated email addresses",'cf7-salesforce'); ?>" class="crm_text" style="height: 70px"><?php echo isset($info['error_email']) ? esc_html($info['error_email']) : ""; ?></textarea>
  <span class="howto"><?php esc_html_e("Enter comma separated email addresses. An email will be sent to these email addresses if an order is not properly added to Salesforce. Leave blank to disable.",'cf7-salesforce'); ?></span>
  </div>
  <div class="clear"></div>
  </div>  
   <div class="crm_field">
  <div class="crm_field_cell1"><label for="vx_custom_app_check"><?php esc_html_e("Salesforce App",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2"><div><input type="checkbox" name="crm[custom_app]" id="vx_custom_app_check" value="yes" <?php if($this->post('custom_app',$info) == "yes"){echo 'checked="checked"';} ?> ><?php echo esc_html__("Use Own Salesforce App - If you want to connect one Salesforce account to 5+ sites then use a separate Salesforce App for each 5 sites",'cf7-salesforce'); $this->tooltip('vx_custom_app'); ?></div>
  </div>
  <div class="clear"></div>
  </div>
  <div id="vx_custom_app_div" style="<?php if($this->post('custom_app',$info) != "yes"){echo 'display:none';} ?>">
     <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_id"><?php esc_html_e("Consumer Key",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
     <div class="vx_tr">
  <div class="vx_td">
  <input type="password" id="app_id" name="crm[app_id]" class="crm_text" placeholder="<?php esc_html_e("Salesforce Consumer Key",'cf7-salesforce'); ?>" value="<?php echo esc_html($this->post('app_id',$info)); ?>">
  </div><div class="vx_td2">
  <a href="#" class="button vx_toggle_btn vx_toggle_key" title="<?php esc_html_e('Toggle Consumer Key','cf7-salesforce'); ?>"><?php esc_html_e('Show Key','cf7-salesforce') ?></a>
  
  </div></div>
  
     <ol>
  <li><?php echo esc_html__('In Salesforce, go to Setup -> App Manager -> create new "Connected APP"','cf7-salesforce'); ?></li>
  <li><?php esc_html_e('Enter Application Name(eg. My App) then check "Enable OAuth Settings" checkbox','cf7-salesforce'); ?></li>
  <li><?php echo sprintf(esc_html__('Enter %s or %s in Callback URL','cf7-salesforce'),'<code>https://www.crmperks.com/sf_auth/</code>','<code>'.esc_url($self_dir).'</code>'); ?>
  </li>
<li><?php echo sprintf(esc_html__('Select OAuth Scopes %s and %s then Save Application','cf7-salesforce'),'<code>Access and manage your data (api)</code>','<code>Perform requests on your behalf at any time (refresh_token, offline_access)</code>'); ?></li>
<li><?php esc_html_e('Copy Consumer Key and Secret','cf7-salesforce'); ?></li>
   </ol>
   
</div>
  <div class="clear"></div>
  </div>
     <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_secret"><?php esc_html_e("Consumer Secret",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2">
       <div class="vx_tr" >
  <div class="vx_td">
 <input type="password" id="app_secret" name="crm[app_secret]" class="crm_text"  placeholder="<?php esc_html_e("Salesforce Consumer Secret",'cf7-salesforce'); ?>" value="<?php echo esc_html($this->post('app_secret',$info)); ?>">
  </div><div class="vx_td2">
  <a href="#" class="button vx_toggle_btn vx_toggle_key" title="<?php esc_html_e('Toggle Consumer Secret','cf7-salesforce'); ?>"><?php esc_html_e('Show Key','cf7-salesforce') ?></a>
  
  </div></div>
  </div>
  <div class="clear"></div>
  </div>
       <div class="crm_field">
  <div class="crm_field_cell1"><label for="app_url"><?php esc_html_e("Callback URL",'cf7-salesforce'); ?></label></div>
  <div class="crm_field_cell2"><input type="text" id="app_url" name="crm[app_url]" class="crm_text" placeholder="<?php esc_html_e("Salesforce Callback URL",'cf7-salesforce'); ?>" value="<?php echo esc_html($this->post('app_url',$info)); ?>"> 
 
  </div>
  <div class="clear"></div>
  </div>
  </div>
  </div> 
 
  <button type="submit" value="save" class="button-primary" title="<?php esc_html_e('Save Changes','cf7-salesforce'); ?>" name="save"><?php esc_html_e('Save Changes','cf7-salesforce'); ?></button>  
  </div>  