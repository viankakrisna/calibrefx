<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Button shortcode</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
        <script language="javascript" type="text/javascript">
            function lizatomic_zobrazForm() {
		
                tinyMCEPopup.resizeToInnerSize();
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();		
                if(medziShortcodom != '') {			
                    document.getElementById('textButton_text').value = medziShortcodom;			
                    document.getElementById('iconButton_text').value = medziShortcodom;			
                }		
            }
	
            function lizatomic_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var textButtonTab_instancia = document.getElementById('textButtonTab');
                var iconButtonTab_instancia = document.getElementById('iconButtonTab');		
		
                // Text button ==============================================================
        
                // je tab aktivny?
                if (textButtonTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu
                    var textButton_type = document.getElementById('textButton_type').value;
                    var textButton_size = document.getElementById('textButton_size').value;
                    var textButton_color = document.getElementById('textButton_color').value;
                    var textButton_url = document.getElementById('textButton_url').value;
                    var textButton_rel = document.getElementById('textButton_rel').value;
                    var textButton_text = document.getElementById('textButton_text').value;
            
			
                    if(medziShortcodom == '') {
				
                        if (textButton_text != '' )
                            shortcodeRetazec = '[button type="'+textButton_type+'" color="'+textButton_color+'" size="'+textButton_size+'" url="'+textButton_url+'" rel="'+textButton_rel+'"] '+textButton_text+' [/button] ';
                        else
                            alert('Opps! You have to insert text of the button.');				
                    } else {
                        shortcodeRetazec = '[button type="'+textButton_type+'" size="'+textButton_size+'" color="'+textButton_color+'" url="'+textButton_url+'" rel="'+textButton_rel+'"] '+textButton_text+' [/button] ';
				
                    }
                }

                // Icon button ==============================================================
        
                // je tab aktivny?
                if (iconButtonTab_instancia.className.indexOf('current') != -1) {
			
                    // extrahuj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu
                    var iconButton_icon = document.getElementById('iconButton_icon').value;
                    var iconButton_color = document.getElementById('iconButton_color').value;
                    var iconButton_url = document.getElementById('iconButton_url').value;
                    var iconButton_rel = document.getElementById('iconButton_rel').value;
                    var iconButton_text = document.getElementById('iconButton_text').value;
			
                    if(medziShortcodom == '') {
            	
                        if (iconButton_text != '' ) 
                            shortcodeRetazec = '[button icon="'+iconButton_icon+'" color="'+iconButton_color+'" url="'+iconButton_url+'" rel="'+iconButton_rel+'"] '+iconButton_text+' [/button] ';
                        else
                            alert('Opps! You have to insert text of the button.');
                    } else {
                        shortcodeRetazec = '[button icon="'+iconButton_icon+'" color="'+iconButton_color+'" url="'+iconButton_url+'" rel="'+iconButton_rel+'"] '+iconButton_text+' [/button] ';
                    }
				
                }
	
		
                //vloz shortcode a repaint editor
                if(window.tinyMCE) {
                    window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
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
    <body onload="lizatomic_zobrazForm();">
        <form name="lizatomic_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="textButtonTabID" class="current"><span><a href="javascript:mcTabs.displayTab('textButtonTabID','textButtonTab');" onmousedown="return false;">Text buttons</a></span></li>
                    <li id="iconButtonTabID"><span><a href="javascript:mcTabs.displayTab('iconButtonTabID','iconButtonTab');" onmousedown="return false;">Icon buttons</a></span></li>
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 300px;">

                <!-- T E X T   B U T T O N S -->

                <div id="textButtonTab" class="panel current">

                    <fieldset>        
                        <legend>Button's style</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0"> 
                            <!-- type -->              
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_type">Type:</label></td>      
                                <td>                    
                                    <select name="textButton_type" id="textButton_type" style="width: 250px">                    
                                        <option value="rounded">Rounded</option>
                                        <option value="square">Square</option>                                            
                                    </select><br />
                                    <em style="font-size: 9px; color: #999;">Type of the button</em>
                                </td>                
                            </tr>          
                            <!-- size -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_size">Size:</label></td>                
                                <td>                    
                                    <select name="textButton_size" id="textButton_size" style="width: 250px">                    
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>                    
                                    </select><br />  
                                    <em style="font-size: 9px; color: #999;">Size of the button</em>                  
                                </td>                
                            </tr>            
                            <!-- color -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_color">Color:</label></td>                          <td>                    
                                    <select name="textButton_color" id="textButton_color" style="width: 250px">                        
                                        <option value="light-blue">Light blue</option>
                                        <option value="light-green">Light green</option>                            
                                        <option value="yellow">Yellow</option>  
                                        <option value="blue">Blue</option>
                                        <option value="green">Green</option>
                                        <option value="black">Black</option>
                                        <option value="violet">Violet</option>
                                        <option value="bordo">Bordo</option>
                                        <option value="orange">Orange</option>
                                        <option value="gray">Gray</option>
                                        <option value="red">Red</option>
                                        <option value="pink">Pink</option>                                              
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Size of the button</em>                
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
                                    <em style="font-size: 9px; color: #999999;">The destination UR of the button.</em>               
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
                                    <input type="text" name="textButton_text" id="textButton_text" style="width: 247px" />
                                    <em style="font-size: 9px; color: #999999;">Insert the text of the button.</em>                
                                </td>                
                            </tr>              
                        </table>            
                    </fieldset>
                </div><!-- /#textButtonTab -->

                <!-- I C O N   B U T T O N S -->

                <div id="iconButtonTab" class="panel">

                    <fieldset>        
                        <legend>Button's style</legend><br />        
                        <table border="0" cellpadding="4" cellspacing="0">   
                            <!-- icon -->       
                            <tr>                        
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="iconButton_icon">Icon:</label></td>                      <td>                    
                                    <select name="iconButton_icon" id="iconButton_icon" style="width: 250px">                        
                                        <option value="accept">Accept</option>   
                                        <option value="add">Add</option>   
                                        <option value="arrow_refresh_small">Refresh</option>   
                                        <option value="blackboard_drawing">Blackboard</option>  
                                        <option value="book_addresses">Book</option>   
                                        <option value="box_down">Download</option>   
                                        <option value="bug_error">Bug</option>   
                                        <option value="delete">Delete</option>
                                        <option value="error">Error</option>   
                                        <option value="key">key</option>   
                                        <option value="calendar_edit">Calendar</option>   
                                        <option value="cart">Cart</option>
                                        <option value="coins">Coins</option>   
                                        <option value="emotion_smile">Smile</option>   
                                        <option value="file_extension_pdf">File PDF</option>   
                                        <option value="file_extension_psd">File PSD</option>
                                        <option value="file_extension_doc">File DOC</option>   
                                        <option value="file_extension_mpeg">File MPEG</option>   
                                        <option value="film">Film</option>   
                                        <option value="heart">Heart</option>
                                        <option value="help">Help</option>   
                                        <option value="information">Info</option>   
                                        <option value="scull">Scull</option>   
                                        <option value="tick">Tick</option>
                                        <option value="television">TV</option>   
                                        <option value="support">Support</option>   
                                        <option value="star">Star</option>   
                                        <option value="magnifier">Magnifier</option>
                                        <option value="exclamation">Exclamation</option>   
                                        <option value="cross">Cross</option>   
                                        <option value="paypal">Paypal</option>                                                            
                                    </select><br />   
                                    <em style="font-size: 9px; color: #999999;">Choose icon of the button</em>                 
                                </td>                    
                            </tr>  
                            <!-- color -->       
                            <tr>                        
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="iconButton_color">Color:</label></td>                      <td>                    
                                    <select name="iconButton_color" id="iconButton_color" style="width: 250px">                        
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>                           
                                    </select><br />   
                                    <em style="font-size: 9px; color: #999999;">Choose color of the button</em>                 
                                </td>                    
                            </tr>                    
                        </table>     
                    </fieldset><br />

                    <fieldset>        
                        <legend>Button text</legend><br />        
                        <table border="0" cellpadding="4" cellspacing="0">
                            <!-- url -->  
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="iconButton_url">URL:</label></td>                
                                <td>                
                                    <input type="text" name="iconButton_url" id="iconButton_url" style="width: 247px" /> 
                                    <em style="font-size: 9px; color: #999999;">The destination UR of the button.</em>               
                                </td>                
                            </tr>  
                            <!-- rel -->
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="iconButton_rel">Rel:</label></td>                          <td>                    
                                    <select name="iconButton_rel" id="iconButton_rel" style="width: 250px">                        
                                        <option value="dofollow">dofollow</option>
                                        <option value="nofollow">nofollow</option>                                                   
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Set rel attribute.</em>                
                                </td>                    
                            </tr>  
                            <!-- text -->
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="iconButton_text"><span>*</span>Text:</label></td>              
                                <td>                
                                    <input type="text" name="iconButton_text" id="iconButton_text" style="width: 247px" />
                                    <em style="font-size: 9px; color: #999999;">Insert the text of the button.</em>                
                                </td>                
                            </tr>              
                        </table>
                    </fieldset>
                </div><!-- /#iconButtonTab -->     

            </div><!-- /.panel_wrapper -->

            <div class="mceActionPanel">
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
                </div>

                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onclick="lizatomic_vlozSC();" />
                </div>
            </div>
        </form>
    </body>
</html>