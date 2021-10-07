<script src="<?php echo base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/morris.js/morris.min.js"></script>
<script>
  $('#kd_unit').change(function() {
    $('#kd_indikator').val(null).trigger('change');
    $('#kd_indikator').select2({
      ajax: {
        url: $('#kd_unit').data('url') + '/' + $('#kd_unit').val(),
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
      }
    });
  });
  var lastday = function(y, m) {
    return new Date(y, m, 0).getDate();
  }
  $('#cari-btn').click(function(e) {
    e.preventDefault();
    table.clear();
    bln = $('#bulan').val();
    thn = $('#tahun').val();
    var myTable = jQuery("#tables");
    var thead = myTable.find("thead");
    var thRows = myTable.find("tr:has(th)");
    console.log(lastday(thn, bln));
    // <?php $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $tahun) ?>
    var tbbody = $("#tables").find("tbody");
    cal = '';
    maxs = lastday(thn, bln);
    for (i = 1; i <= maxs; i++) {
      cal += "<th>" + i + "</th>";
    }
    console.log(maxs);
    thead1 = "<thead><tr><th>No</th><th width='30%'>INDIKATOR</th>" + cal + "</tr></thead>";
    if (thead.length === 0) { //if there is no thead element, add one.
      thead = jQuery(thead1).appendTo(myTable);
    }
    table.draw();
    table.ajax.reload(null, false)
  });
  $(document).ready(function() {
    $('.select2').select2();
    var data = [];
    data['bln'] = $('#bulan').val();
    data['thn'] = $('#tahun').val();
    if ($('#kd_unit').length) {
      data['kd_unit'] = $('#kd_unit').val();
    }
    if ($('#kd_indikator').length) {
      data['kd_indikator'] = $('#kd_indikator').val();
    }
    var url = $('#tables').data('url');
    table = $('#tables').DataTable({
      "processing": true,
      "ordering": false,
      "ajax": {
        "url": url,
        "data": function(d) {
          d.bln = $('#bulan').val();
          d.thn = $('#tahun').val();
          d.kd_unit = $('#kd_unit').val();
          d.kd_indikator = $('#kd_indikator').val();
        },
        "type": "POST"
      },
    });

    var Unit_option = {
      element: 'chart_unit',
      resize: true,
      data: [],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Target', 'Hasil'],
      lineColors: ['#f9bc06', '#3c8dbc'],
      xlablels: 'day',
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

    var Unit_chart = Morris.Area(Unit_option);

    $('#cari-btn').click(function() {
      bln = $('#bulan').val();
      tahun = $('#tahun').val();
      kd_unit = $('#kd_unit').val();
      kd_indikator = $('#kd_indikator').val();
      $.ajax({
        url: '<?= base_url('Laporan/Chart_unit/') ?>',
        type: 'POST',
        // async: true,
        data: {
          'bulan': bln,
          'kd_unit': kd_unit,
          'tahun': tahun,
          'kd_indikator': kd_indikator
        },
        dataType: "json",
        success: function(data) {
          Unit_chart.setData(data.data);
        }
      });
    });
  });

  function All_data(id, i, unit) {
    data = $('#filter-form').serialize();
    $('#form_survei')[0].reset();
    $('#variable_survei tbody').empty();
    $('#metode').val('update')
    $('#id_hasil').val(id)
    $('#modal-survei').modal({
      backdrop: "static",
      show: true
    });
    url = '<?= base_url('Laporan/getDataAll/') ?>' + id + '/' + i;
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      dataType: "JSON",
      success: function(data) {
        var nemu = "<tr><td>" + data.nemulator_variable + "</td>" +
          "<td contenteditable='true' placeholder='Masukan Nilai Nemulator...' id='nemu'>" + data.value_nemulator + "</td>" +
          "<td>" + data.nemulator_satuan + "</td>" +
          "</tr>" +
          "<tr><td>" + data.demulator_variable + "</td>" +
          "<td contenteditable='true' placeholder='Masukan Nilai Demulator...' id='demu'>" + data.value_demulator + "</td>" +
          "<td>" + data.demulator_satuan + "</td>" +
          "</tr>";
        $('#variable_survei tbody').append(nemu);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }
</script>