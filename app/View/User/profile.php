<div class="container">
    <?php if (isset($model["error"])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model["error"] ?>
            </div>
        </div>
    <?php } ?>
        <form method="post" action="/users/profile">
            <div class="row mb-3 mt-5">
                <h1>Update Profile</h1>
            </div>
            <div class="row mb-3 mt-5">
                <label for="inputEmail3" class="col-md-2 col-form-label">Id</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="inputEmail3" name="id" disabled value="<?= $model["user"]["id"] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputName" class="col-md-2 col-form-label">Username</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="inputName" name="username" value="<?= $model["user"]["name"] ?>" >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
</div>
