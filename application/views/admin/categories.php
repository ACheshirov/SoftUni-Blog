<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h4><?=$this->lang->line('panel_categories')?></h4>

    <?php if (count($categories)) : ?>
        <table style="width: 99%; margin-bottom: 15px;">
            <thead>
                <tr>
                    <th style="width: 70%;"><?=$this->lang->line('tableCategoryName')?>:</th>
                    <th><?=$this->lang->line('tableCategoryOptions')?>:</th>
                </tr>
            </thead>
            <tbody id="categoriesTbody">
                <?php foreach ($categories as $category) : ?>
                    <tr id="categoryId_<?=$category['id']?>">
                        <td><?=$category['name']?></td>
                        <td>
                            [<a href="#" data-type="edit">Редактирай</a>]
                            [<a href="#" data-type="delete">Изтрий</a>]
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div>
        <button onclick="Categories.add()" name="approve" class="btn btn-primary"><?=$this->lang->line('categoryAddButton')?></button>
    </div>
</section>