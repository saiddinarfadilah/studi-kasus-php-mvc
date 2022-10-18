<div class="container">
    <?php if (isset($model["error"])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model["error"] ?>
            </div>
        </div>
    <?php } ?>
    <form method="post" action="/users/register">
        <div class="row mb-3 mt-5">
            <h1>Register</h1>
        </div>
        <div class="row mb-3 mt-5">
            <label for="inputId" class="col-md-2 col-form-label">Id</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="inputId" name="id">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputName" class="col-md-2 col-form-label">Username</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="inputName" name="username">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword" class="col-md-2 col-form-label">Password</label>
            <div class="col-md-4">
                <input type="password" class="form-control" id="inputPassword" name="password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>