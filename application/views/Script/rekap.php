<script src="<?php echo base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $(function() {
        $('.selectwo').select2();
        $('#indikator_filter').select2({
            ajax: {
                url: '<?= base_url('Rekap/getIndikator') ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        'jenis': $('#jenis_indikator').val()
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $('#dg').datagrid({
            url: '<?= base_url('Rekap/get_tables/') ?>', //C:\xampp\htdocs\Mutu\assets\easy_ui\treegrid_data3.json
            rownumbers: true,
            showFooter: true,
            idField: 'id',
            treeField: 'region',
            queryParams: {
                bln: function() {
                    return $('#bulan').val()
                },
                thn: function() {
                    return $('#tahun').val()
                },
                layanan: function() {
                    return $('#layanan').val()
                },
                indikator: function() {
                    return $('#indikator_filter').val()
                },

            },
            singleSelect: true,
        });
        $('#filter').click(function(e) {
            e.preventDefault();
            console.log($('#indikator_filter').val());
            $('#dg').datagrid('reload');

        });
        $('#triwulan_table').datagrid({
            url: '<?= base_url('Rekap/get_tables_triwulan/') ?>', //C:\xampp\htdocs\Mutu\assets\easy_ui\treegrid_data3.json
            rownumbers: true,
            showFooter: true,
            idField: 'id',
            treeField: 'region',
            queryParams: {
                bln: function() {
                    return $('#bulan').val()
                },
                thn: function() {
                    return $('#tahun').val()
                },
                layanan: function() {
                    return $('#layanan').val()
                },
                indikator: function() {
                    return $('#indikator_filter').val()
                },

            },
            singleSelect: true,
        });
        $('#filter').click(function(e) {
            e.preventDefault();
            console.log($('#indikator_filter').val());
            $('#triwulan_table').datagrid('reload');

        });

    });

    function survei(id, day) {
        $('#variable_survei tbody').empty();
        url = '<?= base_url('Survei/getVariable/') ?>' + id;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var nemu = "<tr><td>" + data.nemulator_variable + "</td>" +
                    "<td></td>" +
                    "<td>" + data.nemulator_satuan + "</td>" +
                    "</tr>" +
                    "<tr><td>" + data.demulator_variable + "</td>" +
                    "<td></td>" +
                    "<td>" + data.demulator_satuan + "</td>" +
                    "</tr>";
                $('#variable_survei tbody').append(nemu);
                $('#dd').dialog('open').dialog('setTitle', 'Tanggal ' + day);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function survei_view(id) {
        $('#variable_survei tbody').empty();
        url = '<?= base_url('Survei/getData/') ?>' + id;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var nemu = "<tr><td>" + data.nemulator_variable + "</td>" +
                    "<td contenteditable='false' placeholder='Masukan Nilai Nemulator...' id='nemu'>" + data.value_nemulator + "</td>" +
                    "<td>" + data.nemulator_satuan + "</td>" +
                    "</tr>" +
                    "<tr><td>" + data.demulator_variable + "</td>" +
                    "<td contenteditable='false' placeholder='Masukan Nilai Demulator...' id='demu'>" + data.value_demulator + "</td>" +
                    "<td>" + data.demulator_satuan + "</td>" +
                    "</tr>";
                $('#variable_survei tbody').append(nemu);
                $('#dd').dialog('open').dialog('setTitle', 'Detail');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>