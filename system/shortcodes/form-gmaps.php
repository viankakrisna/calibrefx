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
                if(medziShortcodom != '' ) {			
                    document.getElementById( 'googlemaps_text' ).value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var googlemapsTab_instancia = document.getElementById( 'googlemapsTab' );	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (googlemapsTab_instancia.className.indexOf( 'current' ) != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var googlemapsSrc = document.getElementById( 'googlemapsSrc' ).value;

                    if ( googlemapsSrc != '' ) {
                        shortcodeRetazec = '[gmap]' + googlemapsSrc + '[/gmap]';		
                    } else {
                        alert("Please enter google map embed code.");

                        return false;
                    }
		
		
		
                    //vloz shortcode a repaint editor
                    if(window.tinyMCE) {
                        //window.tinyMCE.execInstanceCommand( 'content', 'mceInsertContent', false, shortcodeRetazec);
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcodeRetazec);
                        tinyMCEPopup.editor.execCommand( 'mceRepaint' );
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
                    <li id="googlemapsTabID" class="current"><span><a href="javascript:mcTabs.displayTab( 'googlemapsTabID','googlemapsTab' );" onmousedown="return false;">Google map</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 179px;">

                <div id="googlemapsTab" class="panel current" style="height: 180px;">

                    <fieldset>        
                        <legend>Google map</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">				  
                            <!-- src-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="googlemaps_src">Source:</label></td>
                                <td>                    
                                    <textarea name="googlemapsSrc" id="googlemapsSrc" style="width: 330px" rows="10" placeholder='Example: <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7527831053085!2d106.82347299999999!3d-6.163853449999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d9881b132b%3A0xe268d076bd69fb6!2sCalibreWorks+-+Web+Design+%26+Development+in+Jakarta!5e0!3m2!1sid!2sid!4v1395311668046" width="600" height="450" frameborder="0" style="border:0"></iframe>'></textarea><br /> 
                                    <em style="font-size: 9px; color: #999999;">Insert google map embed code. You can find the tutorial <a href="https://support.google.com/maps/answer/3544418" target="_blank">here</a>.</em>                  
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