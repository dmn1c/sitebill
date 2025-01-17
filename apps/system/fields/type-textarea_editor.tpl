{if $editor_code=='ckeditor'}
    {if !$NO_DYNAMIC_INCS}
    <script type="text/javascript" src="{$estate_folder}/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{$estate_folder}/ckeditor/adapters/jquery.js"></script>
    {/if}
    {literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $("textarea#{/literal}{$id}{literal}").ckeditor({
                filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?Type=Images',
                filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
        });
    </script>
    {/literal}
{elseif $editor_code=='wysibb'}
    {if !$NO_DYNAMIC_INCS}
    <script type="text/javascript" src="{$estate_folder}/wysibb/jquery.wysibb.min.js"></script>
    <link rel="stylesheet" href="{$estate_folder}/wysibb/theme/default/wbbtheme.css" />
    {/if}
    {literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $("textarea#{/literal}{$id}{literal}").wysibb({
                buttons: "bold,italic,underline,|,img,link,|,code,quote"
            });
        });
    </script>
    {/literal}
{elseif $editor_code=='bbeditor'}
    {if !$NO_DYNAMIC_INCS}
    <link rel="stylesheet" type="text/css" href="{$estate_folder}/apps/bbcode/site/js/bbeditor/bbeditor.css" />
    <script src="{$estate_folder}/apps/bbcode/site/js/bbeditor/jquery.bbcode.js" type="text/javascript"></script>
    {/if}
    {literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $("textarea#{/literal}{$id}{literal}").bbcode({
                tag_bold:true,tag_italic:true,tag_underline:true,tag_link:true,tag_image:true,button_image:false
            });
            process();
        });
        var bbcode="";
        function process(){
            if (bbcode != $("textarea#{$id}").val()){
                bbcode = $("textarea#{$id}").val();
                $.get(estate_folder+"/apps/bbcode/site/js/bbeditor/bbParser.php",
                {
                    bbcode: bbcode
                },
                function(txt){
                    $("#test{$id}").html(txt);
                })
            }
            setTimeout("process()", 2000);
        }
    </script>
    {/literal}
{elseif $editor_code=='codemirror'}
    {if !$NO_DYNAMIC_INCS}
        <link rel="stylesheet" href="{$estate_folder}/apps/third/codemirror/lib/codemirror.css">
        <link rel="stylesheet" href="{$estate_folder}/apps/third/codemirror/addon/fold/foldgutter.css" />
        <link rel="stylesheet" href="{$estate_folder}/apps/third/codemirror/addon/display/fullscreen.css">

        <script src="{$estate_folder}/apps/third/codemirror/lib/codemirror.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/fold/foldcode.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/fold/foldgutter.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/fold/brace-fold.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/fold/xml-fold.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/fold/comment-fold.js"></script>

        <script src="{$estate_folder}/apps/third/codemirror/mode/xml/xml.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/mode/css/css.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/mode/javascript/javascript.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/mode/htmlmixed/htmlmixed.js"></script>
        <script src="{$estate_folder}/apps/third/codemirror/addon/display/fullscreen.js"></script>
    {/if}
    {literal}
    <script type="text/javascript">
        $(document).ready(function() {
            var editor = CodeMirror.fromTextArea(document.getElementById("{/literal}{$id}{literal}"),{
                mode: "htmlmixed",
                lineNumbers: true,
                viewportMargin: Infinity,
                lineWrapping: true,
                foldGutter: true,
                gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                extraKeys: {
                    "F11": function(cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function(cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
            });
        });
    </script>
    {/literal}
{else}
    {if !$NO_DYNAMIC_INCS}
        <link rel="stylesheet" type="text/css" href="{$estate_folder}/js/cleditor/jquery.cleditor.css" />
        <script type="text/javascript" src="{$estate_folder}/js/cleditor/jquery.cleditor.min.js"></script>
    {/if}
    {literal}
        <script type="text/javascript">
        $(document).ready(function(){
            $("textarea#{/literal}{$id}{literal}").cleditor({width:{/literal}{if $item_array.parameters.width > 0}{$item_array.parameters.width}{else}350{/if}{literal}});
        });
        </script>
    {/literal}
{/if}
<textarea id="{$id}" class="input" name="{$item_array.name}" rows="{$item_array.rows}" cols="{$item_array.cols}">{$item_array.value}</textarea>