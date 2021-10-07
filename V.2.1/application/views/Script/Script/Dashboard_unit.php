<script src="<?=base_url('assets')?>/bower_components/raphael/raphael.min.js"></script>
<script src="<?=base_url('assets')?>/bower_components/morris.js/morris.min.js"></script>
<script>
  $(document).ready(function () {
    var Unit_option = {
      element: 'chart_unit',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['orange', '#3c8dbc'],
      hideHover: 'auto',
      parseTime:false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function (index, options, content, row) {
        return  row.n+"<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }

    }
    var Unit_chart = Morris.Area(Unit_option);
    $.ajax({
      type: "GET",
      url: "<?=base_url('Dashboard/Chart_unit')?>",
      // data: "data",
      dataType: "JSON",
      success: function (response) {
        console.log(response.data);
        Unit_chart.setData(response.data);
      }
    });
    $('#cari').click(function () { 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?=base_url('Dashboard/Chart_unit/')?>',
        type: 'POST',
        // async: true,
        data : {'bulan' : bln},
        dataType: "json",
        success: function (data) {
          Unit_chart.setData(data.data);
        }
      });
    });
  });
</script>