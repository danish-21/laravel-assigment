<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row" style="margin-top:45px">
        <div class="col-md-4 col-md-offset-4">
            <h4>User Registration</h4><hr>
            <form action="{{ route('auth.save') }}" method="post" enctype="multipart/form-data">
            @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ old('name') }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password">
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                </div>
                <!-- Include other fields here -->

                <div class="form-group">
                    <label>Mobile</label>
                    <input type="text" class="form-control" name="mobile" placeholder="Enter mobile number" value="{{ old('mobile') }}">
                    <span class="text-danger">@error('mobile'){{ $message }} @enderror</span>
                </div>
                    <div class="form-group">
                        <label for="blog_images">Profile Images :</label>
                        <input type="file" class="form-control-file" id="profile_images" name="profile_images[]" multiple>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" class="form-control" name="dob" placeholder="Enter date of birth" value="{{ old('dob') }}">
                        <span class="text-danger">@error('dob'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <span class="text-danger">@error('gender'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="{{\App\Constants\AppConstants::USER_ACTIVE}}">Active</option>
                            <option value="{{\App\Constants\AppConstants::USER_INACTIVE}}">Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                <button type="submit" class="btn btn-block btn-primary">Sign Up</button>
                <br>
                <a href="{{ route('auth.login') }}">I already have an account, sign in</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
