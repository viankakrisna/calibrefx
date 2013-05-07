<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Video shortcode</title>
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
                    document.getElementById('youtubeID').value = medziShortcodom;
                    document.getElementById('vimeoID').value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // ziskaj hodnoty z formu			
                var top_separator = document.getElementById('top_separator').value;	
                var bottom_separator = document.getElementById('bottom_separator').value;

                shortcodeRetazec = '[headline top_separator="' + top_separator + '" bottom_separator="' + bottom_separator + '"][h2]YOUR HEADLINE TEXT HERE[/h2][/headline]';
                
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

            label span {color: #f00; }

        </style>

    </head>
    <body onload="calibrefx_zobrazForm();">
        <form name="calibrefx_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="headlineID" class="current"><span><a href="javascript:mcTabs.displayTab('headlineID','headlineTab');" onmousedown="return false;">Headline</a></span></li>      
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 110px;">
  
                <div id="headlineTab" class="panel current" style="height: 110px;">        
                    <fieldset>        
                        <legend>Headline</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- top separator -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;">
                                    <label for="top_separator">Top Separator:</label>
                                </td>
                                <td>                    
                                    <select name="top_separator" id="top_separator" style="width: 180px">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <em style="font-size: 9px; color: #999999;">Use separator at the top of headline.</em>                  
                                </td>                    
                            </tr>   
                            <!-- bottom separator -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;">
                                    <label for="bottom_separator">Bottom Separator:</label>
                                </td>
                                <td>                    
                                    <select name="bottom_separator" id="bottom_separator" style="width: 180px">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <em style="font-size: 9px; color: #999999;">Use separator at the bottom of headline.</em>                  
                                </td>                    
                            </tr>                                
                        </table>     
                    </fieldset>
                </div><!-- /#youtubeTab -->
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