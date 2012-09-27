<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Togglebox shortcode</title>
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
                    document.getElementById('togglebox_text').value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var toggleboxTab_instancia = document.getElementById('toggleboxTab');	
		
                // Text togglebox ==============================================================
        
                // je tab aktivny?
                if (toggleboxTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var togglebox_state = document.getElementById('togglebox_state').value;	
		
                    shortcodeRetazec = '[togglebox state="'+togglebox_state+'" head="Togglebox head" ]'+medziShortcodom+'[/togglebox] ';
		
		
                    //vloz shortcode a repaint editor
                    if(window.tinyMCE) {
                        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
                        tinyMCEPopup.editor.execCommand('mceRepaint');
                        tinyMCEPopup.close();
                    }
		
                    return;
                } }
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
                    <li id="toggleboxTabID" class="current"><span><a href="javascript:mcTabs.displayTab('toggleboxTabID','toggleboxTab');" onmousedown="return false;">Togglebox</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 120px;">

                <div id="toggleboxTab" class="panel current" style="height: 120px;">

                    <fieldset>        
                        <legend>Togglebox state</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- state -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="togglebox_state">State:</label></td>                          <td>                    
                                    <select name="togglebox_state" id="togglebox_state" style="width: 250px">                       
                                        <option value="open">Open</option>
                                        <option value="closed">Closed</option>                                            
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select the default state of the togglebox.</em>                
                                </td>                    
                            </tr>                                  
                        </table>     
                    </fieldset>
                </div><!-- /#toggleboxTab -->

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