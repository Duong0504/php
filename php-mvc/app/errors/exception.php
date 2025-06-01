<style>
    h2 {
        text-transform: uppercase;
    }
    .wrapper-error {
        width: 600px; 
        margin: 0 auto;
        padding: 20px 30px; 
        text-align: center; 
        background: #99A799;
        border-radius: 6px;
        margin-top: 30px;
    }
</style>
<div class="wrapper-error">
    <h2>Có lỗi, vui lòng kiểm tra lại</h2>
    <p><?php echo !empty($message)?$message:$data; ?> </p>
</div>
