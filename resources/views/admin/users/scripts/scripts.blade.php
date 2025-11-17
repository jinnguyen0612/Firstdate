<script>
				$(document).ready(function(e) {
								$("#emailInput").on("input", function() {
												$("#emailDeliInput").val($(this).val());
								});
								select2LoadData($('#area_id').data('url'), '#area_id');

								select2LoadData($('#province_id').data('url'), '#province_id');
								select2LoadData($('#discount_id').data('url'), '#discount_id');

								let provinceId;
								let districtId;

								provinceId = $('#province_id').val();
								districtId = $('#district_id').val();

								let urlDistrict = "{{ route('admin.search.select.district') }}";
								let urlWard = "{{ route('admin.search.select.ward') }}";
								select2LoadData(urlDistrict + '?province_id=' + provinceId, '#district_id');
								select2LoadData(urlWard + '?district_id=' + districtId, '#ward_id');
				});

				$(document).on('change', 'select[name="province_id"]', function(e) {
								provinceId = $(this).val();
								let url = "{{ route('admin.search.select.district') }}";
								select2LoadData(url + '?province_id=' + provinceId, '#district_id');
								select2LoadData('', '#ward_id');
								$('#district_id').val(null).trigger('change');
								$('#ward_id').val(null).trigger('change');
				});

				$(document).on('change', 'select[name="district_id"]', function(e) {
								districtId = $(this).val();
								let url = "{{ route('admin.search.select.ward') }}";
								select2LoadData(url + '?district_id=' + districtId, '#ward_id');
								$('#ward_id').val(null).trigger('change');
				});

				
</script>
