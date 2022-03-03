<?php
$dataForm = $this->arrParams["form"];


$inputAccName = HelperFrontend::cmsInput("text", "form[username]", "form-control", $dataForm["username"] ?? "", false, 'id = "username"');
$cmsRowAccName = HelperFrontend::cmsRowInput("Tên tài khoản", $inputAccName, true, "username");


$inputFullName = HelperFrontend::cmsInput("text", "form[fullname]", "form-control", $dataForm["fullname"] ?? "", false, 'id = "fullname"');
$cmsRowFullName = HelperFrontend::cmsRowInput("Họ và tên", $inputFullName, true, "fullname");

$inputEmail = HelperFrontend::cmsInput("email", "form[email]", "form-control", $dataForm["email"] ?? "", false, 'id = "email"');
$cmsRowEmail = HelperFrontend::cmsRowInput("Email", $inputEmail, true, "email");

$inputPassword = HelperFrontend::cmsInput("password", "form[password]", "form-control", $dataForm["password"] ?? "", false, 'id = "password" min="0.0"');
$cmsRowPassword = HelperFrontend::cmsRowInput("Mật khẩu", $inputPassword, true, "password");

$inputHidden = HelperFrontend::cmsInput("hidden", "form[token]", "form-control", time(), false, 'id="token" min="0.0"');
$buttonLink = HelperFrontend::cmsButtonLink("Tạo tài khoản", "btn btn-solid", "button", "", null, "submit", 'id="submit" name="form[submit]" value = "Tạo tài khoản"');

$linkAction = URL::createLink($this->arrParams['module'], $this->arrParams['controller'], $this->arrParams['action']);
?>





<div class="breadcrumb-section"></div>
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php echo $this->error ?? '' ?>
                <h3>Đăng ký tài khoản</h3>
                <div class="theme-card">
                    <form action="<?= $linkAction ?>" method="post" name="adminform" id="admin-form" class="theme-form">
                        <div class="form-row">
                            <div class="col-md-6">
                                <?= $cmsRowAccName; ?>
                            </div>
                            <div class="col-md-6">
                                <?= $cmsRowFullName; ?>
                            </div>
                            <div class="col-md-6">
                                <?= $cmsRowEmail; ?>
                            </div>
                            <div class="col-md-6">
                                <?= $cmsRowPassword; ?>
                            </div>

                        </div>
                        <?= $inputHidden . $buttonLink ?>


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>