<form class="form-inline" action="" method="get" id="filter">
    <?php if (isset($this->search)): ?>
        <div class="form-group">
            <input name="search" class="form-control input-sm" type="text" placeholder="Ara" value="<?php echo $this->input->get('search') ?>" />
        </div>
    <?php endif; ?>
    <?php if (isset($this->search) || isset($this->filter)): ?>
        <div class="form-group">
            <button class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
        </div>
    <?php endif; ?>
</form>
