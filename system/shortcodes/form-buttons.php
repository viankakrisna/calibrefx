<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Button shortcode</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
        <script language="javascript" type="text/javascript">
            function calibrefx_zobrazForm() {
		
                tinyMCEPopup.resizeToInnerSize();
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();		
                if(medziShortcodom != '') {			
                    document.getElementById('textButton_text').value = medziShortcodom;			
                    document.getElementById('iconButton_text').value = medziShortcodom;			
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
	
                // ziskaj text medzi shortcode tagmi
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                // ziskaj hodnoty z formu
                var textButton_type = document.getElementById('textButton_type').value;
                var textButton_size = document.getElementById('textButton_size').value;
                var textButton_url = document.getElementById('textButton_url').value;
                var textButton_rel = document.getElementById('textButton_rel').value;
                var textButton_text = document.getElementById('textButton_text').value;
                var textButton_active = document.getElementById('textButton_active');
                var textButton_disabled = document.getElementById('textButton_disabled');
                var textButton_block = document.getElementById('textButton_block');
                var custom_class = document.getElementById('custom_class').value;
                var custom_id = document.getElementById('custom_id').value;
        
                if (textButton_text != '' ){
                    shortcodeRetazec = '[button';
                    if(textButton_type != '') shortcodeRetazec += ' type="'+textButton_type+'"';
                    if(textButton_size != '') shortcodeRetazec += ' size="'+textButton_size+'"';
                    if(textButton_url != '') shortcodeRetazec += ' url="'+textButton_url+'"';
                    if(textButton_rel != 'nofollow') shortcodeRetazec += ' rel="'+textButton_rel+'"';
                    if(textButton_active.checked) shortcodeRetazec += ' active="'+textButton_active.value+'"';
                    if(textButton_disabled.checked) shortcodeRetazec += ' disabled="'+textButton_disabled.value+'"';
                    if(textButton_block.checked) shortcodeRetazec += ' block="'+textButton_block.value+'"';
                    if(custom_class != '') shortcodeRetazec += ' class="'+custom_class+'"';
                    if(custom_id != '') shortcodeRetazec += ' id="'+custom_id+'"';
                    shortcodeRetazec += ']'+textButton_text+'[/button]';
                }else{
                    alert('Opps! You have to insert text of the button.');				
                }
                
                //vloz shortcode a repaint editor
                if(window.tinyMCE) {
                    //window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcodeRetazec);
                    tinyMCEPopup.editor.execCommand('mceRepaint');
                    tinyMCEPopup.close();
                }
		
                return;
            }
        </script>
        <base target="_self" />

        <style type="text/css">

            label span { color: #f00; }

        </style>

    </head>
    <body onload="calibrefx_zobrazForm();">
        <form name="calibrefx_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="textButtonTabID" class="current"><span><a href="javascript:mcTabs.displayTab('textButtonTabID','textButtonTab');" onmousedown="return false;">Text buttons</a></span></li>
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 462px;">

                <!-- T E X T   B U T T O N S -->

                <div id="textButtonTab" class="panel current">
                    <fieldset>        
                        <legend>Button's style</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0"> 
                            <!-- type -->              
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_type">Type:</label></td>      
                                <td>                    
                                    <select name="textButton_type" id="textButton_type" style="width: 225px">                    
                                        <option value="default">Default</option>
                                        <option value="primary">Primary Button</option>
                                        <option value="info">Info Button</option>
                                        <option value="success">Success Button</option>
                                        <option value="warning">Warning Button</option>
                                        <option value="danger">Danger Button</option>
                                        <option value="link">Link Button</option>
                                    </select><br />
                                    <em style="font-size: 9px; color: #999;">Type of the button</em>
                                </td>                
                            </tr>          
                            <!-- size -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_size">Size:</label></td>                
                                <td>                    
                                    <select name="textButton_size" id="textButton_size" style="width: 225px">                    
                                        <option value="xs">Mini</option> 
                                        <option value="sm">Small</option>     
                                        <option value="" selected="selected">Default</option>
                                        <option value="lg">Large</option>                
                                    </select><br />  
                                    <em style="font-size: 9px; color: #999;">Size of the button</em>                  
                                </td>                
                            </tr> 
                            <!-- Block button -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_block">Block Level Buttons:</label></td>                
                                <td>                    
                                    <input type="checkbox" value="1" name="textButton_block" id="textButton_block" /> <span>Yes</span>
                                    <br />  
                                    <em style="font-size: 9px; color: #999;">Make size of the button full width of a parent</em>                  
                                </td>                
                            </tr> 
                            <!-- Active State -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_active">Is Active:</label></td>                
                                <td>                    
                                    <input type="checkbox" value="1" name="textButton_active" id="textButton_active" /> <span>Yes</span>
                                    <br />  
                                    <em style="font-size: 9px; color: #999;">Add active state element to the button</em>                      
                                </td>                
                            </tr>   
                            <!-- Disabled State -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_disabled">Is Disabled:</label></td>                
                                <td>                    
                                    <input type="checkbox" value="1" name="textButton_disabled" id="textButton_disabled" /> <span>Yes</span>
                                    <br />  
                                    <em style="font-size: 9px; color: #999;">Add disabled state element to the button</em>                      
                                </td>                
                            </tr>        
                        </table>     
                    </fieldset><br />   

                    <fieldset>        
                        <legend>Button text</legend><br />

                        <table border="0" cellpadding="4" cellspacing="0">
                            <!-- url -->  
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_url">URL:</label></td>                
                                <td>                
                                    <input type="text" name="textButton_url" id="textButton_url" style="width: 247px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">The destination URL of the button.</em>               
                                </td>                
                            </tr>  
                            <!-- rel -->
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_rel">Rel:</label></td>                          <td>                    
                                    <select name="textButton_rel" id="textButton_rel" style="width: 250px">                        
                                        <option value="dofollow">dofollow</option>
                                        <option value="nofollow">nofollow</option>                                                   
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Set rel attribute.</em>                
                                </td>                    
                            </tr>  
                            <!-- text -->
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_text"><span>*</span>Text:</label></td>              
                                <td>                
                                    <input type="text" name="textButton_text" id="textButton_text" style="width: 247px" /><br />
                                    <em style="font-size: 9px; color: #999999;">Insert the text of the button.</em>                
                                </td>                
                            </tr>              
                        </table>            
                    </fieldset>

                    <fieldset>        
                        <legend>Attributes</legend><br />

                        <table border="0" cellpadding="4" cellspacing="0">
                             <!-- Text ID -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="custom_id">Custom ID:</label></td>                          <td>                    
                                    <input type="text" name="custom_id" id="custom_id" style="width: 210px" />              
                                </td>                    
                            </tr>   
                            <!-- Text Classes -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="custom_class">Custom Class:</label></td>                          <td>                    
                                    <input type="text" name="custom_class" id="custom_class" style="width: 210px" />             
                                </td>                    
                            </tr>           
                        </table>            
                    </fieldset>
                </div><!-- /#textButtonTab -->

            </div><!-- /.panel_wrapper -->

            <div class="mceActionPanel">
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
                </div>

                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onclick="calibrefx_vlozSC();" />
                </div>
            </div>
        </form>
        <style type="text/css">
            #textButton_icon option,
            #textButton_icon{
                text-transform: capitalize;
            }
        </style>
    </body>
</html>