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
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-header"></i></div>
            <input type="text" id="form_title" name="title" required="required" class="form-control" placeholder="Заглавие" value="<?=set_value("title")?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-folder-open"></i></div>
            <select name="category" id="form_category" class="form-control">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?=$category['id']?>"<?=($this->input->post("category") == $category['id']) ? ' selected="selected"' : ''?>><?=$category['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <textarea id="form_description_new" name="description" required="required" rows="15" class="form-control" placeholder="Съдържание"><?=set_value("description")?></textarea>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-tags"></i></div>
            <input type="text" id="form_tags" name="tags" class="form-control" placeholder="Тагове разделени със запетаи" value="<?=set_value("tags")?>" />
        </div>
    </div>

    <div><button type="submit" id="form_save" name="post" class="btn btn-primary">Публикувай</button></div>
    <?=form_close()?>
</section>
