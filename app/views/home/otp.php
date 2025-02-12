<?php
include_once "includes/header.php";
?>
<style>
    .otp-input {
        width: 40px;
        height: 40px;
        text-align: center;
        font-size: 20px;
        margin: 0 5px;
    }
</style>
<section class="d-flex align-items-center" style="min-height: 69vh;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Điền OTP</h4>
                    </div>
                    <div class="card-body">
                        <form id="otp-form" action="/check-otp" method="POST">
                            <div class="d-flex justify-content-center">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp1">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp2">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp3">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp4">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp5">
                                <input type="text" class="form-control otp-input" maxlength="1" id="otp6">
                                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                            </div>
                            <input type="hidden" id="otp" name="otp">
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Verify OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll(".otp-input");
        const otpField = document.getElementById("otp");
        const form = document.getElementById("otp-form");

        inputs.forEach((input, index) => {
            input.addEventListener("input", () => {
                if (input.value.length > 0 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && input.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        form.addEventListener("submit", function(event) {
            let otp = "";
            inputs.forEach(input => {
                otp += input.value;
            });
            otpField.value = otp;
        });
    });
</script>
<?php
include_once "includes/footer.php";
?>