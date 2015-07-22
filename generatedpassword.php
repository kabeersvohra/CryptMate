<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form">
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Generated Password</label>
            <div class="col-sm-12">
                <input type="text" name="password" class="form-control" id="password" readonly name="password" style="text-align: center;" value="<?php echo $_SESSION["generatedpassword"] ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                <button onclick="clipBoard()" class="btn btn-default">Copy to Clipboard</button>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $("input:text").focus(function() { $(this).select(); } );
});

function ClipBoard()
{
    //todo
}
</script>