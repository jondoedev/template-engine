<div class="col-md-4 col-sm-6 col-xs-12 animate-box">
    <div class="fh5co-feature">
        <div class="fh5co-icon">
            <i class="icon-flag2"></i>
        </div>
        <h3>Today is:</b> { currentDate() }</h3>
        <ul>
            <?= $this->listParse([
                'Country' => 'Ukraine',
                'City' => 'Kharkiv']) ?>
        </ul>
    </div>
</div>