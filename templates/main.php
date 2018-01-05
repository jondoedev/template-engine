<div class="col-md-4 col-sm-6 col-xs-12 animate-box">
    <div class="fh5co-feature">
        <div class="fh5co-icon">
            <i class="icon-flag2"></i>
        </div>
        <h3>List</h3>
        <p><?= $this->listParse([
                'Country' => 'Ukraine',
                'City' => 'Kharkiv']) ?></p>
    </div>

    <?php $this->partial('block_1', ["name" => "qwe", "block_3_title" => "", "last_name" => '', 'age' => '', 'position' => '', 'company' => '']); ?>
    <?php $this->partial('block_3'); ?>
    <?php $this->partial('block_3'); ?>
    <?php $this->partial('block_3', ["name" => "qwe", "block_3_title" => "", "last_name" => '', 'age' => '', 'position' => '', 'company' => ''] ); ?>
</div>
