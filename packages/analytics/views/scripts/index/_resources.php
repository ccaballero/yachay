<div id="table" class="chart table"></div>
<div id="column" class="chart column"></div>
<div id="pie1" class="chart pie"></div>
<div id="pie2" class="chart pie"></div>
<div id="pie3" class="chart pie"></div>
<div id="pie4" class="chart pie"></div>

<script type='text/javascript'>
    google.load('visualization', '1.0', {packages:['table','corechart']});

    google.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Tipo');
        data.addColumn('number', 'Cantidad');
        data.addColumn('number', 'Audiencia');
        data.addColumn('number', 'Comentarios');
        data.addColumn('number', 'Calificadores');
        data.addColumn('number', 'Etiquetas');

        data.addRows(<?php echo count($this->stat) ?>);

    <?php foreach ($this->stat as $count => $stat) { ?>
        data.setCell(<?php echo $count ?>, 0, '<?php echo $stat['type'] ?>');
        data.setCell(<?php echo $count ?>, 1, <?php echo intval($stat['count']) ?>, '<?php echo intval($stat['count']) ?>');
        data.setCell(<?php echo $count ?>, 2, <?php echo intval($stat['viewers']) ?>, '<?php echo intval($stat['viewers']) ?>');
        data.setCell(<?php echo $count ?>, 3, <?php echo intval($stat['comments']) ?>, '<?php echo intval($stat['comments']) ?>');
        data.setCell(<?php echo $count ?>, 4, <?php echo intval($stat['raters']) ?>, '<?php echo intval($stat['raters']) ?>');
        data.setCell(<?php echo $count ?>, 5, <?php echo intval($stat['tags']) ?>, '<?php echo intval($stat['tags']) ?>');
    <?php } ?>

        var view1 = new google.visualization.DataView(data);
        var table = new google.visualization.Table(document.getElementById('table'));
        table.draw(view1, {width: 680, showRowNumber: true});

        var view2 = new google.visualization.DataView(data);
        var chart = new google.visualization.ColumnChart(document.getElementById('column'));
        chart.draw(view2, {width: 680, height: 480,
            title: 'Cantidad de recursos publicados por tipo de recurso',
            titlePosition: 'out',
            titleTextStyle: {color: '<?php echo $this->fg ?>'},
            backgroundColor: {stroke: '<?php echo $this->fg ?>', strokeWidth: '2', fill: '<?php echo $this->bg ?>'},
            hAxis: {title: 'Espacios definidos', titleTextStyle: {color: '<?php echo $this->fg ?>', fill:'<?php echo $this->fg ?>'}, textStyle:{color: '<?php echo $this->fg ?>'}},
            vAxis: {title: 'Unidades', titleTextStyle: {color: '<?php echo $this->fg ?>'}, gridlineColor: '<?php echo $this->fg ?>', baselineColor: '<?php echo $this->fg ?>'},
            vAxes: [{textStyle:{color: '<?php echo $this->fg ?>'}}],
            legendTextStyle: {color: '<?php echo $this->fg ?>'}
        });

        var view3 = new google.visualization.DataView(data);
        view3.setColumns([0, 1]);
        var chart = new google.visualization.PieChart(document.getElementById('pie1'));
        chart.draw(view3, {width: 340, height: 200, title: 'Distribución de los recursos según su tipo'});
        
        var view4 = new google.visualization.DataView(data);
        view4.setColumns([0, 2]);
        var chart = new google.visualization.PieChart(document.getElementById('pie2'));
        chart.draw(view4, {width: 340, height: 200, title: 'Distribución de los audiencia por tipo de recurso'});

        var view5 = new google.visualization.DataView(data);
        view5.setColumns([0, 3]);
        var chart = new google.visualization.PieChart(document.getElementById('pie3'));
        chart.draw(view5, {width: 340, height: 200, title: 'Distribución de los comentarios por tipo de recurso'});

        var view6 = new google.visualization.DataView(data);
        view6.setColumns([0, 4]);
        var chart = new google.visualization.PieChart(document.getElementById('pie4'));
        chart.draw(view6, {width: 340, height: 200, title: 'Distribución de los calificadores por tipo de recurso'});
    });
</script>
