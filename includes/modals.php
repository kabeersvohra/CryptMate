<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteAccountModalLabel">Delete account</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete? For your security, the moment you press delete ALL of your data will be irrevocably deleted from our servers and the only way to start again would be to create a new account.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="deleteAccount('<?php echo $_COOKIE['token']?>')">Delete</button>
            </div>
        </div>
    </div>
</div>