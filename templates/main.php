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

    <div>
        <p>Partial Test</p>
            <?php $this->partial('block_3')?>
    </div>
</div>
