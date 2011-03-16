{literal}

<script>
 $(function() {
		$( "button, input:submit, a", ".create" ).button();
		$( "a", ".create" ).click(function() { return false; });
	});
</script>

<style type="text/css">
    p{
        margin:0;
        padding:0;
    }
    form label{
        //display:block;
        padding:0;
        width:140px;
        //border:1px solid red;
    } 
    .field
    {
        //float:left;
        //border:1px solid red;
    } 
    .dialog{
        margin:5px;  
    }
    .input_block{
        overflow: hidden;
        line-height:1.4em;
    }
    .login_error{
        color:#006699;
        font-size:0.5em;
        font-weight:normal;
    } 
.r15{
        border-radius: 15px 15px 15px 15px;
        -moz-border-radius-topleft: 15px;
        -moz-border-radius-topright: 15px;
        -moz-border-radius-bottomleft: 15px;
        -moz-border-radius-bottomright: 15px;
        -webkit-border-top-left-radius: 15px;
        -webkit-border-top-right-radius: 15px;
        -webkit-border-bottom-left-radius: 15px;
        -webkit-border-bottom-right-radius: 15px;
}
</style>
{/literal}

    <div style="textwidth:385px; border:1px solid #666; background-color:#cccccc;margin:20px auto 0 auto" class="r15">
        <form action="{url_for controller="user" action="login"}" method="post">
        <input type="hidden" name="txn_id" value="{$txn_id}" />
        <input type="hidden" name="redir" value="{$redir}" />
        <div style="margin:0 0 10px 5px;color:#000000">
            <b>Login</b> {if $login_error == true}<span class="login_error">(The email or password is incorrect.)</span>{/if}
        </div>
        <div>
            <label>Email:</label>
            <div class="field">{form_field for='user' prop='email' attr.size='24' attr.maxlength="256"}</div>
            <div class="field">{errors for='user' prop='email'}</div>

        </div>
        <div>
            <label>Password:</label>
            <div class="field">{form_field type='password' for='user' prop='password' attr.size="24" attr.autocomplete="off" attr.maxlength="21"}</div>
            <div class="field">{errors for='user' prop='password'}</div>
        </div>
        <p>
        <div>
            <input class="button white" value="login" type="submit">
        </div>
        </p>
        </form>
    </div>



