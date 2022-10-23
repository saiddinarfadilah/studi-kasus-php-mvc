<div class="container">
    <div class="card text-center">
        <div class="row mb-3 mt-5">
            <h1>Dashboard</h1>
        </div>
        <div class="card-body">
            <h5 class="card-title">Hello <?= $model["user"]["name"];?></h5>
            <p class="card-text"></p>
            <a href="/users/logout" class="btn btn-primary">Logout</a>
            <a href="/users/profile" class="btn btn-primary">Update Profile</a>
            <a href="/users/password" class="btn btn-primary">Update Password</a>
        </div>
    </div>
</div>