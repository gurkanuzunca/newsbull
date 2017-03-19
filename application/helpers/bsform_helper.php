<?php


function bsFormText($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $disabled = ! empty($arguments['disabled']) ? 'disabled="disabled"' : '';
    $readonly = ! empty($arguments['readonly']) ? 'readonly="readonly"' : '';


    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <input type="text" class="form-control '. $class .'" name="'. $name .'" id="'. $name .'" '. $required .' value="'. htmlspecialchars($value) .'" '. $disabled .' '. $readonly .'>
    </div>';

}

function bsFormNumber($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $disabled = ! empty($arguments['disabled']) ? 'disabled="disabled"' : '';
    $readonly = ! empty($arguments['readonly']) ? 'readonly="readonly"' : '';


    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <input type="number" class="form-control '. $class .'" name="'. $name .'" id="'. $name .'" '. $required .' value="'. htmlspecialchars($value) .'" '. $disabled .' '. $readonly .'>
    </div>';

}

function bsFormPassword($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $disabled = ! empty($arguments['disabled']) ? 'disabled="disabled"' : '';
    $readonly = ! empty($arguments['readonly']) ? 'readonly="readonly"' : '';

    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <input type="password" class="form-control '. $class .'" name="'. $name .'" id="'. $name .'" '. $required .' value="'. $value .'" '. $disabled .' '. $readonly .'>
    </div>';

}

function bsFormDropdown($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $options = ! empty($arguments['options']) ? $arguments['options'] : array();
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $disabled = ! empty($arguments['disabled']) ? 'disabled="disabled"' : '';
    $readonly = ! empty($arguments['readonly']) ? 'readonly="readonly"' : '';

    $drowndown = form_dropdown($name, $options, $value, 'class="form-control '. $class .'" '. $required .' id="'. $name .'" '. $disabled .' '. $readonly .'');

    return '<div class="form-group"><label for="'. $name .'">'. $title .'</label>'. $drowndown .'</div>';
}

function bsFormTextarea($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $rows = ! empty($arguments['rows']) ? $arguments['rows'] : 5;
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $disabled = ! empty($arguments['disabled']) ? 'disabled="disabled"' : '';
    $readonly = ! empty($arguments['readonly']) ? 'readonly="readonly"' : '';

    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <textarea class="form-control '. $class .'" name="'. $name .'" id="'. $name .'" '. $required .' rows="'. $rows .'" '. $disabled .' '. $readonly .'>'. $value .'</textarea>
    </div>';
}

function bsFormEditor($name, $title, $arguments = array())
{
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);

    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <textarea class="ckeditor" name="'. $name .'" id="'. $name .'">'. $value .'</textarea>
    </div>';
}


function bsFormFile($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) && ! empty($arguments['path']) ? $arguments['path'] . $arguments['value'] : '';
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $download = ! empty($value) ? '<a class="btn btn-success btn-sm" href="'. $value .'">Dosyayı İndir</a>' : '';

    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    '.$download.'
    <input class="filestyle '. $class .'" type="file" name="'. $name .'" id="'. $name .'" '. $required .' " data-buttonText="Dosya Seçin" data-icon="false" />
    </div>';
}


function bsFormImage($name, $title, $arguments = array())
{
    $value = ! empty($arguments['value']) && ! empty($arguments['path']) ? rtrim($arguments['path'], '/'). '/'. $arguments['value'] : 'public/admin/img/noimage.jpg';
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';

    return '<div class="form-group">
    <label for="'. $name .'">'. $title .'</label>
    <div class="row">
        <div class="col-md-3">
        <img class="img-responsive img-thumbnail" src="'. $value .'" />
        </div>
        <div class="col-md-9">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#computer" data-toggle="tab">Bilgisayarımdan</a></li>
                <li><a href="#internet" data-toggle="tab">İnternetten</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="computer">
                    <p>Bilgisayarınızdan resim seçin.</p>
                    <input class="filestyle" type="file" name="'. $name .'File" data-buttonText="Resim Seçin" data-icon="false">
                </div>
                <div class="tab-pane" id="internet">
                    <p>Resim adresini (url) yazın.</p>
                    <input type="text" class="form-control" name="'. $name .'Url">
                </div>
            </div>
        </div>
    </div>
    </div>';
}



function bsFormDatetime($name, $title, $arguments = array())
{
    $required = ! empty($arguments['required']) ? 'required="required"' : '';
    $value = ! empty($arguments['value']) ? $arguments['value'] : set_value($name);
    $class = ! empty($arguments['class']) ? $arguments['class'] : '';
    $format = ! empty($arguments['format']) ? 'data-date-format="'. $arguments['format'] .'"' : '';
    $clear = ! empty($arguments['clear']) ? '<span class="input-group-addon btn"><i class="fa fa-times icon-remove"></i></span>' : '';

    return '<div class="form-group">
        <label for="'. $name .'">'. $title .'</label>
        <div class="input-group datetimepicker date" '. $format .'>
            <span class="input-group-addon btn"><i class="fa fa-calendar"></i></span>
            <input name="'. $name.'" id="'. $name .'" type="text" class="form-control '. $class .'" readonly="readonly" value="'. $value .'" '. $required .'>
            '. $clear .'
        </div>
    </div>';
}