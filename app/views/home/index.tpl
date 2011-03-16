{literal}
<style>
    #project_form { width:800px;}
    #project_form label  { display:inline-block;width: 159px; border: 0px solid #000;}
    #project_form label{ vertical-align: top; }
</style>
<script>
    $(function() {
    $("#project").accordion({
			autoHeight: false,
			navigation: true
		});
    });

    $(document).ready(function() {
	oTable = $('#list-projects').dataTable({
		"bJQueryUI": true,
        "bProcessing": true,
        "bServerSide" : true,
        "bPaginate": false,
        "bFilter": false,
		"sAjaxSource": '/home/json-list-projects',
		"sPaginationType": "full_numbers"
        });
    } );

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
                        <th>Project Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>22</td>
                        <td>33</td>
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