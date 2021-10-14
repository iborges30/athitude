<tr id="<?= $i->id; ?>">
    <th scope="row"><?= $i->id; ?></th>
    <td><?= $i->size; ?></td>
    <td class="text-white">
        <span class="btn btn-circle  shadow" style="background: <?= $i->color; ;?>"></span>
    </td>
    <td><?= $i->amount; ?></td>
    <td>
        <a href="<?=url("/admin/inventory/edit");?>"
           data-inventory-edit="<?= $i->id; ?>"
           class="btn btn-primary btn-circle btn-sm jsc-inventory-edit">
            <i class="fas fa-edit"></i>
        </a>
        <a href="<?=url("/admin/inventory/delete");?>" data-delete-id="<?= $i->id; ?>" class="jsc-delete-inventory btn btn-danger btn-circle btn-sm">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
