{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("directors/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("directors/new", "Create directors") }}
    </li>
</ul>

{% for director in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ director.id }}</td>
        <td>{{ director.name }}</td>
        <td width="7%">{{ link_to("directors/edit/" ~ director.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("directors/delete/" ~ director.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="7" align="right">
            <div class="btn-group">
                {{ link_to("directors/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                {{ link_to("directors/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                {{ link_to("directors/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                {{ link_to("directors/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
            </div>
        </td>
    </tr>
    <tbody>
</table>
{% endif %}
{% else %}
No directors are recorded
{% endfor %}
