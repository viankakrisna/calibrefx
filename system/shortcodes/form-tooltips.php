<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tooltip shortcode</title>
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
                var shortcodeRetazec;
                // instancie tabov
                var tooltipTab_instancia = document.getElementById('tooltipTab');	
                // Text tooltip ==============================================================
        
                // ziskaj text medzi shortcode tagmi
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
        
                // ziskaj hodnoty z formu			
                var tooltip_position = document.getElementById('tooltip_position').value;	            
           
                shortcodeRetazec = '[tooltip position="'+tooltip_position+'" text="This is tooltip content." url="#"]Tooltip Text[/tooltip]'; 
            
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
                    <li id="tooltipTabID" class="current"><span><a href="javascript:mcTabs.displayTab('tooltipTabID','tooltipTab');" onmousedown="return false;">Tooltips</a></span></li>            
                </ul>
            </div>
            <div class="panel_wrapper">
                <div id="tooltipTab" class="panel current">
                    <fieldset>        
                        <legend>Tooltip color</legend><br />  
                        <table border="0" cellpadding="4" cellspacing="0">    
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;">
                                    <label for="tooltip_position">Tooltip position:</label>
                                </td>                          
                                <td>                    
                                    <select name="tooltip_position" id="tooltip_position" style="width:200px">                       
                                        <option value="top">Top</option>
                                        <option value="bottom">Bottom</option>
                                        <option value="right">Right</option>
                                        <option value="left">Left</option>                                              
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Position of the tooltip</em>                
                                </td>                
                            </tr>                                  
                        </table>     
                    </fieldset>         
                </div><!-- /#tooltipTab -->
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