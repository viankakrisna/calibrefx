<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Tooltip shortcode</title>
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
		var tooltipTab_instancia = document.getElementById('tooltipTab');	
		// Text tooltip ==============================================================
        
			// ziskaj text medzi shortcode tagmi
			var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
        
        if (medziShortcodom != '') {            
            medziShortcodom = medziShortcodom;x
        }	else {
            medziShortcodom = "tooltip";
        } 
			// ziskaj hodnoty z formu			
			var tooltip_color = document.getElementById('tooltip_color').value;	            
           
			shortcodeRetazec = '[tooltip color="'+tooltip_color+'" text="This is tooltip content."] '+medziShortcodom+' [/tooltip]'; 
            
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
    label span { color: #f00; }
    </style>
</head>
<body onload="lizatomic_zobrazForm();">
	<form name="lizatomic_sc_form" action="#">
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
                <!-- color -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tooltip_color">Color:</label></td>                          <td>                    
                        <select name="tooltip_color" id="tooltip_color" style="width: 250px">                       
                            <option value="blue">Blue</option>
                            <option value="orange">Orange</option>
                            <option value="green">Green</option>
                            <option value="purple">Purple</option>
                            <option value="pink">Pink</option>
                            <option value="red">Red</option>
                            <option value="gray">Gray</option>
                            <option value="light-gray">Light gray</option>
                            <option value="black">Black</option>                                              
                        </select><br />      
                        <em style="font-size: 9px; color: #999;">Color of the tooltip</em>                
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
			<input type="submit" id="insert" name="insert" value="Insert" onclick="lizatomic_vlozSC();" />
		</div>
	</div>
</form>
</body>
</html>