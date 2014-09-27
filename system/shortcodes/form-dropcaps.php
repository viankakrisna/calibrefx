<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Dropcaps</title>
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
                    document.getElementById( 'dropcaps_text' ).value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
		
                // instancie tabov
                var dropcapsTab_instancia = document.getElementById( 'dropcapsTab' );	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (dropcapsTab_instancia.className.indexOf( 'current' ) != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var dropcaps_color = document.getElementById( 'dropcaps_color' ).value;
                    var dropcaps_font = document.getElementById( 'dropcaps_font' ).value;
                    var dropcaps_style = document.getElementById( 'dropcaps_style' ).value;    
                    var dropcaps_size = document.getElementById( 'dropcaps_size' ).value;           
	
                    shortcodeRetazec = '[dropcap color="' + dropcaps_color + '" font="' + dropcaps_font + '" style="' + dropcaps_style + '" size="' + dropcaps_size + '"]'+medziShortcodom+'[/dropcap]';
        
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
                    <li id="dropcapsTabID" class="current"><span><a href="javascript:mcTabs.displayTab( 'dropcapsTabID','dropcapsTab' );" onmousedown="return false;">Dropcaps</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 200px;">

                <div id="dropcapsTab" class="panel current">

                    <fieldset>        
                        <legend>Dropcaps</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- Color -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="dropcaps_color">Color:</label></td>                          <td>                    
                                    <select name="dropcaps_color" id="dropcaps_color" style="width: 210px">     
                                        <option value="color-default">Default</option>                  
                                        <option value="black">Black</option>
                                        <option value="white">White</option>  
                                        <option value="red">Red</option>  
                                        <option value="light-blue">Light Blue</option>  
                                        <option value="dark-blue">Dark Blue</option>
                                        <option value="light-green">Light Green</option>
                                        <option value="dark-green">Dark Green</option>                            
                                        <option value="violet">Violet</option>  
                                        <option value="brown">Brown</option> 
                                        <option value="yellow">Yellow</option>
                                        <option value="orange">Orange</option>
                                        <option value="pink">Pink</option>                                            
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select color.</em>                
                                </td>                    
                            </tr>  
                            <!-- Font family -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="dropcaps_font">Font family:</label></td>                          <td>                    
                                    <select name="dropcaps_font" id="dropcaps_font" style="width: 210px">     
                                        <option value="">Default</option>     
                                        <option value="arial">Arial</option>                  
                                        <option value="verdana">Verdana</option>
                                        <option value="times">Times New Roman</option>  
                                        <option value="geneva">Geneva</option>  
                                        <option value="courier">Courier New</option>  
                                        <option value="sans">MS Sans Serif</option>
                                        <option value="system">System</option>
                                        <option value="georgia">Georgia</option>                                   
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select font family.</em>                
                                </td>                    
                            </tr>
                            <!-- Font style -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="dropcaps_style">Font style:</label></td>                          <td>                    
                                    <select name="dropcaps_style" id="dropcaps_style" style="width: 210px">     
                                        <option value="normal">Normal</option>                  
                                        <option value="italic">Italic</option>
                                        <option value="oblique">Oblique</option>                                                        
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select style.</em>                
                                </td>                    
                            </tr> 
                            <!-- Font size -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="dropcaps_size">Font size:</label></td>                          <td>                    
                                    <select name="dropcaps_size" id="dropcaps_size" style="width: 210px">     
                                        <option value="ltt-3em">3em</option>                  
                                        <option value="ltt-4em">4em</option>
                                        <option value="ltt-5em">5em</option>  
                                        <option value="ltt-6em">6em</option> 
                                        <option value="ltt-7em">7em</option> 
                                        <option value="ltt-8em">8em</option> 
                                        <option value="ltt-9em">9em</option> 
                                        <option value="ltt-10em">10em</option>                                                       
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select style.</em>                
                                </td>                    
                            </tr>                                           
                        </table>     
                    </fieldset>
                </div><!-- /#dropcapsTab -->

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