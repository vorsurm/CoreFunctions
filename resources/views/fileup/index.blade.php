@extends('layouts.app')
@section('content')
<div class="container">
	<h3 class="jumbotron">Drag and Drop Files here to upload</h3>
	<form method="post" action="{{ url('file/store') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
		@csrf
	</form>   
</div>
<script type="text/javascript">
	Dropzone.options.dropzone =
	{
		maxFiles: 10,
		maxFilesize: 12,
		renameFile: function(file) {
			var dt = new Date();
			var time = dt.getTime();
			return time+file.name;
		},
		acceptedFiles: ".jpeg,.jpg,.png,.gif",
		addRemoveLinks: true,
		timeout: 50000,
		
		removedfile: function(file) 
		{
			var name = file.upload.filename;
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				url: '{{ url("file/delete") }}',
				data: {filename: name},
				success: function (data){
					console.log("File has been successfully removed!!");
				},
				error: function(e) {
					console.log(e);
				}});
			var fileRef;
			return (fileRef = file.previewElement) != null ? 
			fileRef.parentNode.removeChild(file.previewElement) : void 0;
		},
		
		success: function(file, response) 
		{
			console.log(response);
		},
		error: function(file, response)
		{
			return false;
		}
	};
</script>
@endsection
