<script src="<?php echo base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
	$(document).ready(function() {

		$('.select2').select2();
		var data = [];
		data['bln'] = $('#bulan').val();
		data['thn'] = $('#tahun').val();
		data['kategori'] = '<?= $this->uri->segment(3) ?>';
		if ($('#kd_unit').length) {
			data['kd_unit'] = $('#kd_unit').val();
		}
		var url = $('#tables').data('url');
		var url1 = $('#tables1').data('url');
		console.log(data);


		table = $('#tables').DataTable({
			"serverSide": true,
			"processing": true,
			"ordering": false,
			"ajax": {
				"url": url,
				"data": data,
				"type": "POST"
			},
		});
		table.on('draw', function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
		table1 = $('#tables1').DataTable({
			"processing": true,
			"ordering": false,
			"ajax": {
				"url": url1,
				"data": data,
				"type": "POST"
			},
		});
		table1.on('draw', function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	});

	function daysInMonth(month, year) {
		$.get('<?= base_url('Survei/getDay/') ?>' + month + '/' + year, function(data) {
			return data.day;
		});
	}

	function c() {
		n = "<?php echo cal_days_in_month(CAL_GREGORIAN, 6, 2019) ?>";
		for (i = 1; i < n; i++) {
			console.log(i);

		}
	}

	function gets() {
		$.get("url", data,
			function(data, textStatus, jqXHR) {},
			"dataType"
		);
	}

	function filterdata() {
		bln = $('#bulan').val();
		thn = $('#tahun').val();
		console.log(bln + thn);

		$.get('<?= base_url('Survei/getDay/') ?>' + bln + '/' + thn, function(data) {
			max = data.countday;
			tmonth = '';
			for (i = 1; i <= max; i++) {
				tmonth += "<td>" + i + "</td>";
			}
			nthead = "<tr>" +
				"<th>No</th>" +
				"<th>INDIKATOR</th>" + tmonth +
				"</tr>";
			$('#tables thead').replaceWith(nthead);
		}, "JSON");
		url = '<?= base_url('Survei/get_tables/') ?>' + bln + '/' + thn;
		table.ajax.url(url).load();
	}

	function reload_table() {
		table.ajax.reload(null, false);
		table1.ajax.reload(null, false);
	}

	function detail(id) {
		$('.modal-title detail').text('Detail Data');
		$('#modal-detail').modal({
			backdrop: "static",
			show: true
		});
		$.ajax({
			type: "method",
			url: "<?= base_url('Survei/Detailindikator/') ?>" + id,
			dataType: "JSON",
			success: function(data) {
				$.each(data, function(key, value) {
					$('#' + key).html(value);
				});
			}
		});
	}

	function survei(id, day) {
		$('#form_survei')[0].reset();
		$('.modal-title').text('Tanggal ' + day);
		$('#variable_survei tbody').empty();
		bulan = $('#bulan').val();
		tahun = $('#tahun').val();
		var ndate = (tahun + '-' + bulan + '-' + day);
		$('#tgl_input').val(ndate)
		$('#id_indikator').val(id);
		$('#metode').val('add')

		$('#modal-survei').modal({
			backdrop: "static",
			show: true
		});
		url = '<?= base_url('Survei/getVariable/') ?>' + id;
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				var nemu = "<tr><td>" + data.nemulator_variable + "</td>" +
					"<td contenteditable='true' placeholder='Masukan Nilai Nemulator...' id='nemu'></td>" +
					"<td>" + data.nemulator_satuan + "</td>" +
					"</tr>" +
					"<tr><td>" + data.demulator_variable + "</td>" +
					"<td contenteditable='true' placeholder='Masukan Nilai Demulator...' id='demu'></td>" +
					"<td>" + data.demulator_satuan + "</td>" +
					"</tr>";
				$('#variable_survei tbody').append(nemu);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	function edit_survei(id) {
		$('#form_survei')[0].reset();
		$('#variable_survei tbody').empty();
		$('#metode').val('update')
		$('#id_hasil').val(id)
		$('#modal-survei').modal({
			backdrop: "static",
			show: true
		});
		url = '<?= base_url('Survei/getData/') ?>' + id;
		$.ajax({
			url: url,
			type: "GET",
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

	function All_data(id, i) {
		$('#form_survei')[0].reset();
		$('#variable_survei tbody').empty();
		$('#metode').val('update')
		$('#id_hasil').val(id)
		url = '<?= base_url('Laporan/getDataAll/') ?>' + id + '/' + i;
		data = $('#filter-form').serialize();
		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "JSON",
			success: function(data) {
				$('.modal-title').text(data.judul_indikator);
				$('#modal-survei').modal({
					backdrop: "static",
					show: true
				});
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

	function avg(id, i) {
		$('#form_survei')[0].reset();
		$('#variable_survei tbody').empty();
		$('#metode').val('update')
		$('#id_hasil').val(id)
		url = '<?= base_url('Survei/getByMonth/') ?>' + id + '/' + i;
		data = $('#filter-form').serialize();
		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "JSON",
			success: function(data) {
				$('.modal-title').text(data.judul_indikator);
				$('#modal-survei').modal({
					backdrop: "static",
					show: true
				});
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

	function save_variable() {
		nemu = $('#nemu').html();
		demu = $('#demu').html();
		var url = '<?= base_url('Survei/save') ?>';
		var dataForm = new FormData($('#form_survei')[0]);
		dataForm.append('demulator', demu);
		dataForm.append('nemulator', nemu);
		$.ajax({
			url: url,
			type: "POST",
			data: dataForm,
			dataType: "JSON",
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				if (data.success) {
					new PNotify({
						title: 'Success!',
						text: data.notif,
						type: 'success',
						styling: 'bootstrap3'
					});
					$('#modal-survei').modal('hide');
					reload_table();

				} else if (data.messages) {
					$('#msg').html(data.messages);
					$.each(data.messages, function(key, value) {
						var element = $('#' + key);
						element.closest('div.form-group')
							.removeClass('has-error')
							.addClass(value.length > 0 ? 'has-error' : 'has-success')
							.find('.text-danger')
							.remove();
						element.after(value);
					})
				}
			},
			error: function(ts) {
				alert(ts.responseText);
				console.log(ts.responseText);
			}
		})

	}

	function save() {
		remove_validation();
		var url = $('#form_input').attr('action');
		var dataForm = new FormData($('#form_input')[0]);
		$.ajax({
			url: url,
			type: "POST",
			data: dataForm,
			dataType: "JSON",
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				if (data.success) {
					new PNotify({
						title: 'Success!',
						text: data.notif,
						type: 'success',
						styling: 'bootstrap3'
					});
					$('#modal-id').modal('hide');
					reload_table();

				} else if (data.messages) {
					$('#msg').html(data.messages);
					$.each(data.messages, function(key, value) {
						var element = $('#' + key);
						element.closest('div.form-group')
							.removeClass('has-error')
							.addClass(value.length > 0 ? 'has-error' : 'has-success')
							.find('.text-danger')
							.remove();
						element.after(value);
					})
				}
			},
			error: function(ts) {
				alert(ts.responseText);
				console.log(ts.responseText);
			}
		})
	}

	function saveExcel() {
		var base_uri = "<?= base_url('Lapexcel/excel') ?>";

		var dataForm = new FormData($('#filter-form')[0]);
		var form = $('#filter-form').serialize();
		var param = '?' + form
		$('#filter-form').attr('action', base_uri).submit();
	}

	function caridata() {
		var base_uri = "<?= base_url('Survei/rekapImut/') ?>" + $('#idKat').val();
		var dataForm = new FormData($('#filter-form')[0]);
		var form = $('#filter-form').serialize();
		var param = '?' + form
		$('#filter-form').attr('action', base_uri).submit();
	}
</script>