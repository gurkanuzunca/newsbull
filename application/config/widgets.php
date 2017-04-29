<?php

$config['widgets'] = array(
    array(
        'module' => 'comment',
        'table' => 'comments',
        'type'	=> 'app app-success',
        'where' => array('status' => 'unpublished'),
        'info' => 'Yayında Değil'
    ),
    array(
        'module' => 'news',
        'table' => 'news',
        'type'	=> 'app app-success',
        'where' => array('status' => 'unpublished'),
        'info' => 'Yayında Değil'
    ),
    array(
        'module' => 'gallery',
        'table' => 'galleries',
        'type'	=> 'app app-success',
        'where' => array('status' => 'unpublished'),
        'info' => 'Yayında Değil'
    ),
    array(
        'module' => 'category',
        'table' => 'categories',
        'type'	=> 'app app-primary',
        'where' => array('status' => 'unpublished'),
        'info' => 'Yayında Değil'
    )
);
