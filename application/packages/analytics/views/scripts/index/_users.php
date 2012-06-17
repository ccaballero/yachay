<div id="table" class="chart table"></div>
<div id="column" class="chart column"></div>
<div id="pie1" class="chart pie"></div>
<div id="pie2" class="chart pie"></div>

<script type='text/javascript'>
    google.load('visualization', '1.0', {packages:['table','corechart']});

    google.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Rol');
        data.addColumn('number', 'Registrados');
        data.addColumn('number', 'Logeados');
        data.addColumn('number', 'Correo electronico');
        data.addColumn('number', 'Nombre de usuario');

        data.addRows(<?php echo count($this->stat) ?>);

    <?php foreach ($this->stat as $count => $stat) { ?>
        data.setCell(<?php echo $count ?>, 0, '<?php echo $stat['role'] ?>');
        data.setCell(<?php echo $count ?>, 1, <?php echo intval($stat['total']) ?>, '<?php echo intval($stat['total']) ?>');
        data.setCell(<?php echo $count ?>, 2, <?php echo intval($stat['logged']) ?>, '<?php echo intval($stat['logged']) ?>');
        data.setCell(<?php echo $count ?>, 3, <?php echo intval($stat['email']) ?>, '<?php echo intval($stat['email']) ?>');
        data.setCell(<?php echo $count ?>, 4, <?php echo intval($stat['username']) ?>, '<?php echo intval($stat['username']) ?>');
    <?php } ?>

        var view1 = new google.visualization.DataView(data);
        var table = new google.visualization.Table(document.getElementById('table'));
        table.draw(view1, {width: 680, showRowNumber: true});

        var view2 = new google.visualization.DataView(data);
        var chart = new google.visualization.ColumnChart(document.getElementById('column'));
        chart.draw(view2, {width: 680, height: 480,
            title: 'Intención de los usuarios por rol definido',
            titlePosition: 'out',
            titleTextStyle: {color: '<?php echo $this->fg ?>'},
            backgroundColor: {stroke: '<?php echo $this->fg ?>', strokeWidth: '2', fill: '<?php echo $this->bg ?>'},
            hAxis: {title: 'Roles definidos', titleTextStyle: {color: '<?php echo $this->fg ?>', fill:'<?php echo $this->fg ?>'}, textStyle:{color: '<?php echo $this->fg ?>'}},
            vAxis: {title: 'Cantidad de usuarios', titleTextStyle: {color: '<?php echo $this->fg ?>'}, gridlineColor: '<?php echo $this->fg ?>', baselineColor: '<?php echo $this->fg ?>'},
            vAxes: [{textStyle:{color: '<?php echo $this->fg ?>'}}],
            legendTextStyle: {color: '<?php echo $this->fg ?>'}
        });

        var view3 = new google.visualization.DataView(data);
        view3.setColumns([0, 1]);
        var chart = new google.visualization.PieChart(document.getElementById('pie1'));
        chart.draw(view3, {width: 340, height: 200, title: 'Usuarios registrados'});
        
        var view4 = new google.visualization.DataView(data);
        view4.setColumns([0, 2]);
        var chart = new google.visualization.PieChart(document.getElementById('pie2'));
        chart.draw(view4, {width: 340, height: 200, title: 'Usuarios que ingresaron al sistema por lo menos una vez'});
    });
</script>
