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

    .even {
        background:#cccccc;
    }
    .even:hover {
        background:#A3CBFF;
    }
    .odd {
        background:#fff;
    }
    .odd:hover {
        background:#A3CBFF;
    }
    .depth {
        font-weight: bold;
    }

    .header {
        color:#B12250;
    }
}
}
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

    
 
    $(function() {
    $("#project").accordion({
			autoHeight: false,
			navigation: true,
            animated: 'easeslide'
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
        <h3>List Projects </h3>
        <div>
            <table id="list-projects">
                <thead>
                    <tr>
                        <th>Project Details</th>
                        <th>Project Id</th>
                        <th>Project Name</th>
                        <th>Project Owner</th>
                        <th>Project Description</th>
                        <th>Project Data</th>
                    </tr>
                </thead>
                <tbody>
                  {foreach from=$projects item=project}
                  <tr class="{cycle values='odd,even'}">
                      <td><a id="project_data" href="/home/index?pid={$project.id}">View</a></td>
                      <td>{$project.id}</td>
                      <td>{$project.name}</td>
                      <td>{$project.user_info}</td>
                      <td>{$project.desc}</td>
                      <td>
                      {literal}
                        <script>
                         $(document).ready(function() {
                             var uploader = new qq.FileUploader({
                             // pass the dom node (ex. $(selector)[0] for jQuery users)
                             element: document.getElementById('file-uploader_{/literal}{$project.id}{literal}'),
                             params: { pid: {/literal}{$project.id}{literal}},
                             // path to server-side upload script
                             action: '/project/upload',
                             allowedExtensions: ['txt', 'xls','csv','xlsx'],
                             debug: true,
                             showMessage: function(message){ alert(message); }
                             });
                         });
                        </script>
                      {/literal}
                      <div class='upload-ui'>
                         <div id='switch'>
                            <div class='b_upload'>
                            <button id='u_button' class='upload-ui' name='u_button'>Start upload</button>
                            </div>
                            <div class='f_upload'>   
                                <div id="file-uploader_{$project.id}">
                                    <noscript>
                                    <p>Please enable JavaScript to use file uploader.</p>
                                    <!-- or put a simple form for upload here -->
                                    </noscript>
                                </div>

                            </div>
                        </div>
                      </div></td>
                  </tr>
                  {/foreach}
                </tbody>
             </table>
        </div>
        <h3>View Project Data</h3>
        <div class="view">
            {if $project_data}
            {literal}
            <script>
                $(document).ready(function() {
                $('#project_data').click(function() {
                    if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
                    $('#project_data').removeClass('active').next().slideUp(); //Remove all "active" state and slide up the immediate next container
                    $(this).toggleClass('active').next().slideDown(); //Add "active" state to clicked trigger and slide down the immediate next container
                }
                return false; //Prevent the browser jump to the link anchor
                });
            </script>
            {/literal}
            <h4>PROJECT: {$projects_info.project_id.name | capitalize}</h4>
            <table id="list-project-data">
                <thead>
                    <tr class="header">
                        <th>Depth</th>
                        {foreach from=$field_names item=col}
                        <th>{$taxons.$col|capitalize|replace:' ':'<br/>'}</th>
                        {/foreach}
                    </tr>
                </thead>
                <tbody>
                {foreach from=$depths item=depth}
                <tr class="{cycle values='odd,even'}">
                    <td class="depth">{$depth}</td>
                    {foreach from=$field_names item=fc}
                    <td>{$project_data.$depth.$fc}</td>
                    {/foreach}
                </tr>
                {/foreach}
                </tbody>
            </table>
            If you see any discrepancy in data, please fix the CSV file and re-upload using the "List Project" menu.
            {/if}
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
         
       /*oTable = $('#list-projects').dataTable({
		"bJQueryUI": true,
        "bProcessing": true,
        "bServerSide" : true,
        "bPaginate": false,
        "bFilter": false,
		"sAjaxSource": '/project/json-list-projects',
		"sPaginationType": "full_numbers"
        }); */
        $("#upload").jqUploader({
            debug: 0,
			background:           "FFFFDF",
			barColor:             "FFDD00",
            allowedExt: "*.xls; *.xlsx; *.csv; *.txt",
			params: {quality:'low', menu: true},
			allowedExtDescr:      "what you want",
			validFileMessage:     'Click on Upload!',
			endMessage:           'and don\'t you come back ;)',
			hideSubmit:           true,
			endHtml:             '<strong style="text-decoration:underline">Upload finished!(the filename is now stored in the form as an hidden input field)</strong>'
        });
      
 });
    
</script>

{/literal}