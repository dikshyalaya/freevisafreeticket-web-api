@extends('themes.fvft.layouts.master')
{{-- @dd($countries) --}}
@section('main')
        @include('themes.fvft.site.components.header')
		@yield('content')
		@include('themes.fvft.site.components.footer')
@endsection

@section('script')
<script>
	function changeCandidateProfile()
	{
		$("#CandidateProfileImage").click();
	}

	$("#CandidateProfileImage").change(function(){
		if($(this).val() != ''){
			uploadCandidateImage(this);
		}
	});

	function uploadCandidateImage(img){
		var formData = new FormData();
		formData.append('avatar', img.files[0]);
		formData.append("_token", "{{ csrf_token() }}");
		$.ajax({
			url: "{{ route('candidate.profile.updateCandidateProfile') }}",
			data: formData,
			type: "POST",
			contentType: false,
			processData: false,
			success: function(data){
				if(data.error){
					toastr.error(data.error['avatar']);
				} else if(data.db_error){
					toastr.error(data.db_error);
				} else {
					$("#candidateImageSrc").attr('src', data.avatar);
					toastr.success(data.msg);
				}
			},
			error: function(xhr, status, error){

			}
		});
	}
</script>
@endsection
