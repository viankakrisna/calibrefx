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
		
                // instancie tabov
                var youtubeTab_instancia = document.getElementById('youtubeTab');
                var vimeoTab_instancia = document.getElementById('vimeoTab');	
		
                // Column ==============================================================
        
                // je tab aktivny?
                if (youtubeTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var youtubeWidth = document.getElementById('youtubeWidth').value;	
                    var youtubeHeight = document.getElementById('youtubeHeight').value;
                    var youtubeID = document.getElementById('youtubeID').value;

                    if ( (youtubeWidth != '' ) && (youtubeHeight != '' ) ) {
                        //shortcodeRetazec
                        //shortcodeRetazec = '[youtube width=' + youtubeWidth + ' height=' + youtubeHeight + ']' + youtubeID + '[/youtube]';
            
                        shortcodeRetazec = '[youtube width="' + youtubeWidth + '" height="' + youtubeHeight + '"]'+youtubeID+'[/youtube]';
                    } else {
			
                        alert('Opps! You have to insert dimension of the video.');
                    } 
		
                } 
      
                // je tab aktivny?
                if (vimeoTab_instancia.className.indexOf('current') != -1) {
		  
                    // ziskaj text medzi shortcode tagmi
                    var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                    // ziskaj hodnoty z formu			
                    var vimeoWidth = document.getElementById('vimeoWidth').value;	
                    var vimeoHeight = document.getElementById('vimeoHeight').value;
                    var vimeoID = document.getElementById('vimeoID').value;

                    if ( (vimeoWidth != '' ) && (vimeoHeight != '' ) ) {
                        //shortcodeRetazec
                        //shortcodeRetazec = '[vimeo width=' + vimeoWidth + ' height=' + vimeoHeight + ']' + vimeoID + '[/vimeo]';
            
                        shortcodeRetazec = '[vimeo width="' + vimeoWidth + '" height="' + vimeoHeight + '"]'+vimeoID+'[/vimeo]';
            
                    } else {
			
                        alert('Opps! You have to insert dimension of the video.');
			
                    } 
		
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
                    <li id="youtubeTabID" class="current"><span><a href="javascript:mcTabs.displayTab('youtubeTabID','youtubeTab');" onmousedown="return false;">Youtube</a></span></li> 
                    <li id="vimeoTabID"><span><a href="javascript:mcTabs.displayTab('vimeoTabID','vimeoTab');" onmousedown="return false;">Vimeo</a></span></li>           
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 160px;">

                <!-- YOUTUBE -->    
                <div id="youtubeTab" class="panel current" style="height: 160px;">        
                    <fieldset>        
                        <legend>Youtube</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- width-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="youtubeWidth">Width (px):</label></td>
                                <td>                    
                                    <input type="text" name="youtubeWidth" id="youtubeWidth" value="500" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Width of video in pixels.</em>                  
                                </td>                    
                            </tr>   
                            <!-- height-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="youtubeHeight">Height (px):</label></td>
                                <td>                    
                                    <input type="text" name="youtubeHeight" id="youtubeHeight" value="300" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Height of video in pixels.</em>                  
                                </td>                    
                            </tr> 				  
                            <!-- video ID -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="youtubeID">ID of the video</label></td>                          <td>                    
                                    <input type="text" name="youtubeID" id="youtubeID" value="pRUGvArWXLk" style="width: 220px" /><br />       
                                    <em style="font-size: 9px; color: #999;">ID of the video: http://www.youtube.com/watch?v=<span style="color: green;">pRUGvArWXLk</span></em>                
                                </td>                    
                            </tr>                                 
                        </table>     
                    </fieldset>
                </div><!-- /#youtubeTab -->


                <!-- VIMEO -->    
                <div id="vimeoTab" class="panel" style="height: 160px;">        
                    <fieldset>        
                        <legend>Vimeo</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">                
                            <!-- width-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="vimeowidth">Width (px):</label></td>
                                <td>                    
                                    <input type="text" name="vimeoWidth" id="vimeoWidth" value="500" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Width of video in pixels.</em>                  
                                </td>                    
                            </tr>   
                            <!-- height-->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="vimeoHeight">Height (px):</label></td>
                                <td>                    
                                    <input type="text" name="vimeoHeight" id="vimeoHeight" value="300" style="width: 220px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">Height of video in pixels.</em>                  
                                </td>                    
                            </tr> 				  
                            <!-- video ID -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="vimeoID">ID of the video</label></td>                          <td>                    
                                    <input type="text" name="vimeoID" id="vimeoID" value="21294655" style="width: 220px" /><br />       
                                    <em style="font-size: 9px; color: #999;">ID of the video: http://vimeo.com/<span style="color: green;">21294655</span></em>                
                                </td>                    
                            </tr>                                 
                        </table>     
                    </fieldset>
                </div><!-- /#vimeoTab -->

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