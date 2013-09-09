<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tabs</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
        <script language="javascript" type="text/javascript">
            function calibrefx_zobrazForm() {
                tinyMCEPopup.resizeToInnerSize();
            }
            function insertShortcode() {
                var shortcode_output, shortcode_attr;
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                var tabs_instancia = document.getElementById('tabs');
                // who is active ?
                if (tabs_instancia.className.indexOf('current') != -1) {
                    var tab_id = document.getElementById('tab_id').value;
                    var tab_class = document.getElementById('tab_class').value;
                    var tab_heading = document.getElementById('tab_heading').value;
                    var tab_elm = document.getElementById('tab_elm').value;
                   
                    if(tab_heading != '') {
                        var headings = tab_heading.split("|");
                        var headingsStringLength = headings.length;
                        var tabSlides = '';

                        var elements = tab_elm.split("|");
                        var elements_length = elements.length;
                        var tab_elements = '';

                        if(elements == '' || headingsStringLength != elements_length){
                            for(i=0;i<headingsStringLength;i++) {
                                elements[i] = 'tab'+i;
                            }
                        }

                        for(i=0;i<headingsStringLength;i++) {
                            tabSlides += '[tab id="'+elements[i]+'"] '+headings[i]+' Content [/tab] ';
                        }

                        shortcode_attr = '';
                        if(tab_id != '') shortcode_attr += ' id="'+tab_id+'"';
                        if(tab_class != '') shortcode_attr += ' class="'+tab_class+'"';

                        shortcode_output = '[tabs headings="'+tab_heading+'" tab="'+tab_elm+'"'+shortcode_attr+'] '+tabSlides+'[/tabs] ';
                    } else {
                        alert('Oops! You have to type in 1 tab heading. ');
                    }
                }
                if(window.tinyMCE) {
                    //window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcode_output);
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode_output);
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
    <body onload="calibrefx_zobrazForm();">
        <!-- <form onsubmit="insertLink();return false;" action="#"> -->
        <form name="calibrefx_sc_form" action="#">
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
                            <!-- Headings -->
                            <tr>
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tab_heading">Tabs Headings:</label></td>
                                <td>
                                    <input type="text" name="tab_heading" id="tab_heading" value="Tab1|Tab2|Tab3" style="width: 190px" /><br />
                                    <em style="font-size: 9px; color: #999;">Tabs headings must be separated with |.</em>
                                </td>
                            </tr>

                            <!-- ID -->
                            <tr>
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tab_id">Tabs ID:</label></td>
                                <td>
                                    <input type="text" name="tabID" id="tab_id" value="" style="width: 190px" /><br />
                                    <em style="font-size: 9px; color: #999;">ID of the tabs. This must be unique for each slideshow.</em>
                                </td>
                            </tr>

                            <!-- Class -->
                            <tr>
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tab_class">Tabs Class:</label></td>
                                <td>
                                    <input type="text" name="tab_class" id="tab_class" value="" style="width: 190px" /><br />
                                    <em style="font-size: 9px; color: #999;">Classes of the tabs. Enter the classes if you want to use custom classes.</em>
                                </td>
                            </tr>

                            <!-- Element -->
                            <tr>
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="tab_elm">Tabs Elements:</label></td>
                                <td>
                                    <input type="text" name="tab_elm" id="tab_elm" value="tab1|tab2|tab3" style="width: 190px" /><br />
                                    <em style="font-size: 9px; color: #999;">Tabs elements must be separated with |. This will used to generate tab content id.</em>
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