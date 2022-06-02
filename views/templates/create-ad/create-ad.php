<?php include_once DIR_TEMPLATES . '/form/Form.php'; ?>
<div class="content__box content__box--form">

    <?php $form = Form::begin('content__box__form', '/create-ad', 'post', 'multipart/form-data') ?>
    <h2>Adaugă titlu anunț*</h2>
    <div class="label label--flex input-box">
        <input class="input-box__input" type="text" placeholder="Ex. Apartament 3 camere Copou Bloc Nou" name="title" required>
    </div>

    <!-- <div class="label label--flex input-box">
        <span class="icon icon-pin"></span>
        <input class="input-box__input" type="text" placeholder="Introdu locația*" name="address" required>
    </div> -->

    <?php
    //echo $form->field($model, 'title', 'Ex. Apartament 3 camere Copou Bloc Nou', 'TO DO: no icon field');
    echo $form->field($model, 'address', 'Introdu locația*', 'icon-pin');
    ?>

    <div class="content-filter">
        <?php echo View::render_template("Filter")
        ?>
    </div>

    <h2>Imagini</h2>

    <div class="images" id="images">
        <!-- max 5 imagini -->

        <label class="images__add-img image-container" id="add_file" onclick="">
            <span id="plus-icon" class="icon icon-plus"></span>
            <input type="file" id="image-input" accept="image/*" name="images[]"> </input>
        </label>

    </div>

    <h2>Descriere*</h2>
    <textarea class="desc" maxlength="4000" name="description" placeholder="Descriere" required></textarea>


    <button class="label label--flex label--important" type="submit" onclick>
        <span class="icon icon-conn-arr"></span>
        Creează anunț
    </button>

    <?php Form::end() ?>

</div>