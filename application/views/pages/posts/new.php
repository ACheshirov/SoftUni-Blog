<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h3>Публикуване на статия</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?=$error?></div>
    <?php endif; ?>

    <?=form_open()?>
    <div class="form-group">
        <label for="form_title" class="required">Заглавие</label>
        <input type="text" id="form_title" name="title" required="required" class="form-control" placeholder="Заглавие" value="<?=set_value("title")?>" />
    </div>

    <div class="form-group">
        <label for="form_category" class="required">Категория</label>
        <select name="category" id="form_category" class="form-control">
            <?php foreach ($categories as $category) : ?>
                <option value="<?=$category['id']?>"<?=($this->input->post("category") == $category['id']) ? ' selected="selected"' : ''?>><?=$category['name']?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="form_description" class="required">Съдържание</label>
        <textarea id="form_description" name="description" required="required" rows="15" class="form-control" placeholder="Съдържание"><?=set_value("description")?></textarea>
    </div>

    <div class="form-group">
        <label for="form_tags" class="required">Тагове (разделени със запетая)</label>
        <input type="text" id="form_tags" name="tags" class="form-control" placeholder="Тагове" value="<?=set_value("tags")?>" />
    </div>

    <div><button type="submit" id="form_save" name="post" class="btn btn-primary">Публикувай</button></div>
    <?=form_close()?>
</section>
