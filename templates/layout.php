        {% partial '_header' %}
        {% partial 'content' %}

		<section id="fh5co-features">
				<div class="row">
                    {% partial 'block_1' %}
                    {% partial 'block_2' %}
                    {% partial 'block_3', ['name' => 'Example', 'age' => 155, 'position' => 'developer'] %}
                    {% partial 'block_3', ['age', 'position'] %}
					<div class="clearfix visible-sm-block"></div>
				</div>

		</section>	

        {% partial '_footer' %}