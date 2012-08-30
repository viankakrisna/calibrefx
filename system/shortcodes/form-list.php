<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>List shortcode</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function lizatomic_zobrazForm() {
		
		tinyMCEPopup.resizeToInnerSize();
				var medziShortcodom = tinyMCE.activeEditor.selection.getContent();		
		if(medziShortcodom != '') {			
			document.getElementById('list_text').value = medziShortcodom;
       	}		
	}
	
	function lizatomic_vlozSC() {
		
        // shortcode sam
		var shortcodeRetazec;
		
        // instancie tabov
		var listTab_instancia = document.getElementById('listTab');	
		
		// Text list ==============================================================
        
        // je tab aktivny?
		if (listTab_instancia.className.indexOf('current') != -1) {
		  
			// ziskaj text medzi shortcode tagmi
			var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
			// ziskaj hodnoty z formu			
			var list_style = document.getElementById('list_style').value;	
		
		shortcodeRetazec = '[list style="'+list_style+'"]'+medziShortcodom+'[/list] ';
		
		
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
<body onload="lizatomic_zobrazForm();">
	<form name="lizatomic_sc_form" action="#">
	<div class="tabs">
		<ul>
			<li id="listTabID" class="current"><span><a href="javascript:mcTabs.displayTab('listTabID','listTab');" onmousedown="return false;">List</a></span></li>            
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height: 120px;">
            
		<div id="listTab" class="panel current" style="height: 120px;">
        
        <fieldset>        
            <legend>Lists style</legend><br />  
                   
            <table border="0" cellpadding="4" cellspacing="0">                
                <!-- state -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="list_style">Icons:</label></td>                          <td>                    
                        <select name="list_style" id="list_style" style="width: 250px">                       
                            <option value="bullet-tick">Tick</option>
                            <option value="cross">Cross</option>
                            <option value="bullet-tick">Tick</option>
                            <option value="bullet-arrow">Arrow</option>
                            <option value="bullet-black">Black bullet</option>
                            <option value="bullet-green">Green bullet</option>
                            <option value="bullet-orange">Orange bullet</option>
                            <option value="bullet-pink">Pink bullet</option>
                            <option value="bullet-purple">Purple bullet</option>
                            <option value="bullet-red">Red bullet</option>
                            <option value="bullet-star">Star</option>
                            <option value="bullet-paper-clip">Paper clip</option>
                            <option value="add">Add</option>
                            <option value="delete">Delete</option>                                          
                        </select><br />      
                        <em style="font-size: 9px; color: #999;">Select the lists icons.</em>                
                    </td>                    
                  </tr>                                  
              </table>     
         </fieldset>
		</div><!-- /#listTab -->
       
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