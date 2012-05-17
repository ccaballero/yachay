<div id="line1" class="chart line"></div>

<script type='text/javascript'>
    google.load('visualization', '1.0', {packages:['corechart']});

    google.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha');
        data.addColumn('number', 'Usuarios');
        data.addColumn('number', 'Contactos');
        data.addColumn('number', 'Recursos');
        data.addColumn('number', 'Espacios');

        data.addRows(<?php echo count($this->stat) ?>);

    <?php $count = 0 ?>

    <?php $us = 0 ?>
    <?php $co = 0 ?>
    <?php $re = 0 ?>
    <?php $sp = 0 ?>
    <?php foreach ($this->stat as $date => $stat) { ?>
        <?php list($y, $m, $d) = @split('-', $date) ?>
        data.setCell(<?php echo $count ?>, 0, new Date(<?php echo intval($y) . ',' . (intval($m) - 1) . ',' . intval($d) ?>));

        <?php $us += isset($stat['users']) ? $stat['users'] : 0 ?>
        <?php $co += isset($stat['contacts']) ? $stat['contacts'] : 0 ?>
        <?php $re += isset($stat['resources']) ? $stat['resources'] : 0 ?>
        <?php $sp += isset($stat['spaces']) ? $stat['spaces'] : 0 ?>

        data.setCell(<?php echo $count ?>, 1, <?php echo $us ?>, '<?php echo $us ?>');
        data.setCell(<?php echo $count ?>, 2, <?php echo $co ?>, '<?php echo $co ?>');
        data.setCell(<?php echo $count ?>, 3, <?php echo $re ?>, '<?php echo $re ?>');
        data.setCell(<?php echo $count++ ?>, 4, <?php echo $sp ?>, '<?php echo $sp ?>');
    <?php } ?>

        var view1 = new google.visualization.DataView(data);
        view1.setColumns([0,1,2,3,4]);
        var chart = new google.visualization.AreaChart(document.getElementById('line1'));
        chart.draw(view1, {width:680, height:350,
            titleTextStyle: {color: '<?php echo $this->fg ?>'},
            backgroundColor: {stroke: '<?php echo $this->fg ?>', strokeWidth: '2', fill: '<?php echo $this->bg ?>'},
            hAxis: {textPosition:'out', slantedTextAngle:90},
            vAxis: {gridlineColor: '<?php echo $this->fg ?>', baselineColor: '<?php echo $this->fg ?>', minValue:0},
            vAxes: [{textStyle:{color: '<?php echo $this->fg ?>'}}],
            legend: 'in',
            chartArea: {left:10,top:0,width:670,height:320}
        });
    });
</script>
