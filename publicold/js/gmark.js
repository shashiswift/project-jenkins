$(document).ready(function () {
	var product_count = 1;

	$(".add-row").click(function () {
		var dumy_tr =
			'<tr class="table-primary"><td><textarea  name="product[' +
			product_count +
			'][hs_code]" class="form-control"></textarea></td><td><textarea  name="product[' +
			product_count +
			'][product]" class="form-control"></textarea></td><td><textarea  name="product[' +
			product_count +
			'][trade_mark]" class="form-control"></textarea></td><td><textarea  name="product[' +
			product_count +
			'][mode_type_ref]" class="form-control"></textarea></td><td><textarea  name="product[' +
			product_count +
			'][technical_details]" class="form-control"></textarea></td><td><input type="checkbox" name="record"></td></tr>';

		$(".product tbody").append(dumy_tr);
		product_count++;
	});

	$(".delete-row").on("click", function () {
		$(".product tbody")
			.find('input[name="record"]')
			.each(function () {
				if ($(this).is(":checked")) {
					$(this).parents("tr").remove();
				}
			});
	});
});

$(document).ready(function () {

	var base_url = $("#base_url").attr("data-id");
	var _tokken = $('meta[name="_tokken"]').attr("content");


	/* CALL FUNCTION */
	var country_id = [195, 234, 120, 180, 17, 167, 247];
	destination(country_id);
	customer_list(".gmark_customer_list", null);
	customer_list(".gmark_customer_list_licc", null);
	customer_list(".gmark_customer_list_manu", null);
	customer_list(".gmark_customer_list_factory", null);
	country_list(".country_list", null);
	ex_method_dropdown();
	legal_entityDropdown();
	laboratoryDropdown();
	applicationDropdown();
	/* END */

	var product_con_count = 1;
	$(".add-row-con").click(function () {
		var dumy_tr =
			'<tr class="table-primary"><td><textarea name="product_con[' +
			product_con_count +
			'][hs_code]" class="form-control"></textarea></td><td><textarea name="product_con[' +
			product_con_count +
			'][product]" class="form-control"></textarea></td><td><textarea name="product_con[' +
			product_con_count +
			'][other_con_mark]" class="form-control"></textarea></td><td><textarea name="product_con[' +
			product_con_count +
			'][applicable_standard]" class="form-control"></textarea></td><td><textarea name="product_con[' +
			product_con_count +
			'][test_report]" class="form-control"></textarea></td><td><input type="checkbox" name="record"></td></tr>';

		$(".con_table tbody").append(dumy_tr);
		product_con_count++;
	});

	$(".delete-row-con").on("click", function () {
		$(".con_table tbody")
			.find('input[name="record"]')
			.each(function () {
				if ($(this).is(":checked")) {
					$(this).parents("tr").remove();
				}
			});
	});

	$(".link_check").on("change", function () {
		var link_check = $(this).val();
		if (link_check == "1") {
			$(".check_detail").css("display", "inline-block");
		}
		if (link_check == "0") {
			$(".check_detail").css("display", "none");
		}
	});

	// add more factory
	$("#add_factory").click(function () {
		var addForm = $(".parent").html();
		$(".more_factory_data").append(addForm);
	});

	// delete factory

	$(document).on("click", "#remove_factory", function () {
		$(this).parents(".factory_data_form").remove();
	});

	function get_applicant_detail() {
		var entity_type = $(".legel_entity").val();
		var emtity_addr = $(".emtity_addr").val();
		var entity_country = $(".entity_country").val();
		var name = $(".appli_name").val();
		var title = $(".appli_title").val();
		var dept = $(".appli_dept").val();
		var mob = $(".appli_mob").val();
		var email = $(".appli_email").val();
		var entity_name = $(".entity_name").val();

		var arr = [];
		arr.push(
			entity_type,
			emtity_addr,
			entity_country,
			name,
			title,
			dept,
			mob,
			email,
			entity_name
		);
		return arr;
	}

	$(".mf_same_as").on("change", function () {
		var arr = get_applicant_detail();
		var check_mf = $(".mf_same_as").val();
		if (check_mf == "1") {
			$("#gmark_customer_list_manu").val($('#gmark_customer_list').val());
			manufacture_details($('#gmark_customer_list').val());
		}else{
			customer_list(".gmark_customer_list_manu", null);
			$('#manufacture_html').html('');
		}
	});
	
	$(".fc_same_as").on("change", function () {
		get_applicant_detail();
		var check_mf = $(".fc_same_as").val();
		if (check_mf == "1") {
			$("#gmark_customer_list_factory").val($('#gmark_customer_list').val());
		}else{
			customer_list(".gmark_customer_list_factory", null);
		}
	});

	// validation of application

	$("form[name='submit_application']").validate({
		rules: {
			application_name: "required",
			application_desc: "required",
		},

		messages: {
			application_name: "This is required field please fill it",
			application_desc: "This is required field please fill it",
		},
	});

	// validation of laboratory

	$("form[name='submit_lab']").validate({
		rules: {
			lab_name: "required",
		},

		messages: {
			lab_name: "This is required field please fill it",
		},
	});
	$("form[name='Sub_submit_lab']").validate({
		rules: {
			gmark_laboratory_type_id: "required",
			Sub_lab_name: "required",
		},

		messages: {
			gmark_laboratory_type_id: "This is required field please Select Lab",
			Sub_lab_name: "This is required field please fill it",
		},
	});

	// validation of legal entity type

	$("form[name='submit_legal_entity']").validate({
		rules: {
			legal_entity_name: "required",
			legal_entity_desc: "required",
		},

		messages: {
			legal_entity_name: "This is required field please fill it",
			legal_entity_desc: "This is required field please fill it",
		},
	});

	// validation for examination method

	$("form[name='submit_ex_method']").validate({
		rules: {
			ex_method_name: "required",
			ex_method_desc: "required",
		},

		messages: {
			ex_method_name: "This is required field please fill it",
			ex_method_desc: "This is required field please fill it",
		},
	});
	// CUSTOMER VALIDATION

	$("form[name='customer_add']").validate({
		rules: {
			entity_name: "required",
			address: "required",
			country: "required",
			contact_name: "required",
			contact_title: "required",
			phn_no: "required",
			email: "required",
		},

		messages: {
			ex_method_name: "This is required field please fill it",
			entity_name: "This is required field please fill it",
			address: "This is required field please fill it",
			country: "This is required field please fill it",
			contact_name: "This is required field please fill it",
			contact_title: "This is required field please fill it",
			phn_no: "This is required field please fill it",
			email: "This is required field please fill it",
		},
	});
	$("form[name='manufacture_Add']").validate({
		rules: {
			entity_name: "required",
			address: "required",
			country: "required",
			contact_name: "required",
			contact_title: "required",
			phn_no: "required",
			email: "required",
			department: "required",
		},

		messages: {
			ex_method_name: "This is required field please fill it",
			entity_name: "This is required field please fill it",
			address: "This is required field please fill it",
			country: "This is required field please Select it",
			contact_name: "This is required field please fill it",
			contact_title: "This is required field please fill it",
			phn_no: "This is required field please fill it",
			email: "This is required field please fill it",
			department: "This is required field please fill it",
		},
	});
	$("form[name='licensee_customer_Addd']").validate({
		rules: {
			entity_name: "required",
			address: "required",
			country: "required",
			contact_name: "required",
			contact_title: "required",
			phn_no: "required",
			email: "required",
		},

		messages: {
			ex_method_name: "This is required field please fill it",
			entity_name: "This is required field please fill it",
			address: "This is required field please fill it",
			country: "This is required field please Select it",
			contact_name: "This is required field please fill it",
			contact_title: "This is required field please fill it",
			phn_no: "This is required field please fill it",
			email: "This is required field please fill it",
		},
	});
	$("form[name='factory_Add']").validate({
		rules: {
			entity_name: "required",
			address: "required",
			country: "required",
			contact_name: "required",
			contact_title: "required",
			phn_no: "required",
			email: "required",
			department: "required",
		},

		messages: {
			ex_method_name: "This is required field please fill it",
			entity_name: "This is required field please fill it",
			address: "This is required field please fill it",
			country: "This is required field please Select it",
			contact_name: "This is required field please fill it",
			contact_title: "This is required field please fill it",
			phn_no: "This is required field please fill it",
			email: "This is required field please fill it",
			department: "This is required field please fill it",
		},
	});

	// setting base url and tokken

	function ex_method_dropdown() {
		$.ajax({
			url: base_url + "Gmark/get_ex_method",
			method: "POST",
			data: {
				_tokken: _tokken,
			},
			success: function (result) {
				var data = $.parseJSON(result);
				if (data) {
					$(".examination_mtd").html("");
					$(".examination_mtd").append(
						$(
							'<option value="" selected disabled>Examinations method:</option>'
						)
					);
					$.each(data, function (index, value) {
						$(".examination_mtd").append(
							$(
								'<option value="' +
									value.ex_method_id +
									'">' +
									value.ex_method_name +
									"</option>"
							)
						);
					});
				}
			},
		});
	}

	$(document).on('change','#gmark_customer_list',function(){
		var id =$(this).val();
		applicant_details_set(id);
	});
	function applicant_details_set(id) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/get_customer_details",
			data: {
				customer_id: id,
				_tokken: _tokken,
			},
			success: function (data) {
				var html = $.parseJSON(data);
				if (html) {
					var data = '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">'+html.address+'</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_applicant mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="'+html.contact_name+'"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="'+html.contact_title+'" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_department">Department:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_dept mendatory" type="text" value="'+html.department+'" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="'+html.phn_no+'" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="'+html.email+'" id=""></div></div>';
					$('#applicant_deials_html').html(data);
					setTimeout(function(){
					country_list('.country_list_append_applicant',html.country)},500
					);
				}
			},
		});
	}
	$(document).on('change','#gmark_customer_list_manu',function(){
		var id =$(this).val();
		manufacture_details(id);
	});
	function manufacture_details(id) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/get_customer_details",
			data: {
				customer_id: id,
				_tokken: _tokken,
			},
			success: function (data) {
				var html = $.parseJSON(data);
				if (html) {
					var data = '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">'+html.address+'</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_manufacture mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="'+html.contact_name+'"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="'+html.contact_title+'" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_department">Department:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_dept mendatory" type="text" value="'+html.department+'" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="'+html.phn_no+'" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="'+html.email+'" id=""></div></div>';
					$('#manufacture_html').html(data);
					setTimeout(function(){
					country_list('.country_list_append_manufacture',html.country)},500
					);
				}
			},
		});
	}
	$(document).on('change','#gmark_customer_list_licc',function(){
		var id = $(this).val();
		licc_details(id);
	});
	function licc_details(id) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/get_customer_details",
			data: {
				customer_id: id,
				_tokken: _tokken,
			},
			success: function (data) {
				var html = $.parseJSON(data);
				if (html) {
					var data = '<div class="row"><div class="col-sm-4 p-2"><label for="mf_addr">Address:</span></label></div><div class="col-sm-8 p-2"><textarea readonly class="form-control form-control-sm mf_addr mendatory" id="" cols="30" rows="3">'+html.address+'</textarea></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_country">Country:</label></div><div class="col-sm-8 p-2"><select disabled="true" class="form-control form-control-sm country_list_append_licensee mendatory" id=""></select></div></div><div class="row"><div class="col-sm-4 p-2"><label for="addr"><u><b>Contact details:</b></u></span></label></u></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_name">Name:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_name mendatory" type="text" value="'+html.contact_name+'"  id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_title">Title:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_title mendatory" value="'+html.contact_title+'" type="text" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_mob">Telephone number:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_mob mendatory" type="number" value="'+html.phn_no+'" id=""></div></div><div class="row"><div class="col-sm-4 p-2"><label for="mf_email">Email Address:</span></label></div><div class="col-sm-8 p-2"><input readonly class="form-control form-control-sm mf_email mendatory" type="email" value="'+html.email+'" id=""></div></div>';
					$('#licensee_html').html(data);
					setTimeout(function(){
						country_list('.country_list_append_licensee',html.country)},500
					);
				}
			},
		});
	}
	// destination checkbox
	
	function destination(country_id) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/get_country",
			data: {
				country_id: country_id,
				_tokken: _tokken,
			},
			success: function (data) {
				html = $.parseJSON(data);
				$.each(html, function (index, value) {
					$(".destination").append(
						$(
							'<input type="checkbox" name="destination[]" value="' +
								value.country_id +
								'"> ' +
								value.country_name +
								"  </input>"
						)
					);
				});
			},
		});
	}

	function customer_list(class_set, selected) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/get_customer",
			data: {
				_tokken: _tokken,
			},
			success: function (data) {
				html = $.parseJSON(data);
				$(class_set).html('<option value="" >APPLICANT SELECT</option>');
				$.each(html, function (index, value) {
					if (selected) {
						if (selected == value.customers_id) {
							$(class_set).append(
								'<option selected value="' +
									value.customers_id +
									'" >' +
									value.entity_name +
									"</option>"
							);
						} else {
							$(class_set).append(
								$("<option>", {
									value: value.customers_id,
									text: value.entity_name,
								})
							);
						}
					} else {
						$(class_set).append(
							$("<option>", {
								value: value.customers_id,
								text: value.entity_name,
							})
						);
					}
				});
			},
		});
	}

	function country_list(id_set, params) {
		$.ajax({
			method: "POST",
			url: base_url + "Gmark/fetch_country",
			data: {
				_tokken: _tokken,
			},
			success: function (data) {
				html = $.parseJSON(data);
				$(id_set).html('<option value="0">SELECT COUNTRY </option>');
				$.each(html, function (index, value) {
					if (params) {
						if (params == value.country_id) {
							$(id_set).append(
								'<option selected value="' +
									value.country_id +
									'">' +
									value.country_name +
									"</option>"
							);
						} else {
							$(id_set).append(
								$("<option>", {
									value: value.country_id,
									text: value.country_name,
								})
							);
						}
					} else {
						$(id_set).append(
							$("<option>", {
								value: value.country_id,
								text: value.country_name,
							})
						);
					}
				});
			},
		});
	}
	// submit application by ajax
	$(".add_application_submit").on("click", function () {
		var validation = $("form[name='submit_application']").valid();
		if (validation == true) {
			var app_name = $(".application_name").val();
			var app_desc = $(".application_desc").val();
			$.ajax({
				type: "ajax",
				async: true,
				dataType: "json",
				url: base_url + "Gmark/add_application",
				method: "POST",
				data: {
					app_name: app_name,
					app_desc: app_desc,
					_tokken: _tokken,
				},
				success: function (result) {
					// var data = $.parseJSON(result);
					if (result.errors) {
						$(".application_errors").html(result.errors);
					}
					if (result.status > 0) {
						$.notify("Application added successfully", "success");
						$("#add_application").modal("hide");
						$(".application_name").val("");
						$(".application_desc").val("");
						applicationDropdown();
					} else {
						$.notify(result.msg, "error");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});

	$(".add_submit").on("submit", function (e) {
		e.preventDefault();
	});

	// setting application type into dropdown

	function applicationDropdown() {
		$.ajax({
			url: base_url + "Gmark/get_application",
			method: "POST",
			data: {
				_tokken: _tokken,
			},
			success: function (result) {
				var data = $.parseJSON(result);
				if (data) {
					$(".application_type").html("");
					$(".application_type").append(
						$(
							'<option value="" selected disabled>Select Type of application</option>'
						)
					);
					$.each(data, function (index, value) {
						$(".application_type").append(
							$(
								'<option value="' +
									value.application_id +
									'">' +
									value.application_name +
									"</option>"
							)
						);
					});
				}
			},
		});
	}

	// laboratory ajax for submit start

	$(".add_laboratory_submit").on("click", function () {
		var validation = $("form[name='submit_lab']").valid();
		if (validation == true) {
			var lab_name = $(".lab_name").val();
			var lab_desc = $(".lab_desc").val();
			$.ajax({
				url: base_url + "Gmark/add_lab",
				method: "POST",
				data: {
					lab_name: lab_name,
					lab_desc: lab_desc,
					_tokken: _tokken,
				},
				success: function (result) {
					var data = $.parseJSON(result);

					if (data.status > 0) {
						$.notify("Subcontracted laboratory added successfully", "success");
						$("#add_laboratory").modal("hide");
						$(".lab_name").val("");
						$(".lab_desc").val("");
						laboratoryDropdown();
					} else {
						$.notify("Something went wrong", "error");
					}
					if (data.errors) {
						$("#p_lab").html(data.errors);
					} else {
						$("#p_lab").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});
	$(".sub_laboratory_submit").on("click", function () {
		var validation = $("form[name='Sub_submit_lab']").valid();
		if (validation == true) {
			$.ajax({
				url: base_url + "Gmark/add_sub_lab",
				method: "POST",
				data: $("#sub_lab").serialize(),
				success: function (result) {
					var data = $.parseJSON(result);

					if (data.status > 0) {
						$.notify("Subcontracted laboratory added successfully", "success");
						$("#sub_add_laboratory").modal("hide");
						$(".lab_name").val("");
						$(".lab_desc").val("");
						laboratoryDropdown();
					} else {
						$.notify("Something went wrong", "error");
					}
					if (data.errors) {
						$("#p_sub_lab").html(data.errors);
					} else {
						$("#p_sub_lab").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});

	$(".add_laboratory").on("submit", function (e) {
		e.preventDefault();
	});

	// setting laboratory type into dropdown

	function laboratoryDropdown() {
		$.ajax({
			url: base_url + "Gmark/get_lab",
			method: "POST",
			data: {
				_tokken: _tokken,
			},
			success: function (result) {
				var data = $.parseJSON(result);
				if (data) {
					$(".add_laboratory_type").html("");
					$(".add_laboratory_type").append(
						$('<option value="" selected disabled>Select laboratory</option>')
					);
					$.each(data, function (index, value) {
						$(".add_laboratory_type").append(
							$(
								'<option value="' +
									value.lab_id +
									'">' +
									value.lab_name +
									"</option>"
							)
						);
					});
				}
			},
		});
	}

	$(document).on("change", ".add_laboratory_type", function () {
		SublaboratoryDropdown($(this).val(), null);
	});
	function SublaboratoryDropdown(lab_id, selected) {
		$.ajax({
			url: base_url + "Gmark/get_sub_lab",
			method: "POST",
			data: {
				lab_id: lab_id,
				_tokken: _tokken,
			},
			success: function (result) {
				var data = $.parseJSON(result);
				if (data) {
					$(".subcontracted").html("");
					$(".subcontracted").append(
						$('<option value="" selected disabled>Select laboratory</option>')
					);
					$.each(data, function (index, value) {
						$(".subcontracted").append(
							$("<option>", {
								value: value.Sub_lab_id,
								text: value.Sub_lab_name,
							})
						);
					});
				}
			},
		});
	}
	// end

	// legal entity type ajax submit start

	$(".add_entity_submit").on("click", function () {
		var validation = $("form[name='submit_legal_entity']").valid();
		if (validation == true) {
			var legal_entity_name = $(".legal_entity_name").val();
			var legal_entity_desc = $(".legal_entity_desc").val();
			$.ajax({
				type: "ajax",
				async: true,
				dataType: "json",
				url: base_url + "Gmark/add_legal_entity",
				method: "POST",
				data: {
					legal_entity_name: legal_entity_name,
					legal_entity_desc: legal_entity_desc,
					_tokken: _tokken,
				},
				success: function (result) {
					var data = $.parseJSON(result);
					if (data) {
						$.notify("Legal entity added successfully", "success");
						$("#add_legal_entity").modal("hide");
						$(".legal_entity_name").val("");
						$(".legal_entity_desc").val("");
						legal_entityDropdown();
					}
					if (data == false) {
						$.notify("Legal entity already Exist", "error");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});

	$(".add_legal_class").on("submit", function (e) {
		e.preventDefault();
	});

	// setting legal entity type into dropdown

	function legal_entityDropdown() {
		$.ajax({
			url: base_url + "Gmark/get_legal_entity",
			method: "POST",
			data: {
				_tokken: _tokken,
			},
			success: function (result) {
				var data = $.parseJSON(result);
				if (data) {
					$(".legal_entity_type").html("");
					$(".legal_entity_type").append(
						$('<option value="" selected disabled>Select entity type</option>')
					);
					$.each(data, function (index, value) {
						$(".legal_entity_type").append(
							$(
								'<option value="' +
									value.legal_entity_id +
									'">' +
									value.legal_entity_name +
									"</option>"
							)
						);
					});
				}
			},
		});
	}
	// end

	// add examination method

	$(".add_ex_submit").on("click", function () {
		var validation = $("form[name='submit_ex_method']").valid();
		if (validation == true) {
			var ex_method_name = $(".ex_method_name").val();
			var ex_method_desc = $(".ex_method_desc").val();
			$.ajax({
				type: "ajax",
				async: true,
				dataType: "json",
				url: base_url + "Gmark/add_ex_method",
				method: "POST",
				data: {
					ex_method_name: ex_method_name,
					ex_method_desc: ex_method_desc,
					_tokken: _tokken,
				},
				success: function (result) {
					var data = $.parseJSON(result);
					if (data) {
						$.notify("Examination method added successfully", "success");
						$("#add_ex_method").modal("hide");
						$(".ex_method_name").val("");
						$(".ex_method_desc").val("");
						ex_method_dropdown();
					}
					if (data == false) {
						$.notify("Examination method already Exist", "error");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});

	// CUSTOMER FORM ADD
	$(".customer_add").on("click", function () {
		var validation = $("form[name='customer_add']").valid();
		if (validation == true) {
			$.ajax({
				url: base_url + "Gmark/customer_Add",
				method: "POST",
				data: $("#customer_Addd").serialize(),
				success: function (result) {
					var data = $.parseJSON(result);
					if (data.status > 0) {
						$.notify(data.msg, "success");
						$("#applicant_add").modal("hide");
						$("form[name='customer_add']").trigger("reset");
						customer_list('.gmark_customer_list',null);
					} else {
						$.notify(data.msg, "error");
					}
					if (data.errors) {
						$(".error_custmer_add").html(data.errors);
					} else {
						$(".error_custmer_add").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});
	$(".licensee_customer_Addd").on("click", function () {
		var validation = $("form[name='licensee_customer_Addd']").valid();
		if (validation == true) {
			$.ajax({
				url: base_url + "Gmark/customer_Add",
				method: "POST",
				data: $("#licensee_customer_Addd").serialize(),
				success: function (result) {
					var data = $.parseJSON(result);
					if (data.status > 0) {
						$.notify(data.msg, "success");
						$("#licensee_add").modal("hide");
						$("form[name='licensee_customer_Addd']").trigger("reset");
						customer_list("#gmark_customer_list_licc", null);
					} else {
						$.notify(data.msg, "error");
					}
					if (data.errors) {
						$(".error_licensee_customer_Addd").html(data.errors);
					} else {
						$(".error_licensee_customer_Addd").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});
	$(".manufacture_customer_Addd").on("click", function () {
		var validation = $("form[name='manufacture_Add']").valid();
		if (validation == true) {
			$.ajax({
				url: base_url + "Gmark/customer_Add",
				method: "POST",
				data: $("#manufacture_Add").serialize(),
				success: function (result) {
					var data = $.parseJSON(result);
					if (data.status > 0) {
						$.notify(data.msg, "success");
						$("#manufacture_Add_modal").modal("hide");
						$("form[name='manufacture_Add']").trigger("reset");
						customer_list(".gmark_customer_list_manu", null);
					} else {
						$.notify(data.msg, "error");
					}
					if (data.errors) {
						$(".error_licensee_customer_Addd").html(data.errors);
					} else {
						$(".error_licensee_customer_Addd").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});
	$(".factory_customer_Addd").on("click", function () {
		var validation = $("form[name='factory_Add']").valid();
		if (validation == true) {
			$.ajax({
				url: base_url + "Gmark/customer_Add",
				method: "POST",
				data: $("#factory_Add").serialize(),
				success: function (result) {
					var data = $.parseJSON(result);
					if (data.status > 0) {
						$.notify(data.msg, "success");
						$("#factory_Add_modal").modal("hide");
						$("form[name='factory_Add']").trigger("reset");
						customer_list(".gmark_customer_list_factory", null);
					} else {
						$.notify(data.msg, "error");
					}
					if (data.errors) {
						$(".error_licensee_customer_Addd").html(data.errors);
					} else {
						$(".error_licensee_customer_Addd").html("");
					}
				},
				error: function () {
					$.notify("Something went wrong", "error");
				},
			});
		} else {
			$.notify("Please fill all fields", "error");
		}
	});

	$(".add_ex_class").on("submit", function (e) {
		e.preventDefault();
	});

	// setting examination method type into dropdown

	
});
