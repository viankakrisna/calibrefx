<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Tabs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
	<script language="javascript" type="text/javascript">
	function lizatomic_zobrazForm() {
		tinyMCEPopup.resizeToInnerSize();
	}
	function insertShortcode() {
		var shortcodeRetazec;
		var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
		var tabs_instancia = document.getElementById('tabs');
		// who is active ?
		if (tabs_instancia.className.indexOf('current') != -1) {
		    var tabid = document.getElementById('tabID').value;
			var headingsString = document.getElementById('headingsSingle').value;
            var typeString = document.getElementById('type').value;
            var effectString = document.getElementById('effect').value;
            var timeoutValue = document.getElementById('timeout').value;
			if(headingsString != '') {
				var headings = headingsString.split("|");
				var headingsStringLenght = headings.length;
				var tabSlides = '';
				for(i=1;i<=headingsStringLenght;i++) {
					tabSlides += '[tab] '+headings[i-1]+' Content [/tab] ';
				}
				shortcodeRetazec = '[tabs tabid="'+tabid+'" type="'+typeString+'" effect="'+effectString+'" headings="'+headingsString+'" timeout="'+timeoutValue+'"] '+tabSlides+'[/tabs] ';
			} else {
				alert('Oops! You have to type in 1 tab heading. ');
			}
		}
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
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
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="lizatomic_sc_form" action="#">
	<div class="tabs">
		<ul>
			<li id="tabsID" class="current"><span><a href="javascript:mcTabs.displayTab('tabsID','tabs');" onmousedown="return false;">Tabs</a></span></li>
		</ul>
	</div>
	<div class="panel_wrapper"  style="height: 260px;">
		
		<div id="tabs" class="panel current" style="height: 200px;">
        <fieldset style="padding-left: 15px;">
            <legend>Tabs:</legend>
            <br />
            <table border="0" cellpadding="4" cellspacing="0">
            
                  <!-- ID -->
                 <tr>
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tabID">Tabs ID:</label></td>
                    <td>
                        <input type="text" name="tabID" id="tabID" value="tabID1" style="width: 220px" /><br />
                        <em style="font-size: 9px; color: #999;">ID of the tabs. This must be unique for each slideshow.</em>
                    </td>
                  </tr>
            
                 <!-- Headings -->
                 <tr>
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="headingsSingle">Tabs:</label></td>
                    <td>
                        <input type="text" name="headingsSingle" id="headingsSingle" value="Tab1|Tab2|Tab3" style="width: 220px" /><br />
                        <em style="font-size: 9px; width: #999;">Tabs' headings must be separated with |.</em>
                    </td>
                  </tr>
                  
                 <!-- Type -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="type">Type:</label></td>                          <td>                    
                        <select name="type" id="type" style="width: 222px">                       
                            <option value="vertical">Vertical</option>
                            <option value="horizontal">Horizontal</option>                                            
                        </select><br />      
                        <em style="font-size: 9px; color: #999;">Choose type of the tabs.</em>                
                    </td>                    
                  </tr>

                  <!-- Effect -->       
                 <tr>                 
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="effect">Effect:</label></td>                          <td>                    
                        <select name="effect" id="effect" style="width: 222px"> 
                            <option value="fade">fade</option>                      
                            <option value="cover">cover</option>                              
                            <option value="fadeZoom">fadeZoom</option>
                            <option value="growX">growX</option>
                            <option value="growY">growY</option>
                            <option value="scrollHorz">scrollHorz</option>
                            <option value="scrollVert">scrollVert</option>  
                            <option value="slideX">slideX</option>
                            <option value="slideY">slideY</option> 
                            <option value="zoom">zoom</option>                                     
                        </select><br />      
                        <em style="font-size: 9px; color: #999;">Choose transition effect.</em>                
                    </td>                    
                  </tr>
                  
                  <!-- Tiimeout -->
                 <tr>
                    <td nowrap="nowrap" style="vertical-align: text-top;"><label for="timeout">Timeout:</label></td>
                    <td>
                        <input type="text" name="timeout" id="timeout" value="0" style="width: 220px" /><br />
                        <em style="font-size: 9px; color: #999;">Milliseconds between slide transitions (0 to disable auto advance).</em>
                    </td>
                  </tr>
              </table>            
            <br /><br />
        </fieldset>
		</div>
		<!-- end small panel -->
	</div>
	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
		</div>
		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode();" />
		</div>
	</div>
</form>
</body>
</html>
<?php
?>