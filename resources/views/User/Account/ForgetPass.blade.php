<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>RTX-AI: Quên mật khẩu</title>

  <!-- Icon -->
  <link rel="icon" href="/assets/img/icon.png" type="image/png">

  <!-- Link FrontEnd -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Link Icons -->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
  <!-- CSS Files -->
  <link rel="stylesheet" href="{{url('assets/css/header.css')}}">
  <link rel="stylesheet" href="{{url('assets/css/login.css')}}">
  <link rel="stylesheet" href="{{url('assets/css/side_img.css')}}">
  <!-- JS Files -->

</head>
<body style="display:flex;flex-wrap:wrap">
  <form class="form_container" style="margin:5% auto auto auto;" method="POST" action="{{ route("sendemailresetpass") }}">
    @csrf
    <div class="logo_container">
      <a href="{{route("showhome")}}">
        <img src="/assets/img/email.gif" alt="" style="with:100%">
      </a>
    </div>
    <div class="title_container">
      <p class="title">Vui lòng nhập email tài khoản của bạn</p>
      <span class="subtitle">Chúng tôi sẽ gửi mã xác minh tới tài khoản của bạn.</span>
    </div>
    <br>
    <x-turnstile-captcha />
    <div class="input_container">
      <label class="input_label" for="email_field">Địa chỉ Email</label>
      <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
        <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
      </svg>
      <input placeholder="name@mail.com" title="Inpit title" name="input-email" type="email" class="input_field form-control @error('input-email') is-invalid @enderror" id="email_field">
    </div>
    @error('input-email')
       <div class="text-danger w-100">{{ $message }}</div>
    @enderror
    @if($errors->has('ManyTime'))
      <div class="text-danger w-100">{{ $errors->first('ManyTime') }}</div>
    @endif
    <button title="Sign In" type="submit" class="sign-in_btn">
      <span>Tiếp theo</span>
    </button>
    </form>
</body>
</html>