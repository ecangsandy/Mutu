<script src="<?= base_url('assets') ?>/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/morris.js/morris.min.js"></script>
<script>
  // $(document).on({
  //   ajaxStart: function() {
  //     $("body").addClass("loading");
  //   },
  //   ajaxStop: function() {
  //     $("body").removeClass("loading");
  //   }
  // });
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

    var ajax1 = $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/3') ?>',
      type: 'POST',
      async: true,
      dataType: "json",
      success: function(data) {
        ind_wajib(data.data);
      }
    });
    var ajax2 = $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/1') ?>',
      type: 'POST',
      async: true,
      dataType: "json",
      success: function(data) {
        Management.setData(data.data);
      }
    });
    var ajax3 = $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/2') ?>',
      type: 'POST',
      // async: true,
      dataType: "json",
      success: function(data) {
        Klinik.setData(data.data);
      }
    });
    var ajax4 = $.ajax({
      url: '<?= base_url('Dashboard/get_cart_survei/10') ?>',
      type: 'POST',
      // async: true,
      dataType: "json",
      success: function(data) {
        Pasien.setData(data.data);
      }
    });
    var ajax5 = $.ajax({
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
      $.ajax({
        url: '<?= base_url('Dashboard/get_cart_survei/3') ?>',
        type: 'POST',
        // async: true,
        data: {
          'bulan': function() {
            return $('#bulan').val()
          },
          'tahun': function() {
            return $('#tahun').val()
          }
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
    $('.sidebar-menu li').click(function() {
      // console.log('s');
      ajax1.abort();
      ajax2.abort();
      ajax3.abort();
      ajax4.abort();
      ajax5.abort();
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