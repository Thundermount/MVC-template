<div class="row pt-2">
<div class="card col-6 mx-auto">
<img src=<?php echo $user['avatar'];?> class="img-thumbnail img-fluid w-50">
<div class="card-body">
<h4 class="card-title"><?php echo $user['login']; ?></h4>
<h5 id="name" class="card-subtitle mb-2 text-muted" type="text" data-text="Имя"><?php echo htmlspecialchars($user['name']); ?></h5>
<div id="about" class="card-text pre" type="text" data-text="О себе"><?php echo htmlspecialchars($user['about']); ?></div>
<textarea class="form-control" id="about-edit" rows="3" style="display: none"></textarea>
</div>
</div>
</div>
