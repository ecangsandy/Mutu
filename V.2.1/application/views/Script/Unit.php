<script>
	$(document).ready(function () {
		var url = '<?=base_url('Unit/get_tables')?>';
		// console.log(url);
		table = $('#unit_table').DataTable({
			dom: 'Bfrtip',
			"processing": true,
			"ajax"      : {
				"url"       : url,
				"type"      : "POST"
			}
		});
		
	});
	function add() {
		$('#form_input')[0].reset();
		$('.modal-title').text('Tambah Data Unit');
		$('#modal-id').modal({
			backdrop: "static",
			show: true
		});
		$('#metode').val('add');
	}
	function save() {
		var url = '<?=base_url('Unit/save')?>';
		// console.log(metode)
		
		var dataForm = new FormData($('#form_input')[0]);
		// console.log(dataForm);
		$.ajax({
			url: url,
			type: "POST",
			data: dataForm,
			dataType: "JSON",
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data.success) {
					new PNotify({
						title: 'Success!',
						text: data.notif,
						type: 'success',
						styling: 'bootstrap3'
					});
					$('#modal-id').modal('hide');
					// $('#saveBtn').removeAttr('data-metode');
					reload_table();

				} else if (data.messages) {
					$('#msg').html(data.messages);
					$.each(data.messages, function (key, value) {
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
			error: function (ts) {
				alert(ts.responseText);
				console.log(ts.responseText);
			}
		})
	}
	function reload_table() {
		table.ajax.reload(null, false);
	}

	$("#unit_table tbody").on("click", "#edit", function () {
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
			success: function (data) {
				$.each(data, function (key, value) {
					$('#' + key).val(value);
				});

			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
		
	});
	$("#unit_table tbody").on("click", "#delBtn", function () {
		$('#form_input')[0].reset();
		$('.modal-title').text('Edit Data Unit');
		$('#modal-del').modal({
			backdrop: "static",
			show: true
		});
		var url = $(this).data('url');
		$("#hapus").attr("href", url); 
		console.log(url)	
	});

</script>