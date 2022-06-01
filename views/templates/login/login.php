<?php include_once DIR_TEMPLATES . '/form/Form.php'; ?>
<div class="content__box content__box--form">

    <h2>Conectează-te</h2>
    <button class="label label--flex label--social label--social--google" type="button" onclick>
        <span class="icon icon-google"></span>
        Conectează-te cu contul tău Google
    </button>

    <button class="label label--flex label--social label--social--facebook" type="button" onclick>
        <span class="icon icon-facebook"></span>
        Conectează-te cu contul tău Facebook
    </button>
    <?php $form = Form::begin('content__box__form', '/login', 'post') ?>
    <!-- <form class="content__box__form" action="/login" method="post"> -->

    <p>Completeaza campurile de mai jos pentru a te conecta.</p>
    <?php //echo $form->field($model, 'email_or_phone', 'E-mail sau Telefon') 
    ?>
    <div class="label label--flex input-box">
        <span class="icon icon-person"></span>
        <input class="input-box__input" type="text" placeholder="E-mail sau Telefon" name="email_or_phone" required>
    </div>

    <div class="label label--flex input-box">
        <span class="icon icon-pass"></span>
        <input class="input-box__input" type="password" placeholder="Introdu parola" name="password" required>
    </div>

    <p> <a class="hlink" href="#">Ați uitat parola?</a></p>

    <p>Nu ai cont?
        <a class="hlink" href="/register"> Creează-ți cont</a>
    </p>

    <p class="term-and-cond__paragraph">Prin actiunea de conectare esti de acord cu
        <a class="hlink" href="#">Termenii și Condițiile</a>, cât și
        <a class="hlink" href="#">Politica de confidentialitate</a>
    </p>

    <button class="label label--flex label--important" type="submit" onclick>
        <span class="icon icon-conn-arr"></span>
        Conectare
    </button>

    <?php Form::end() ?>
</div>