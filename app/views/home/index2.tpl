{literal}
<style>
    #project_form { width:800px;}
    #project_form label  { display:inline-block;width: 159px; border: 0px solid #000;}
    #project_form label{ vertical-align: top; }

</style>
<style>
    .f_upload { display:none; }
</style>

<style>
    a.tip {
        position: relative;
    }

    a.tip span {
        display: none;
        position: absolute;
        bottom: 20px;
        left: -10px;
        width: 140px;
        padding: 5px;
        z-index: 100;
        background: #000;
        color: #fff;
        -moz-border-radius: 5px; /* this works only in camino/firefox */
        -webkit-border-radius: 5px; /* this is just for Safari */
    }

    a:hover.tip {
        font-size: 99%; /* this is just for IE */
    }

    a:hover.tip span {
        display: block;
    }
</style>

<script>

    $(function() {
        $( "button, input:submit, a", ".upload-ui" ).button();
        $( "a", ".upload-ui" ).click(function() { return false; });
        $('#switch .b_upload').click(function() {
                $('#switch .b_upload').hide();
                $('#switch .f_upload').show();
        });       
    });

    $(document).ready(function() {
       
        
    });

 
    $(function() {
    $("#project").accordion({
			autoHeight: false,
			navigation: true
		});
    });

    $(function() {
		$( "button, input:submit, a", ".create" ).button();
		$( "a", ".create" ).click(function() { return false; });
	});
    
</script>
{/literal}
<div id="home">
    <div id="project">
        <h3>View Projects </h3>
        <div>
            <table id="list-projects">
                <thead>
                    <tr>
                        <th>Project Id</th>
                        <th>Project Name</th>
                        <th>Project Owner</th>
                        <th>Project Description</th>
                        <th>Project Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>22</td>
                        <td>222</td>
                        <td>33</td>
                        <td>44</td>
                    </tr>
                </tbody>
             </table>
        </div>
        <h3>Add Project</h3>
        <div class="create">
            <form id="project_form" action="/project/create" method="post">
                <label>Project Name:</label><input type="text" name="project_name" value=""/><br/>
                <label>Project Description</label><textarea maxlength="12" rows="2" cols="18" name="project_desc"></textarea><br/>
                <label></label><input type="submit"  value="Create Project" />
            </form>
        </div>
        
    </div>
</div>
{literal}
<script>

 $(document).ready(function() {
         
       oTable = $('#list-projects').dataTable({
		"bJQueryUI": true,
        "bProcessing": true,
        "bServerSide" : true,
        "bPaginate": false,
        "bFilter": false,
		"sAjaxSource": '/project/json-list-projects',
		"sPaginationType": "full_numbers"
        });
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