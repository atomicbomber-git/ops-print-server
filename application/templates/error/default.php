<?php ?>

<?php $this->layout('shared/base', ['title' => "Error {$status}"]) ?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 class="text-danger"> Error <?= $status ?> </h1>
            <p class="lead">
                <?= $message ?>
            </p>
        </div>
    </div>
</div>
