<?php
use \Sizzle\Database\User;

define('TITLE', 'S!zzle - Give a Token of Appreciation');
require __DIR__ . '/header.php';
?>
<style>
    #sizzle-contact-footer {
        background-image: linear-gradient(135deg, rgb(11, 91, 229), rgb(22, 211, 93));
        padding: 50px;
        padding-top: 100px;
        margin: 0;
    }

    #contact-container {
        margin: auto;
        float: none;
    }

    #contact-form-column {
        margin: auto;
        float: none;
    }

    #sizzle-contact-form {
        border-radius: 4px;
        background-color: black;
        padding: 30px;
    }

    #contact-email, #contact-message {
        margin-bottom: 20px;
    }
</style>
</head>

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

    <!-- SOLID COLOR BG -->
    <div class="">
        <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->
        <?php require __DIR__ . '/navbar.php'; ?>
    </div>
    <!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->
<body>
<section id="sizzle-contact-footer">
    <div class="container" id="contact-container">
        <div id="contact" class="row">
            <div class="col-md-8" id="contact-form-column">
                <form id="sizzle-contact-form" role="form">
                    <!-- IF MAIL SENT SUCCESSFULLY -->
                    <h4 class="success">
                        <i class="icon_check"></i> Your message has been sent successfully.
                    </h4>
                    <!-- IF MAIL SENDING UNSUCCESSFULL -->
                    <h4 class="error">
                        <i class="icon_error-circle_alt"></i> Unable to send message.
                    </h4>
                    <div class="col-md-12">
                        <input class="form-control input-box" id="contact-email" type="email" name="email"
                               placeholder="Your Email">
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control textarea-box" id="contact-message" name="message" rows="8"
                                  placeholder="Message"></textarea>
                    </div>
                    <button class="btn btn-primary btn-lg" id="send-message-button">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->
<script src="js/pricing.min.js?v=<?php echo VERSION; ?>"></script>
<script>
    $('h4.success').hide();
    $('h4.error').hide();
    $(document).ready(function () {
        // process contact form
        $('#send-message-button').on('click', function (e) {
            e.preventDefault();
            $.post("/ajax/sendemail", $('#sizzle-contact-form').serialize(),
                function (data, textStatus, jqXHR) {
                    if (data.status === "SUCCESS") {
                        $(".error").hide();
                        $(".success").show();
                    } else {
                        $(".success").hide();
                        $(".error").show();
                    }
                }
            ).fail(function () {
                $(".error").show();
            });
        });
    });
</script>

</body>
</html>
