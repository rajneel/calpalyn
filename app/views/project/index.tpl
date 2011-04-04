
{literal}
<style>
    .f_upload { display:none; }
</style>

{/literal}

<h2>Simple File Upload</h2>

<div id="add_html">
</div>
{literal}
<script>
    $(document).ready(function() {
        $("#add_html").load('/project/part-markup .upload-ui');
        $("#add_html")[0].innerHTML+='';
    });
    $(function() {
		$( "button, input:submit, a", ".upload-ui" ).button();
		$( "a", ".upload-ui" ).click(function() { return false; });

	});
    $(document).ready(function() {
        $('#switch .b_upload').click(function() {
                $('#switch .b_upload').hide();
                $('#switch .f_upload').show();

    });
    });
    

</script>
<script>
    $(document).ready(function() {
        $("#upload").jqUploader({
            debug: 0,
			background:           "FFFFDF",
			barColor:             "FFDD00",
            allowedExt: "*.xls; *.xlsx; *.csv; *.txt",
			params: {quality:'low', menu: false},
			allowedExtDescr:      "what you want",
			validFileMessage:     'Click on Upload!',
			endMessage:           'and don\'t you come back ;)',
			hideSubmit:           true,
			endHtml:             '<strong style="text-decoration:underline">Upload finished!(the filename is now stored in the form as an hidden input field)</strong>'
        });
    });
</script>
{/literal}