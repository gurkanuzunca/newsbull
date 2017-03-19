<form class="form-inline" action="" method="get" id="filter" accept-charset="utf-8">
    <?php if (! empty($this->search)): ?>
        <div class="form-group">
            <input name="search" class="form-control input-sm" type="text" placeholder="Ara" value="<?php echo $this->input->get('search') ?>" />
        </div>
    <?php endif; ?>
    <?php if (! empty($this->search) || ! empty($this->filter)): ?>
        <div class="form-group">
            <button class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
        </div>
    <?php endif; ?>
</form>
