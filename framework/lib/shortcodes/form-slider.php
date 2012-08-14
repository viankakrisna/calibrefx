<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Slider shortcode</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function lizatomic_zobrazForm() {
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function lizatomic_vlozSC() {
		
        // shortcode sam
		var shortcodeRetazec;
		
        // instancie tabov
		var nivoTab_instancia = document.getElementById('nivoTab');	
		
		// Column ==============================================================
        
        // je tab aktivny?
		if (nivoTab_instancia.className.indexOf('current') != -1) {
		  
			// ziskaj text medzi shortcode tagmi
			var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
			// ziskaj hodnoty z formu			
			var slider_interval = document.getElementById('slider_interval').value;	
            var slider_item = document.getElementById('slider_item').value;

            if ( (slider_item != '' ) && (slider_interval != '' ) ) {
				//shortcodeRetazec
				shortcodeRetazec = '[slider interval="3000"]';
				
				for( var i = 0; i < slider_item; i++ ){
					if( i == 0)
						shortcodeRetazec += '[slider_item src="ABSOLUTE PATH TO THE IMAGE FILE" class="active"][slider_caption]INSERT THE CAPTION HERE[/slider_caption][/slider_item]';
					else
						shortcodeRetazec += '[slider_item src="ABSOLUTE PATH TO THE IMAGE FILE"][slider_caption]INSERT THE CAPTION HERE[/slider_caption][/slider_item]';
				}
				
				shortcodeRetazec += '[/slider]';
			} else {
			
				alert('Opps! You have to insert dimension of the slider.');
			
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
<body onload="lizatomic_zobrazForm();">
	<form name="lizatomic_sc_form" action="#">
	<div class="tabs">
		<ul>
			<li id="nivoTabID" class="current"><span><a href="javascript:mcTabs.displayTab('nivoTabID','nivoTab');" onmousedown="return false;">Calibrefx Slider</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height: 160px;">
            
		<div id="nivoTab" class="panel current" style="height: 160px;">
        
        <fieldset>        
            <legend>Slider</legend><br />  
                   
            <table border="0" cellpadding="4" cellspacing="0">                
                <!-- Interval -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_interval">Interval:</label></td>
					<td>                    
                        <input type="text" name="slider_interval" id="slider_interval" value="3000" style="width: 220px" /><br /> 
                        <em style="font-size: 9px; color: #999999;">Slideshow interval transition (in miliseconds)</em>                  
                    </td>                    
                  </tr>   
                 <!-- Number of items -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="slider_item">Number of slides:</label></td>
					<td>                    
                        <input type="text" name="slider_item" id="slider_item" value="3" style="width: 220px" /><br /> 
                        <em style="font-size: 9px; color: #999999;">Number of slider item</em>                  
                    </td>                    
                  </tr> 				  
                 <!-- thumbnails -->       
                 <!--
<tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="is_last">Thumbnails?</label></td>                          <td>                    
                        <select name="is_last" id="is_last" style="width: 222px">                       
                            <option value="no">No</option>
                            <option value="yes">Yes</option>                                            
                        </select><br />      
                        <em style="font-size: 9px; width: #999;">Do you want to display thumbnails?</em>                
                    </td>                    
                  </tr>
-->                                 
              </table>     
         </fieldset>
		</div><!-- /#nivoTab -->
       
	</div><!-- /.panel_wrapper -->

	<div class="mceActionPanel">
		<div style="float: left;">
			<input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
		</div>
		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onclick="lizatomic_vlozSC();" />
		</div>
	</div>
</form>
</body>
</html>