<?php


class Image
{
    private $uploadInput = 'imageFile';
    private $downloadInput = 'imageUrl';
    private $tempPath = 'public/upload/temp/';
    private $uploadPath = 'public/upload/';
    private $defaultImage = null;
    private $minWidth = 0;
    private $minHeight = 0;
    private $processes = array();
    private $plupload = false;
    private $required = false;
    private $ci;



    public function __construct()
    {
        $this->ci =& get_instance();
    }


    public function save($defaultImage = null)
    {
        if (! empty($defaultImage)) {
            $this->defaultImage = $defaultImage;
        }

        if ($this->ci->input->post($this->downloadInput)) {
            $input = $this->ci->input->post($this->downloadInput);

            if ($this->required === false && empty($input)) {
                return (object) array('name' => $this->defaultImage);
            }

            $image = $this->download($this->ci->input->post($this->downloadInput));
        } else {
            if ($this->required === false && empty($_FILES[$this->uploadInput]['name'])) {
                return (object) array('name' => $this->defaultImage);
            }

            $image = $this->upload();
        }

        if ($image) {
            if ($this->checkSize($image)) {
                $this->process($image, $this->defaultImage);

                return $image;
            } else {
                $this->ci->utils->deleteFile($image->path);
            }
        }

        $this->reset();

        return false;
    }





    public function addProcess($path, $effects)
    {
        $this->processes[$path] = array(
            'path' => trim($path, '/') . '/',
            'effects' => $effects
        );
        return $this;
    }

    /**
     * Config dosyasındaki parametrelere göre resim kırpma işlemi yapar.
     *
     * @param object $image Codeigniter upload veri dizisi
     * @param null $deleteFile Silinecek dosya adı.
     * @return mixed
     */
    private function process($image, $deleteFile = null)
    {
        if (empty($this->processes)) {
            $this->ci->alert->set('error', 'Resim boyutları belirtilmemiş');
            $this->ci->utils->deleteFile($image->path);

            return false;
        }

        $this->ci->load->library('SimpleImage');

        foreach ($this->processes as $process) {
            if (! empty($deleteFile)) {
                $this->ci->utils->deleteFile($this->uploadPath . $process['path'] . $deleteFile);
            }

            if (! file_exists($this->uploadPath . $process['path'])) {
                mkdir($this->uploadPath . $process['path'], 0777, true);
            }

            $newImage = $this->ci->simpleimage->load($image->path);

            if (isset($process['effects'])) {
                foreach ($process['effects'] as $effect => $arguments) {
                    call_user_func_array([$newImage, $effect], $arguments);
                }
            }

            // İlk size da resim ismi değiştiğinden ikinci size da tekrardan isim değiştirilmez.
            if (file_exists($this->uploadPath . $process['path'] . $image->name)) {
                $image->name = str_replace($image->ext, '', $image->name) . uniqid() . $image->ext;
            }

            $newImage->save($this->uploadPath . $process['path'] . $image->name);
        }

        $this->ci->utils->deleteFile($image->path);
    }





    private function download($url)
    {
        $info = @getimagesize($url);

        if (empty($info)) {
            $this->ci->alert->set('error', 'Resim bilgisi alınamadı.');
            return false;
        }

        $mimes = array('image/png' => 'png', 'image/x-png' => 'png', 'image/jpg' => 'jpg' , 'image/jpe' => 'jpg', 'image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/gif' => 'gif');

        if (! isset($mimes[$info['mime']])){
            $this->ci->alert->set('error', 'Geçersiz resim dosyası.');
            return false;
        }


        $name = md5(microtime());
        $ext = '.'.$mimes[$info['mime']];
        $content = file_get_contents($url);

        file_put_contents($this->tempPath . $name . $ext, $content);

        return (object) array(
            'name' => $name . $ext,
            'path' => $this->tempPath . $name . $ext,
            'ext' => $ext,
            'width' => $info[0],
            'height' => $info[1]
        );
    }


    /**
     * Resim yükler
     * @return boolean
     */
    private function upload()
    {
        $this->ci->load->library('upload');
        $this->ci->upload->initialize([
            'upload_path' => $this->tempPath,
            'encrypt_name' => true,
            'allowed_types' => 'gif|jpg|png|jpeg'
        ]);

        if (! $this->ci->upload->do_upload($this->uploadInput)) {
            if ($this->plupload === true) {
                $this->ci->json(array(
                    'jsonrpc'	=> '2.0',
                    'error'		=> array('code' => '500', 'message' => $this->ci->upload->display_errors('', '')),
                    'id'		=> 'id'
                ));
            } else {
                $this->ci->alert->set('error', $this->ci->upload->display_errors('<div>&bull; ', '</div>'));
            }

            return false;

        }

        $data = $this->ci->upload->data();


        return (object) array(
            'name' => $data['file_name'],
            'path' => $data['full_path'],
            'ext' => $data['file_ext'],
            'width' => $data['image_width'],
            'height' => $data['image_height']
        );
    }


    /**
     * Upload işlemi sonrası config parametrelerine göre resim boyut kontrolü yapar.
     *
     * @param $image
     * @return bool
     */
    private function checkSize($image)
    {
        if ($image->width < $this->minWidth || $image->height < $this->minHeight) {
            if ($this->plupload === true) {
                $this->ci->json(array(
                    'jsonrpc'	=> '2.0',
                    'error'		=> array('code' => '500', 'message' => 'Resim boyutları en az '. $this->minWidth .'x'. $this->minHeight .'px olmalı.'),
                    'id'		=> 'id'
                ));
            } else {
                $this->ci->alert->set('error', '<div>&bull; Resim boyutları en az '. $this->minWidth .'x'. $this->minHeight .'px olmalı.</div>');
            }
            return false;
        }

        return true;
    }


    private function reset()
    {
        $this->uploadInput = 'imageFile';
        $this->downloadInput = 'imageUrl';
        $this->tempPath = 'public/upload/temp/';
        $this->uploadPath = 'public/upload/';
        $this->defaultImage = null;
        $this->minWidth = 0;
        $this->minHeight = 0;
        $this->processes = array();
        $this->plupload = false;
        $this->required = false;
    }




    public function required()
    {
        $this->required = true;
        return $this;
    }


    public function usePlupload()
    {
        $this->plupload = true;
        return $this;
    }


    public function setUploadInput($name)
    {
        $this->uploadInput = $name;
        return $this;
    }

    public function setDownloadInput($name)
    {
        $this->downloadInput = $name;
        return $this;
    }

    public function setDefaultImage($image)
    {
        $this->defaultImage = $image;
        return $this;
    }

    public function setInputs($uploadInput = null, $downloadInput = null)
    {
        if (! empty($uploadInput)) {
            $this->uploadInput = $uploadInput;
        }

        if (! empty($downloadInput)) {
            $this->downloadInput = $downloadInput;
        }

        return $this;
    }

    public function setTempPath($path)
    {
        $this->tempPath = $path;
        return $this;
    }

    public function setUploadPath($path)
    {
        $this->uploadPath = $path;
        return $this;
    }

    public function setMinWidth($size)
    {
        $this->minWidth = $size;
        return $this;
    }

    public function setMinHeight($size)
    {
        $this->minHeight = $size;
        return $this;
    }

    public function setMinSizes($width = null, $height = null)
    {
        if ($width > 0) {
            $this->minWidth = $width;
        }

        if ($height > 0) {
            $this->minHeight = $height;
        }

        return $this;
    }

}
