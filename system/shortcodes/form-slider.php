<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Slider shortcode</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
        <script language="javascript" type="text/javascript">
            function calibrefx_zobrazForm() {
                tinyMCEPopup.resizeToInnerSize();
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcode_output;
		
                // instancie tabov
                var nivoTab_instancia = document.getElementById('nivoTab');	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (nivoTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var slider_interval = document.getElementById('slider_interval').value;	
                    var slider_speed = document.getElementById('slider_speed').value; 
                    var slider_item = document.getElementById('slider_item').value;
                    var slider_effect = document.getElementById('slider_effect').value;
                    var slider_pager = document.getElementById('slider_pager').value;
                    var slider_nav = document.getElementById('slider_nav').value;
                    var slider_width = document.getElementById('slider_width').value;
                    var slider_height = document.getElementById('slider_height').value;

                    shortcode_output = '[slider';

                    if(slider_interval != '') shortcode_output += ' interval="'+slider_interval+'"';
                    if(slider_speed != '') shortcode_output += ' speed="'+slider_speed+'"';
                    if(slider_effect != '' && slider_effect != 'fade') shortcode_output += ' fx="'+slider_effect+'"';
                    if(slider_pager != '' && slider_pager != 0) shortcode_output += ' pager="'+slider_pager+'"';
                    if(slider_nav != '' && slider_nav != 0) shortcode_output += ' next_prev="'+slider_nav+'"';
                    if(slider_height != '') shortcode_output += ' height="'+slider_height+'"';
                    if(slider_width != '') shortcode_output += ' speed="'+slider_width+'"';

                    shortcode_output += "]";
              
				
                    for( var i = 0; i < slider_item; i++ ){
                        shortcode_output += '[slider_item src="ABSOLUTE PATH TO THE IMAGE FILE" url="" title=""][/slider_item]';
                    }
				
                    shortcode_output += '[/slider]';
                   
                    //vloz shortcode a repaint editor
                    if(window.tinyMCE) {
                        //window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcode_output);
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode_output);
                        tinyMCEPopup.editor.execCommand('mceRepaint');
                        tinyMCEPopup.close();
                    }
		
                    return;
		
                } 
            }
        </script>
        <base target="_self" />

        <style type="text/css">

            label span {color: #f00; }

        </style>

    </head>
    <body onload="calibrefx_zobrazForm();">
        <form name="calibrefx_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="nivoTabID" class="current"><span><a href="javascript:mcTabs.displayTab('nivoTabID','nivoTab');" onmousedown="return false;">Calibrefx Slider</a></span></li>
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 370px;">

                <div id="nivoTab" class="panel current" style="height: 370px;">

                    <fieldset>        
                        <legend>Slider</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- Interval -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_interval">Interval:</label></td>
                                <td>                    
                                    <input type="text" name="slider_interval" id="slider_interval" value="3000" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Slideshow interval transition (in miliseconds)</em>                  
                                </td>                    
                            </tr>  
                            <!-- Speed -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_speed">Speed:</label></td>
                                <td>                    
                                    <input type="text" name="slider_speed" id="slider_speed" value="800" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Speed of slider transition (in miliseconds)</em>                  
                                </td>                    
                            </tr> 	
                            <!-- Effect -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_effect">Effect:</label></td>
                                <td>                    
                                    <select name="slider_effect" id="slider_effect" style="width: 224px">     
                                        <option value="fade" selected="selected">Fade</option>                  
                                        <option value="fadeOut">Fade Out</option>
                                        <option value="scrollHorz">Scroll (Horizontal)</option>  
                                        <option value="none">None</option>                                            
                                    </select><br />
                                    <em style="font-size: 9px; color: #999999;">Select an effect to use in your slider</em>
                                </td>                    
                            </tr>  
                            <!-- Pager -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_pager">Use Pagination?</label></td>
                                <td>                    
                                    <select name="slider_pager" id="slider_pager" style="width: 224px">     
                                        <option value="0" selected="selected">No</option>                  
                                        <option value="1">Yes</option>                                          
                                    </select><br />
                                    <em style="font-size: 9px; color: #999999;">Select yes if you want to include paging in your slider</em>
                                </td>                    
                            </tr>   
                            <!-- Navigation -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_nav">Use Navigation?</label></td>
                                <td>                    
                                    <select name="slider_nav" id="slider_nav" style="width: 224px">     
                                        <option value="0" selected="selected">No</option>                  
                                        <option value="1">Yes</option>                                          
                                    </select><br />
                                    <em style="font-size: 9px; color: #999999;">Select yes if you want to include previous & next navigation in your slider</em>
                                </td>                    
                            </tr>  
                            <!-- Width -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_width">Width:</label></td>
                                <td>                    
                                    <input type="text" name="slider_width" id="slider_width" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Leave empty if you want slider to fit content or image width</em>
                                </td>                    
                            </tr>
                            <!-- Height -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_height">Height:</label></td>
                                <td>                    
                                    <input type="text" name="slider_height" id="slider_height" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Enter a number if you want to give a height to slider</em>
                                </td>                    
                            </tr>
                            <!-- Number of Slider Items -->     
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_item">Number of slides:</label></td>
                                <td>                    
                                    <input type="text" name="slider_item" id="slider_item" value="3" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Number of slider items</em>
                                </td>                    
                            </tr>   			  
                                                    
                        </table>     
                    </fieldset>
                </div><!-- /#nivoTab -->

            </div><!-- /.panel_wrapper -->

            <div class="mceActionPanel">
                <div style="float: left;">
                    <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
                </div>
                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onclick="calibrefx_vlozSC();" />
                </div>
            </div>
        </form>
    </body>
</html>