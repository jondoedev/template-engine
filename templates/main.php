<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{pageTitle}</title>
</head>
<body>

<div class="content">
    <b>Today is:</b> <?= $this->currentDate() ?><br>
    <ul>
        <?= $this->listParse([
                'Country' => 'Ukraine',
                'City' => 'Kharkiv']) ?>
    </ul>

{% partial 'content' %}

{% partial 'content', ['name' => 'Ololo'] %}


</div>
</body>
</html>
