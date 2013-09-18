<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Button shortcode</title>
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
                    document.getElementById('textButton_text').value = medziShortcodom;			
                    document.getElementById('iconButton_text').value = medziShortcodom;			
                }		
            }
	
            function calibrefx_vlozSC() {
		
                // shortcode sam
                var shortcodeRetazec;
	
                // ziskaj text medzi shortcode tagmi
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                // ziskaj hodnoty z formu
                var textButton_type = document.getElementById('textButton_type').value;
                var textButton_size = document.getElementById('textButton_size').value;
                var textButton_url = document.getElementById('textButton_url').value;
                var textButton_rel = document.getElementById('textButton_rel').value;
                var textButton_text = document.getElementById('textButton_text').value;
                var textButton_icon = document.getElementById('textButton_icon').value;
                var textButton_iconColor = document.getElementById('textButton_iconColor').value;
        
		
                if (textButton_text != '' ){
                    //shortcodeRetazec = '[button type="'+textButton_type+'" size="'+textButton_size+'" url="'+textButton_url+'" rel="'+textButton_rel+'"] '+textButton_text+' [/button] ';
                    
                    shortcodeRetazec = '[button';
                    if(textButton_type != '') shortcodeRetazec += ' type="'+textButton_type+'"';
                    if(textButton_size != '') shortcodeRetazec += ' size="'+textButton_size+'"';
                    if(textButton_url != '') shortcodeRetazec += ' url="'+textButton_url+'"';
                    if(textButton_rel != 'nofollow') shortcodeRetazec += ' rel="'+textButton_rel+'"';
                    if(textButton_icon != '') shortcodeRetazec += ' icon="'+textButton_icon+'"';
                    if(textButton_iconColor != '') shortcodeRetazec += ' icon_color="'+textButton_iconColor+'"';
                    shortcodeRetazec += ']'+textButton_text+'[/button]';
                }else{
                    alert('Opps! You have to insert text of the button.');				
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

            label span { color: #f00; }

        </style>

    </head>
    <body onload="calibrefx_zobrazForm();">
        <form name="calibrefx_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="textButtonTabID" class="current"><span><a href="javascript:mcTabs.displayTab('textButtonTabID','textButtonTab');" onmousedown="return false;">Text buttons</a></span></li>
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 340px;">

                <!-- T E X T   B U T T O N S -->

                <div id="textButtonTab" class="panel current">
                    <fieldset>        
                        <legend>Button's style</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0"> 
                            <!-- type -->              
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_type">Type:</label></td>      
                                <td>                    
                                    <select name="textButton_type" id="textButton_type" style="width: 225px">                    
                                        <option value="">Default</option>
                                        <option value="primary">Primary Button</option>
                                        <option value="info">Info Button</option>
                                        <option value="success">Success Button</option>
                                        <option value="warning">Warning Button</option>
                                        <option value="danger">Danger Button</option>
                                        <option value="inverse">Inverse Button</option>
                                        <option value="link">Link Button</option>
                                    </select><br />
                                    <em style="font-size: 9px; color: #999;">Type of the button</em>
                                </td>                
                            </tr>          
                            <!-- size -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_size">Size:</label></td>                
                                <td>                    
                                    <select name="textButton_size" id="textButton_size" style="width: 225px">                    
                                        <option value="mini">Mini</option> 
                                        <option value="small">Small</option>     
                                        <option value="" selected="selected">Default</option>
                                        <option value="large">Large</option>                
                                    </select><br />  
                                    <em style="font-size: 9px; color: #999;">Size of the button</em>                  
                                </td>                
                            </tr>     
                            <!-- Icon -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_icon">Icon:</label></td>                
                                <td>                    
                                    <select name="textButton_icon" id="textButton_icon" style="width: 225px">                    
                                        <option value="">none</option>
                                        <option value="glass">glass</option>
                                        <option value="music">music</option>
                                        <option value="search">search</option>
                                        <option value="envelope">envelope</option>
                                        <option value="heart">heart</option>
                                        <option value="star">star</option>
                                        <option value="star-empty">star-empty</option>
                                        <option value="user">user</option>
                                        <option value="film">film</option>
                                        <option value="th-large">th-large</option>
                                        <option value="th">th</option>
                                        <option value="th-list">th-list</option>
                                        <option value="ok">ok</option>
                                        <option value="remove">remove</option>
                                        <option value="zoom-in">zoom-in</option>
                                        <option value="zoom-out">zoom-out</option>
                                        <option value="off">off</option>
                                        <option value="signal">signal</option>
                                        <option value="cog">cog</option>
                                        <option value="trash">trash</option>
                                        <option value="home">home</option>
                                        <option value="file">file</option>
                                        <option value="time">time</option>
                                        <option value="road">road</option>
                                        <option value="download-alt">download-alt</option>
                                        <option value="download">download</option>
                                        <option value="upload">upload</option>
                                        <option value="inbox">inbox</option>

                                        <option value="play-circle">play-circle</option>
                                        <option value="repeat">repeat</option>
                                        <option value="refresh">refresh</option>
                                        <option value="list-alt">list-alt</option>
                                        <option value="lock">lock</option>
                                        <option value="flag">flag</option>
                                        <option value="headphones">headphones</option>
                                        <option value="volume-off">volume-off</option>
                                        <option value="volume-down">volume-down</option>
                                        <option value="volume-up">volume-up</option>
                                        <option value="qrcode">qrcode</option>
                                        <option value="barcode">barcode</option>
                                        <option value="tag">tag</option>
                                        <option value="tags">tags</option>
                                        <option value="book">book</option>
                                        <option value="bookmark">bookmark</option>
                                        <option value="print">print</option>
                                        <option value="camera">camera</option>
                                        <option value="font">font</option>
                                        <option value="bold">bold</option>
                                        <option value="italic">italic</option>
                                        <option value="text-height">text-height</option>
                                        <option value="text-width">text-width</option>
                                        <option value="align-left">align-left</option>
                                        <option value="align-center">align-center</option>
                                        <option value="align-right">align-right</option>
                                        <option value="align-justify">align-justify</option>
                                        <option value="list">list</option>

                                        <option value="indent-left">indent-left</option>
                                        <option value="indent-right">indent-right</option>
                                        <option value="facetime-video">facetime-video</option>
                                        <option value="picture">picture</option>
                                        <option value="pencil">pencil</option>
                                        <option value="map-marker">map-marker</option>
                                        <option value="adjust">adjust</option>
                                        <option value="tint">tint</option>
                                        <option value="edit">edit</option>
                                        <option value="share">share</option>
                                        <option value="check">check</option>
                                        <option value="move">move</option>
                                        <option value="step-backward">step-backward</option>
                                        <option value="fast-backward">fast-backward</option>
                                        <option value="backward">backward</option>
                                        <option value="play">play</option>
                                        <option value="pause">pause</option>
                                        <option value="stop">stop</option>
                                        <option value="forward">forward</option>
                                        <option value="fast-forward">fast-forward</option>
                                        <option value="step-forward">step-forward</option>
                                        <option value="eject">eject</option>
                                        <option value="chevron-left">chevron-left</option>
                                        <option value="chevron-right">chevron-right</option>
                                        <option value="plus-sign">plus-sign</option>
                                        <option value="minus-sign">minus-sign</option>
                                        <option value="remove-sign">remove-sign</option>
                                        <option value="ok-sign">ok-sign</option>

                                        <option value="question-sign">question-sign</option>
                                        <option value="info-sign">info-sign</option>
                                        <option value="screenshot">screenshot</option>
                                        <option value="remove-circle">remove-circle</option>
                                        <option value="ok-circle">ok-circle</option>
                                        <option value="ban-circle">ban-circle</option>
                                        <option value="arrow-left">arrow-left</option>
                                        <option value="arrow-right">arrow-right</option>
                                        <option value="arrow-up">arrow-up</option>
                                        <option value="arrow-down">arrow-down</option>
                                        <option value="share-alt">share-alt</option>
                                        <option value="resize-full">resize-full</option>
                                        <option value="resize-small">resize-small</option>
                                        <option value="plus">plus</option>
                                        <option value="minus">minus</option>
                                        <option value="asterisk">asterisk</option>
                                        <option value="exclamation-sign">exclamation-sign</option>
                                        <option value="gift">gift</option>
                                        <option value="leaf">leaf</option>
                                        <option value="fire">fire</option>
                                        <option value="eye-open">eye-open</option>
                                        <option value="eye-close">eye-close</option>
                                        <option value="warning-sign">warning-sign</option>
                                        <option value="plane">plane</option>
                                        <option value="calendar">calendar</option>
                                        <option value="random">random</option>
                                        <option value="comment">comment</option>
                                        <option value="magnet">magnet</option>

                                        <option value="chevron-up">chevron-up</option>
                                        <option value="chevron-down">chevron-down</option>
                                        <option value="retweet">retweet</option>
                                        <option value="shopping-cart">shopping-cart</option>
                                        <option value="folder-close">folder-close</option>
                                        <option value="folder-open">folder-open</option>
                                        <option value="resize-vertical">resize-vertical</option>
                                        <option value="resize-horizontal">resize-horizontal</option>
                                        <option value="hdd">hdd</option>
                                        <option value="bullhorn">bullhorn</option>
                                        <option value="bell">bell</option>
                                        <option value="certificate">certificate</option>
                                        <option value="thumbs-up">thumbs-up</option>
                                        <option value="thumbs-down">thumbs-down</option>
                                        <option value="hand-right">hand-right</option>
                                        <option value="hand-left">hand-left</option>
                                        <option value="hand-up">hand-up</option>
                                        <option value="hand-down">hand-down</option>
                                        <option value="circle-arrow-right">circle-arrow-right</option>
                                        <option value="circle-arrow-left">circle-arrow-left</option>
                                        <option value="circle-arrow-up">circle-arrow-up</option>
                                        <option value="circle-arrow-down">circle-arrow-down</option>
                                        <option value="globe">globe</option>
                                        <option value="wrench">wrench</option>
                                        <option value="tasks">tasks</option>
                                        <option value="filter">filter</option>
                                        <option value="briefcase">briefcase</option>
                                        <option value="fullscreen">fullscreen</option>        
                                    </select><br />  
                                    <em style="font-size: 9px; color: #999;">Icon of the button</em>                  
                                </td>                
                            </tr>          
                            <!-- size -->  
                            <tr>                
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_iconColor">Icon Color:</label></td>                
                                <td>                    
                                    <select name="textButton_iconColor" id="textButton_iconColor" style="width: 225px">                    
                                        <option value="">Default</option> 
                                        <option value="white">White</option>           
                                    </select><br />  
                                    <em style="font-size: 9px; color: #999;">Icon color of the button</em>                  
                                </td>                
                            </tr>                       
                        </table>     
                    </fieldset><br />   

                    <fieldset>        
                        <legend>Button text</legend><br />

                        <table border="0" cellpadding="4" cellspacing="0">
                            <!-- url -->  
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_url">URL:</label></td>                
                                <td>                
                                    <input type="text" name="textButton_url" id="textButton_url" style="width: 247px" /><br /> 
                                    <em style="font-size: 9px; color: #999999;">The destination URL of the button.</em>               
                                </td>                
                            </tr>  
                            <!-- rel -->
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_rel">Rel:</label></td>                          <td>                    
                                    <select name="textButton_rel" id="textButton_rel" style="width: 250px">                        
                                        <option value="dofollow">dofollow</option>
                                        <option value="nofollow">nofollow</option>                                                   
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Set rel attribute.</em>                
                                </td>                    
                            </tr>  
                            <!-- text -->
                            <tr>             
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="textButton_text"><span>*</span>Text:</label></td>              
                                <td>                
                                    <input type="text" name="textButton_text" id="textButton_text" style="width: 247px" />
                                    <em style="font-size: 9px; color: #999999;">Insert the text of the button.</em>                
                                </td>                
                            </tr>              
                        </table>            
                    </fieldset>
                </div><!-- /#textButtonTab -->

            </div><!-- /.panel_wrapper -->

            <div class="mceActionPanel">
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
                </div>

                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onclick="calibrefx_vlozSC();" />
                </div>
            </div>
        </form>
        <style type="text/css">
            #textButton_icon option,
            #textButton_icon{
                text-transform: capitalize;
            }
        </style>
    </body>
</html>