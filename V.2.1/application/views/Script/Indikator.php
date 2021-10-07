<script src="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>

<script>
	$(document).ready(function() {
		$('.select2').select2();
		$('.textarea').summernote({
			height: 200,
			minHeight: null,
			maxHeight: null,
			focus: true
		});
		var url = '<?= base_url('Indikator/get_tables') ?>';
		table = $('#tables').DataTable({
			dom: 'Bfrtip',
			scrollY: "600px",
			scrollX: true,
			"processing": true,
			"ajax": {
				"url": url,
				"type": "POST"
			},
			fixedColumns: {
				rightColumns: 1
			}
		});
	});

	function add() {
		remove_validation();
		$('#form_input')[0].reset();
		$('.modal-title').text('Tambah Data');
		$('#modal-id').modal({
			backdrop: "static",
			show: true
		});
		$('#metode').val('add');

	}

	function remove_validation() {
		$('p.text-danger').remove();
		$('div.has-error').removeClass('has-error');
		$('div.has-success').removeClass('has-success');
	}

	function save() {
		var url = $('#form_input').attr('action');
		var t = $('#area').val();

		var dataForm = new FormData($('#form_input')[0]);
		dataForm.append('areas', t);
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

	function reload_table() {
		table.ajax.reload(null, false);
	}

	function variable(id) {
		remove_validation();
		$('#form_input')[0].reset();
		$('.modal-title').text('Data Variable');
		$('#modal-variable').modal({
			backdrop: "static",
			show: true
		});
		$('#id_indikator_v').val(id);
	}

	$('#jenisselect').change(function() {
		val = $(this).val();
		url = $(this).data('url') + val;
		console.log(url);

		table.ajax.url(url).load();

	});
	$("#tables tbody").on("click", "#edit", function() {
		remove_validation();
		$('#form_input')[0].reset();
		$('.modal-title').text('Edit Data Indikator');
		$('#modal-id').modal({
			backdrop: "static",
			show: true
		});
		$('#metode').val('update');
		var url = $(this).data('url');
		console.log(url)
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$.each(data, function(key, value) {
					$('#' + key).val(value);
				});
				$('#deskripsi').summernote('code', data.deskripsi);
				$('#inklusi').summernote('code', data.inklusi);
				$('#eklusi').summernote('code', data.eklusi);
				$('#kategoriindikator').val(data.kategoriindikator).trigger("change");
				$('#tipeindikator').val(data.tipeindikator).trigger("change");
				var values = data.area;
				$.each(values.split(","), function(i, e) {
					$("#area option[value='" + e + "']").prop("selected", true)
						.trigger("change");
				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});

	});

	$("#tables tbody").on("click", "#isi_variable", function() {
		remove_validation();
		$('#form_variable')[0].reset();
		$('.modal-title').text('Edit Data Variable');
		$('#modal-variable').modal({
			backdrop: "static",
			show: true
		});
		$('#metode').val('update');
		var url = $(this).data('url');
		console.log(url)
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$.each(data, function(key, value) {
					$('#' + key).val(value);
				});

			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});

	});

	function save_variable() {

		var url = $('#form_variable').attr('action');
		var dataForm = new FormData($('#form_variable')[0]);

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
					$('#modal-variable').modal('hide');
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

	$("#tables tbody").on("click", "#viewDef", function() {
		id_indi = $("#id_indikator").val();
		$('.modal-title').text('Detail Data');
		$('#modal-definsi').modal({
			backdrop: "static",
			show: true
		});
		$('#metode').val('update');
		var url = $(this).data('url');
		console.log(url)
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$.each(data, function(key, value) {
					$('#' + key).html(value);

				});
				$('#dettail_definisi').html(data.deskripsi);
				$('#detail_Inklusi').html(data.inklusi);
				$('#detail_eklusi').html(data.eklusi);
			}
		});


	});


	function delet() {
		var url = $('#form_del').attr('action');
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				if (data.success) {
					new PNotify({
						title: 'Success!',
						text: data.notif,
						type: 'success',
						styling: 'bootstrap3'
					});
					$('#modal-del').modal('hide');
					reload_table();

				}
			},
			error: function(ts) {
				alert(ts.responseText);
				console.log(ts.responseText);
			}
		})
	}
	$("#tables tbody").on("click", "#delBtn", function() {
		$('#form_del')[0].reset();
		$('.modal-title').text('Hapus Data Indikator');
		$('#modal-del').modal({
			backdrop: "static",
			show: true
		});
		var url = $(this).data('url');
		$("#form_del").attr("action", url);
	});
</script>