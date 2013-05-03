<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Image shortcode</title>
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
                    document.getElementById('image_text').value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var imageTab_instancia = document.getElementById('imageTab');	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (imageTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var imageWidth = document.getElementById('imageWidth').value;	
                    var imageHeight = document.getElementById('imageHeight').value;
                    var imageTitle = document.getElementById('imageTitle').value;
                    var imageSrc = document.getElementById('imageSrc').value;

                    if ( (imageWidth != '' ) && (imageHeight != '' ) ) {
                        //shortcodeRetazec
                        shortcodeRetazec = '[img width="' + imageWidth + '" height="' + imageHeight + '" title="' + imageTitle + '"]' + imageSrc + '[/img]';		
			
                    } else {
			
                        alert('Opps! You have to insert dimension of the image.');
			
                    }
		
		
		
                    //vloz shortcode a repaint editor
                    if(window.tinyMCE) {
                        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
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
                    <li id="imageTabID" class="current"><span><a href="javascript:mcTabs.displayTab('imageTabID','imageTab');" onmousedown="return false;">Google map</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 200px;">

                <div id="imageTab" class="panel current" style="height: 200px;">

                    <fieldset>        
                        <legend>Google map</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">    
                            <!-- title -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="imageTitle">Title:</label></td>
                                <td>                    
                                    <input type="text" name="imageTitle" id="imageTitle" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Title of image</em>                  
                                </td>                    
                            </tr>             
                            <!-- width-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="image_width">Width (px):</label></td>
                                <td>                    
                                    <input type="text" name="imageWidth" id="imageWidth" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Width of image in pixels.</em>                  
                                </td>                    
                            </tr>   
                            <!-- height-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="image_width">Height (px):</label></td>
                                <td>                    
                                    <input type="text" name="imageHeight" id="imageHeight" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Height of image in pixels.</em>                  
                                </td>                    
                            </tr> 	
                            <!-- src -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="imageSrc">URL:</label></td>
                                <td>                    
                                    <input type="text" name="imageSrc" id="imageSrc" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Source URL of image</em>                  
                                </td>                    
                            </tr> 			                                 
                        </table>     
                    </fieldset>
                </div><!-- /#imageTab -->

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