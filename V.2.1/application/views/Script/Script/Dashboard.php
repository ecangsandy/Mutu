<script src="<?= base_url('assets') ?>/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/morris.js/morris.min.js"></script>
<script>
  $(document).ready(function() {
    var option_chart = {
      element: 'area-chart-area',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['orange', '#3c8dbc'],
      hideHover: 'auto',
      parseTime: false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function(index, options, content, row) {
        return row.n + "<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }

    }
    var option_chart_klinik = {
      element: 'area-chart-klinik',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['green', '#3c8dbc'],
      hideHover: 'auto',
      parseTime: false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function(index, options, content, row) {
        return row.n + "<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }

    }
    var option_chart_pasien = {
      element: 'area-chart-pasien',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['green', '#3c8dbc'],
      hideHover: 'auto',
      parseTime: false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function(index, options, content, row) {
        return row.n + "<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }

    }
    var option_chart_unit = {
      element: 'area-chart-unit',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['green', '#3c8dbc'],
      hideHover: 'auto',
      parseTime: false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function(index, options, content, row) {
        return row.n + "<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }

    }
    var Management = Morris.Area(option_chart);
    var Klinik = Morris.Area(option_chart_klinik);
    var Pasien = Morris.Area(option_chart_pasien);
    var Unit = Morris.Area(option_chart_unit);

    $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/3') ?>',
      type: 'POST',
      async: true,
      dataType: "json",
      success: function(data) {
        ind_wajib(data.data);
      }
    });
    $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/1') ?>',
      type: 'POST',
      async: true,
      dataType: "json",
      success: function(data) {
        Management.setData(data.data);
      }
    });
    $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/2') ?>',
      type: 'POST',
      // async: true,
      dataType: "json",
      success: function(data) {
        Klinik.setData(data.data);
      }
    });
    $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/10') ?>',
      type: 'POST',
      // async: true,
      dataType: "json",
      success: function(data) {
        Pasien.setData(data.data);
      }
    });
    $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/11') ?>',
      type: 'POST',
      // async: true,
      dataType: "json",
      success: function(data) {
        Unit.setData(data.data);
      }
    });
    // onclik filter
    $('#cari').click(function() {
      // bln = 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/3') ?>',
        type: 'POST',
        // async: true,
        data: {
          'bulan': bln
        },
        dataType: "json",
        success: function(data) {
          ind_wajib(data.data);
        }
      });
    });
    // onclik filter
    $('#cari').click(function() {
      // bln = 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/1') ?>',
        type: 'POST',
        // async: true,
        data: {
          'bulan': bln
        },
        dataType: "json",
        success: function(data) {
          Management.setData(data.data);
        }
      });
    });
    // onclik filter
    $('#cari').click(function() {
      // bln = 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/2') ?>',
        type: 'POST',
        async: true,
        data: {
          'bulan': bln
        },
        dataType: "json",
        success: function(data) {
          Klinik.setData(data.data);
        }
      });
    });
    $('#cari').click(function() {
      // bln = 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/10') ?>',
        type: 'POST',
        async: true,
        data: {
          'bulan': bln
        },
        dataType: "json",
        success: function(data) {
          Pasien.setData(data.data);
        }
      });
    });
    $('#cari').click(function() {
      // bln = 
      bln = $('#bulan').val();
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/11') ?>',
        type: 'POST',
        async: true,
        data: {
          'bulan': bln
        },
        dataType: "json",
        success: function(data) {
          Unit.setData(data.data);
        }
      });
    });
  });

  function ind_wajib(response) {
    Morris.Area({
      element: 'area-chart',
      resize: false,
      data: response,
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['red', '#3c8dbc'],
      hideHover: 'auto',
      smooth: true,
      parseTime: true,
      parseTime: false,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      hoverCallback: function(index, options, content, row) {
        return row.n + "<br> Target:" + row.a + "<br>Hasil: " + row.b;
      }
    });
  }

  function ind_management(data) {

  }
</script>