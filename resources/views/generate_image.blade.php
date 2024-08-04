<!DOCTYPE html>
<html>
<head>
    <title>Generate Image</title>
</head>
<body>
    <form action="/generate-image" method="POST">
        @csrf
        <label for="Positive_Prompt">Mô tả của bạn:</label>
        <input type="text" id="Positive_Prompt" name="Positive_Prompt" value="1 cô gái, tóc dài, tóc trắng, váy trắng, áo trắng, hồ nước, khung cảnh thơ mộng, lãng mạn, khuôn mặt hạnh phúc, đang nhìn về phía người xem, tông màu nhẹ nhàng, màu sắc dịu, độ tương phản cao, kết cấu da tự nhiên, cường độ cao">
        <br>
        <label for="Height">Chiều dài:</label>
        <input type="text" id="Height" name="Height" value="512">
        <br>
        <label for="Width">Chiều rộng:</label>
        <input type="text" id="Width" name="Width" value="512">
        <br>
        <label for="seed">Thông số seed:</label>
        <input type="text" id="seed" name="seed" value="20000">
        <br>
        <label for="model">Model:</label>
        <select id="model" name="model">
            <option value="Hình ảnh thực tế">Hình ảnh thực tế</option>
            <option value="Hình ảnh 3D">Hình ảnh 3D</option>
            <option value="Hình ảnh hoạt hình">Hình ảnh hoạt hình</option>
            <option value="Hình ảnh Realistic">Hình ảnh Realistic</option>
        </select>
        <br>
        <label for="Load_VAE">Load VAE:</label>
        <select id="Load_VAE" name="Load_VAE">
            <option value="vae-ft-mse-840000-ema-pruned.ckpt">vae-ft-mse-840000-ema-pruned.ckpt</option>
            <option value="orangemix.vae.pt">orangemix.vae.pt</option>
        </select>
        <br>
        <button type="submit">Generate Image</button>
    </form>

    @if(isset($imageUrl))
        <h3>Ảnh tạo ra:</h3>
        <img src="{{ $imageUrl }}" alt="Generated Image">
    @endif
</body>
</html>
