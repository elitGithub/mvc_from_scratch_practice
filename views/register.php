<h1>Create an account</h1>
<form action="" method="post">
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input id="first_name" type="text" name="first_name" class="form-control">
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input id="last_name" type="text" name="last_name" class="form-control">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp">
	</div>
	<div class="form-group">
		<label for="confirm_password">Confirm Password</label>
		<input type="password" name="confirm_password" id="confirm_password" class="form-control" aria-describedby="emailHelp">
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>