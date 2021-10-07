<script src="<?php echo base_url('assets/')?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
	$(document).ready(function () {
		$('.select2').select2();
        bln= $('#bulan').val();
		thn=$('#tahun').val();
		kategori = '<?= $this->uri->segment(3)?>';
		// console.log('0000'+kategori);
		
		// var url = '<?=base_url('Survei/get_tables/')?>';
		var url = $('#tables').data('url');
		table = $('#tables').DataTable({
			dom         : 'Bfrtip',
			"processing": true,
			"ordering"  : false,
			"ajax"      : {
			"url"       : url,
			"data"		: {
							"kategori": kategori,
							"bln": bln,
							"thn": thn
						},
			"type"      : "POST"
		}
		});
    });
	function daysInMonth(month, year){
		$.get('<?=base_url('Survei/getDay/')?>'+month+'/'+year, function( data ) {
			// $( ".result" ).html( data );
			// alert( data);
			return data.day;
		});
	}
	function c() {
		n= "<?php echo cal_days_in_month(CAL_GREGORIAN,6,2019)?>";
		for (i = 1; i < n; i++) {
		console.log(i);
		
		}
	}
	function gets() {
		$.get("url", data,
			function (data, textStatus, jqXHR) {
				
			},
			"dataType"
		);
	}
	function filterdata(){
		// $('#tables thead').clear();
		bln = $('#bulan').val();
		thn=$('#tahun').val();
		console.log(bln+thn);
		
		$.get('<?=base_url('Survei/getDay/')?>'+bln+'/'+thn, function( data ) {
			max = data.countday;
			tmonth='';
			for (i = 1; i <= max; i++) {
				tmonth += "<td>"+i+"</td>";
			}
			nthead="<tr>"+
						"<th>No</th>"+
						"<th>INDIKATOR</th>"+tmonth+
					"</tr>";
					$('#tables thead').replaceWith(nthead);
		},"JSON");
		url = '<?=base_url('Survei/get_tables/')?>'+bln+'/'+thn;
		table.ajax.url( url ).load();
		// console.log(n);
		// tmonth ='';
		// for (i = 1; i < n; i++) {
		// 	tmonth += "<td>"+i+"</td>";
		// }
		// var nthead="<tr>"+
		// 				"<th>No</th>"+
		// 				"<th>INDIKATOR</th>"+tmonth+
		// 			"</tr>";
		// 			$('#tables thead').append(nthead);
	}
	function reload_table() {
		table.ajax.reload(null, false);
	}
    function detail(id) {
        $('.modal-title detail').text('Detail Data');
		$('#modal-detail').modal({
			backdrop: "static",
			show: true
		});
		$.ajax({
			type: "method",
			url: "<?=base_url('Survei/Detailindikator/')?>"+id,
			dataType: "JSON",
			success: function (data) {
				$.each(data, function (key, value) {
					$('#' + key).html(value);
				});
			}
		});
	}
	function survei(id,day) {
		$('#form_survei')[0].reset();
		$('#variable_survei tbody').empty();
		bulan = $('#bulan').val();
		tahun = $('#tahun').val();
		var ndate = (tahun+'-'+bulan+'-'+day);
		$('#tgl_input').val(ndate)
		$('#id_indikator').val(id);
		$('#metode').val('add')
		
		$('#modal-survei').modal({
			backdrop: "static",
			show: true
		});
		url = '<?=base_url('Survei/getVariable/')?>'+id;
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				var nemu="<tr><td>"+data.nemulator_variable+"</td>"+
				"<td contenteditable='true' placeholder='Masukan Nilai Nemulator...' id='nemu'></td>"+
				"<td>"+data.nemulator_satuan+"</td>"+
				"</tr>"+
				"<tr><td>"+data.demulator_variable+"</td>"+
				"<td contenteditable='true' placeholder='Masukan Nilai Demulator...' id='demu'></td>"+
				"<td>"+data.demulator_satuan+"</td>"+
				"</tr>";
				$('#variable_survei tbody').append(nemu);
			},
			error: function (jqXHR, textStatus, errorThrown) {
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
		url = '<?=base_url('Survei/getData/')?>'+id;
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				var nemu="<tr><td>"+data.nemulator_variable+"</td>"+
				"<td contenteditable='true' placeholder='Masukan Nilai Nemulator...' id='nemu'>"+data.value_nemulator+"</td>"+
				"<td>"+data.nemulator_satuan+"</td>"+
				"</tr>"+
				"<tr><td>"+data.demulator_variable+"</td>"+
				"<td contenteditable='true' placeholder='Masukan Nilai Demulator...' id='demu'>"+data.value_demulator+"</td>"+
				"<td>"+data.demulator_satuan+"</td>"+
				"</tr>";
				$('#variable_survei tbody').append(nemu);
				
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function save_variable() {
		nemu = $('#nemu').html();
		demu = $('#demu').html();
		var url = '<?=base_url('Survei/save')?>';
        // var url = $('#form_survei').attr('action');
		// console.log(metode)

		var dataForm = new FormData($('#form_survei')[0]);
		dataForm.append('demulator', demu);
		dataForm.append('nemulator', nemu);
		// console.log(dataForm);
		$.ajax({
			url : url,
			type: "POST",
			data: dataForm,
			dataType   : "JSON",
			cache      : false,
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
					$('#modal-survei').modal('hide');
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
	function save() {
		remove_validation();
        // var url = '<?=base_url('Unit/save')?>';
        var url = $('#form_input').attr('action');
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
</script>