<div class="container">
    <?php if (isset($model["error"])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model["error"] ?>
            </div>
        </div>
    <?php } ?>
    <form method="post" action="/users/password">
        <div class="row mb-3 mt-5">
            <h1>Update Password</h1>
        </div>
        <div class="row mb-3 mt-5">
            <label for="inputEmail3" class="col-md-2 col-form-label">Id</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="inputEmail3" name="id" disabled value="<?= $model["user"]["id"] ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword" class="col-md-2 col-form-label">Old Password</label>
            <div class="col-md-4">
                <input type="password" class="form-control" id="inputPassword" name="oldPassword">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword" class="col-md-2 col-form-label">New Password</label>
            <div class="col-md-4">
                <input type="password" class="form-control" id="inputPassword" name="newPassword">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>