<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Icon -->
  <link rel="icon" href="/assets/img/icon.png" type="image/png">

  <title>RTX-AI: Xác minh email</title>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body style="display:flex;flex-wrap:wrap">
    <form class="form_container" style="margin:auto auto auto auto;" novalidate method="POST"  action="{{ route("checkcode") }}">
      @csrf
      <div class="logo_container">
        <a href="{{route("showhome")}}">
          <img src="/assets/img/AI.gif" alt="" style="with:100%">
        </a>
      </div>
      <div class="title_container">
        <p class="title">Nhập mã xác minh email</p>
        <span class="subtitle">Chúng tôi vừa gửi mã xác minh vào email của bạn.</span>
      </div>
      <br>
      <div class="input_container">
        <label class="input_label" for="email_field">Mã xác minh</label>
        <img src="/assets/img/select.png" class="icon" alt="">
        <input placeholder="123456" title="Inpit title" name="input-code" type="number" class="input_field form-control @error('input-code') is-invalid @enderror" id="email_field" minlength="6" required>
      </div>
      @error('input-code')
        <div class="text-danger">{{ $message }}</div>
      @enderror
      @if (Session::has("ExpiredCode"))
          <p style="color: red; width:100%">Mã không đúng hoặc đã hết hạn!</p>
      @endif
      @if (Session::has("Manytimes"))
          <p style="color: red; width:100%">Bạn đã thử quá nhiều lần! Vui lòng thử lại sau ít phút</p>
      @endif
      <div id="message" style="width:100%"></div>
      <a class="note font-bold" id="sendEmailLink" href="#" href="{{ route("sendemail") }}" style="margin:0 0 0 60% ">Gửi lại mã?</a>
      <script>
        $(document).ready(function() {
            $('#sendEmailLink').click(function(e) {
                e.preventDefault();
        
                $.ajax({
                    url: "{{ route('resendemail') }}",
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message').text(response.message).css('color', 'red');
                    },
                    error: function(response) {
                        $('#message').text('Có lỗi xảy ra!.').css('color', 'red');
                    }
                });
            });
        });
      </script>
      <button title="Sign In" type="submit" class="sign-in_btn">
        <span>Hoàn tất</span>
      </button>
  </form>
  <img src="/assets/img/left_auth.png" alt="">
</body>
</html>