<?php
/**
 * Kullanıcı avatar resmini döndürür.
 *
 * @param string $file Dosya adı
 * @return string
 */
function getAvatar($file)
{
    if (empty($file)) {
        return 'public/img/avatar.png';
    }

    return 'public/upload/user/avatar/'. $file;
}

