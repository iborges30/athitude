<?php foreach ($colors as $p): ?>
    <li data-color="<?= $p->color; ?>" data-color-id="<?= $p->id; ?>" style="background:<?= $p->color; ?>" class="jsc-color-selected">
        <div class="check-active active-color" id="color-<?= $p->id; ?>">
            <i class="far fa-check-circle"></i>
        </div>
    </li>
<?php endforeach; ?>