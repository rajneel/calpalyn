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
    .chart {
        display:block;
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
<script>
    var simpleEncoding =
  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

// This function scales the submitted values so that
// maxVal becomes the highest value.
function simpleEncode(valueArray,maxValue) {
  var chartData = ['s:'];
  for (var i = 0; i < valueArray.length; i++) {
    var currentValue = valueArray[i];
    if (!isNaN(currentValue) && currentValue >= 0) {
    chartData.push(simpleEncoding.charAt(Math.round((simpleEncoding.length-1) *
      currentValue / maxValue)));
    }
      else {
      chartData.push('_');
      }
  }
  return chartData.join('');
}

// Same as simple encoding, but for extended encoding.
var EXTENDED_MAP=
  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.';
var EXTENDED_MAP_LENGTH = EXTENDED_MAP.length;
function extendedEncode(arrVals, maxVal) {
  var chartData = 'e:';

  for(i = 0, len = arrVals.length; i < len; i++) {
    // In case the array vals were translated to strings.
    var numericVal = new Number(arrVals[i]);
    // Scale the value to maxVal.
    var scaledVal = Math.floor(EXTENDED_MAP_LENGTH *
        EXTENDED_MAP_LENGTH * numericVal / maxVal);

    if(scaledVal > (EXTENDED_MAP_LENGTH * EXTENDED_MAP_LENGTH) - 1) {
      chartData += "..";
    } else if (scaledVal < 0) {
      chartData += '__';
    } else {
      // Calculate first and second digits and add them to the output.
      var quotient = Math.floor(scaledVal / EXTENDED_MAP_LENGTH);
      var remainder = scaledVal - EXTENDED_MAP_LENGTH * quotient;
      chartData += EXTENDED_MAP.charAt(quotient) + EXTENDED_MAP.charAt(remainder);
    }
  }

  return chartData;
}
var charted  = new Array(104,106,108,110,112,114,116,118,120,122,130,132,134,138,140,150,160);
//alert(extendedEncode(charted,165));
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
                             <button id='d_button' class='upload-ui' name='d_button'>Re upload</button>
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
            <strong>PROJECT: {$projects_info.project_id.name | capitalize}</strong>
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
            <div class="chart">
                {foreach from=$field_names item=f}
                <img src="http://chart.apis.google.com/chart?chxt=y,x&chg=50,50,-1,-1&chs=300x225&cht=lxy&chco=3D7930&chxr=0,{$chart_data.$f.depth-min},{$chart_data.$f.depth-max}|1,{$chart_data.$f.taxon-min},{$chart_data.$f.taxon-max}&chd=e:{$chart_data.$f.depths},{$chart_data.$f.taxon_values}&chdlp=l&chg=14.3,-1,1,1&chls=1,4,0&chma=|1,1&chm=B,000000,0,0,0"/>
                {/foreach}
            </div>
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

{/literal}