@extends('back._layouts.login')
@section('title', 'Login')

@section('content')
<div class="container">
	{{ Form::open(['url' => '', 'class' => 'form-signin', 'id' => 'login_form']) }}
	<h2 class="form-signin-heading">Please sign in</h2>

	{{ Form::text('email', 'admin@admin.com', ['class' => 'form-control', 'placeholder' => 'Email']) }}
	{{ Form::label('email', ' ', ['class' => 'label-error text-danger', 'name' => 'email_error']) }}

	{{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
	{{ Form::label('password', ' ', ['class' => 'label-error text-danger', 'name' => 'password_error']) }}

	{{ Form::submit('Sign in', ['class' => 'btn btn-block btn-primary', 'id' => 'login_sign_in']) }}
	{{ Form::close() }}
</div>

<script>
$("#login_form").submit(function(e) {
	var button_submit = $('#login_sign_in');
    $.ajax({
    	beforeSend : function() { e.preventDefault(); button_submit.prop('disabled', true); },
    	data: $(this).serialize(), type: 'post', url: 'admin/login',
		success: function(data) {
			j_validate(data); button_submit.prop('disabled', false);

			if (data.status == 1) {
				window.location.href = data.url;
			}
       	}
    });
});
</script>
@endsection