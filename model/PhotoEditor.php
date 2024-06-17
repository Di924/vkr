<?php

class PhotoEditor
    {
        // объявление свойства
        public $filename;
        public $source;
        public $target;
        public $images_folder;
        public $saveto;
        public $w_src; // ширина
        public $h_src; // высота
        public $w = 200; // по умолчанию сжимает до 200х200
        public $dest;
        public $type;
        public $im;
        public $date;

        // объявление метода
        public function __construct(string $images_folder){
            $this->images_folder = $images_folder;
            $this->filename = $_FILES['image']['name'];
            $this->source = $_FILES['image']['tmp_name'];
            $this->target = $this->images_folder . $this->filename;
            move_uploaded_file($this->source, $this->target);
            if(preg_match('/[.](GIF)|(gif)$/', $this->filename)) {
                $this->im = imagecreatefromgif($this->images_folder.$this->filename) ; //если оригинал в формате gif
                $this->type = 'gif';
                }
                if(preg_match('/[.](PNG)|(png)$/', $this->filename)) {
                $this->im = imagecreatefrompng($this->images_folder.$this->filename) ;//если оригинал в формате png
                $this->type = 'png';
                }
                if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $this->filename)) {
                    $this->im = imagecreatefromjpeg($this->images_folder.$this->filename); //если оригинал в формате jpg
                    $this->type = 'jpg';
                }
                $this->w_src = imagesx($this->im); // ширина
                $this->h_src = imagesy($this->im); // высота
            }
            public function createFoto(int $w = 200) {
                $this->w = $w;
                // создаём пустую квадратную картинку 
                // важно именно truecolor!, иначе будем иметь 8-битный результат 
                $this->dest = imagecreatetruecolor($this->w,$this->w); 

                // вырезаем квадратную серединку по x, если фото горизонтальное 
                if ($this->w_src>$this->h_src) 
                imagecopyresampled($this->dest, $this->im, 0, 0,
                                round((max($this->w_src,$this->h_src)-min($this->w_src,$this->h_src))/2),
                                0, $this->w, $this->w, min($this->w_src,$this->h_src), min($this->w_src,$this->h_src)); 

                // вырезаем квадратную верхушку по y, 
                // если фото вертикальное (хотя можно тоже серединку) 
                if ($this->w_src<$this->h_src) 
                imagecopyresampled($this->dest, $this->im, 0, 0, 0, 0, $this->w, $this->w,
                                min($this->w_src,$this->h_src), min($this->w_src,$this->h_src)); 

                // квадратная картинка масштабируется без вырезок 
                if ($this->w_src==$this->h_src) 
                imagecopyresampled($this->dest, $this->im, 0, 0, 0, 0, $this->w, $this->w, $this->w_src, $this->w_src); 
                

                $this->date=time(); //вычисляем время в настоящий момент.
                $this->saveto = $_SESSION['login'] . $this->date . $this->filename;

                #imagejpeg($dest, $images_folder.$saveto); 
                if ($this->type == 'png') {
                    imagepng($this->dest, $this->images_folder . $this->saveto); 
                } else if($this->type = 'gif'){
                    imagegif($this->dest, $this->images_folder . $this->saveto); 
                } else{
                    imagejpeg($this->dest, $this->images_folder . $this->saveto, 100); 
                }

                $delfull = $this->images_folder.$this->filename; // получаем адрес исходника
                unlink ($delfull);
            }
            public function getNameFoto() {
                return($this->saveto);
            }
    }
    ?>