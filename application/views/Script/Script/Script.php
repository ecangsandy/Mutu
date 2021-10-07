<script src="<?php echo base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
	$('.select2').select2({
		placeholder: "PILIH",
	})
</script>
<script>
	$(document).ready(function() {
		// var url = '<?= base_url('Unit/get_tables') ?>';
		var url = $('#tables').data('url');
		// console.log(url);
		table = $('#tables').DataTable({
			dom: 'Bfrtip',
			"processing": true,
			"ajax": {
				"url": url,
				"type": "POST"
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

	function reload_table() {
		table.ajax.reload(null, false);
	}

	function remove_validation() {
		$('p.text-danger').remove();
		$('div.has-error').removeClass('has-error');
		$('div.has-success').removeClass('has-success');
	}

	$("#tables tbody").on("click", "#edit", function() {
		remove_validation();
		$('#form_input')[0].reset();
		$('.modal-title').text('Edit Data Unit');
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
				$('#status').val(data.status).trigger("change");
				$('#kd_unit').val(data.kd_unit).trigger("change");
				var values = data.area;

			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});

	});

	function delet() {
		remove_validation();
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
		remove_validation();
		$('#form_del')[0].reset();
		$('.modal-title').text('Edit Data Unit');
		$('#modal-del').modal({
			backdrop: "static",
			show: true
		});
		var url = $(this).data('url');
		$("#form_del").attr("action", url);
		console.log(url)
	});
</script>