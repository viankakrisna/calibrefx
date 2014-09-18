<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Social bookmarks</title>
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
                    document.getElementById( 'social_text' ).value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var socialTab_instancia = document.getElementById( 'socialTab' );	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (socialTab_instancia.className.indexOf( 'current' ) != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var display_social = document.getElementById( 'display_social' ).value;
           
		
                    if ( display_social == 'all' ) {
            
                        shortcodeRetazec = '[digg] [stumble] [fblike] [tweet] [gplus] [pinterest]';
            
                    } else {  
            
                        shortcodeRetazec = '[' + display_social + ']';
        
                    }
        
                    //vloz shortcode a repaint editor
                    if(window.tinyMCE) {
                        //window.tinyMCE.execInstanceCommand( 'content', 'mceInsertContent', false, shortcodeRetazec);
                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcodeRetazec);
                        tinyMCEPopup.editor.execCommand( 'mceRepaint' );
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
                    <li id="socialTabID" class="current"><span><a href="javascript:mcTabs.displayTab( 'socialTabID','socialTab' );" onmousedown="return false;">Social bookmarks</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 120px;">

                <div id="socialTab" class="panel current" style="height: 120px;">

                    <fieldset>        
                        <legend>Social bookmarks</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- Bookmarks -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="display_social">Bookmark:</label></td>                          <td>                    
                                    <select name="display_social" id="display_social" style="width: 224px">     
                                        <option value="all">Display all</option>                  
                                        <option value="digg">Digg</option>
                                        <option value="stumble">Stumble</option>  
                                        <option value="fblike">Facebook Like</option>  
                                        <option value="tweet">Tweet Button</option> 
                                        <option value="gplus">Google Plus Button</option>  
                                        <option value="pinterest">Pin It Button</option>                                          
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select social bookmark you want to display.</em>                
                                </td>                    
                            </tr>                                              
                        </table>     
                    </fieldset>
                </div><!-- /#socialTab -->

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