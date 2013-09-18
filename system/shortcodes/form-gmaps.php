<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Google Maps shortcode</title>
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
                    document.getElementById('googlemaps_text').value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var googlemapsTab_instancia = document.getElementById('googlemapsTab');	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (googlemapsTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var googlemapsWidth = document.getElementById('googlemapsWidth').value;	
                    var googlemapsHeight = document.getElementById('googlemapsHeight').value;
                    var googlemapsSrc = document.getElementById('googlemapsSrc').value;

                    if ( (googlemapsWidth != '' ) && (googlemapsHeight != '' ) ) {
                        //shortcodeRetazec
                        shortcodeRetazec = '[gmaps width="' + googlemapsWidth + '" height="' + googlemapsHeight + '" src="' + googlemapsSrc +'"]';		
			
                    } else {
			
                        alert('Opps! You have to insert dimension of the slider.');
			
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
                    <li id="googlemapsTabID" class="current"><span><a href="javascript:mcTabs.displayTab('googlemapsTabID','googlemapsTab');" onmousedown="return false;">Google map</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 160px;">

                <div id="googlemapsTab" class="panel current" style="height: 160px;">

                    <fieldset>        
                        <legend>Google map</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- width-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="googlemaps_width">Width (px):</label></td>
                                <td>                    
                                    <input type="text" name="googlemapsWidth" id="googlemapsWidth" value="500" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Width of map canvas in pixels.</em>                  
                                </td>                    
                            </tr>   
                            <!-- height-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="googlemaps_width">Height (px):</label></td>
                                <td>                    
                                    <input type="text" name="googlemapsHeight" id="googlemapsHeight" value="300" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Height of map canvas in pixels.</em>                  
                                </td>                    
                            </tr> 				  
                            <!-- src-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="googlemaps_src">Source:</label></td>
                                <td>                    
                                    <input type="text" name="googlemapsSrc" id="googlemapsSrc" value="" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Something like: http://maps.google.com/?ie=UTF8&ll=48.109265,14.205322&spn=0.324145,0.590515&t=h&z=11</em>                  
                                </td>                    
                            </tr>                                
                        </table>     
                    </fieldset>
                </div><!-- /#googlemapsTab -->

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