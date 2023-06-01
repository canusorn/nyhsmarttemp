<?php

require 'includes/init.php';

Url::redirect('/login.php');
?>

<?php require 'includes/header.php'; ?>

<header class="text-light text-center" style="background: url('includes/img/homeiot.jpg') no-repeat center center;height: 400px;background-size: cover;padding-top: 4rem;padding-bottom: 8rem;text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column" style="max-width: 42em">
        <h1>IoT Temperature</h1>
        <p class="lead">IoT ง่ายๆ สำหรับทุกคน</p>

        <?php if (Auth::isLoggedIn()) : ?>
            <p class="lead"><a href="dashboard" class="btn btn-lg btn-primary fw-bold border-primary">Dashboard</a></p>
        <?php else : ?>
            <p class="lead"><a href="preview/01acmeter.html" class="btn btn-lg btn-primary fw-bold border-primary">Live preview</a></p>
        <?php endif; ?>
    </div>
</header>

<!-- Features icons -->
<section class="features-icons bg-light text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-3">
                    <div class="features-icons-icon" style="font-size: 3rem;margin-bottom: 1rem;color: #0080ff;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                        </svg>
                    </div>
                    <h3>เข้าถึงได้จากอินเทอร์เน็ต</h3>
                    <p class="lead mb-0">เข้าดูข้อมูลได้จากอินเทอร์เน็ตทุกที่ ไม่จำเป็นว่าต้องเป็นไวไฟเดียวกัน</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-3">
                    <div class="features-icons-icon" style="font-size: 3rem;margin-bottom: 1rem;color: #0080ff;">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                        </svg>
                    </div>
                    <h3>ไม่มีโค้ดดิ้ง ใช้งานง่าย</h3>
                    <p class="lead mb-0">แค่สมัครสมาชิก และล็อกอินอุปกรณ์ ก็สามารถใช้ได้เลย</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-3">
                    <div class="features-icons-icon" style="font-size: 3rem;margin-bottom: 1rem;color: #0080ff;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-code-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0zm2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0z" />
                        </svg>
                    </div>
                    <h3>กลับมาใช้งานได้ทุกครั้งที่ต้องการ</h3>
                    <p class="lead mb-0">อุปกรณ์เป็น ESP8266 สามารถนำอุปกรณ์ไปลงโค้ดอื่นๆได้ตามต้องการ และยังสามารถกลับมาใช้โค้ดเดิมได้ทุกเมื่อ</p>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="text-center">
    <h3>ภาพรวมการตั้งค่าใช้งานกับ IoTkiddie</h3>
    <img src="includes/img/infographic-iotkiddie.gif" class="img-fluid" alt="iotkiddie_infographic">
</div>

<?php require 'includes/footer.php'; ?>