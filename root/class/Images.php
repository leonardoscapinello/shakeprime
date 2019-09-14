<?php

class Images Extends Settings
{

    private $server;
    private $images_path;
    private $image;
    private $legend;
    private $extension;

    public function __construct()
    {
        $this->server = $this->getValue("SERVER_URL");
        $this->images_path = $this->getValue("IMAGES_PATH");
    }

    private function setServer($server)
    {
        $this->server = $server;
    }

    private function setExtension()
    {
        try {
            global $url;
            $image_path = $this->getCompleteURL();
            $url->setURL($this->getCompleteURL());
            if (file_exists($image_path)) {
                if ($url->URLExists()) {
                    $this->extension = $this->translateImageType(exif_imagetype($image_path));
                }
            }
        } catch (Exception $exception) {

        } finally {
            return "png";
        }

    }

    private function getExtension()
    {
        $this->setExtension();
        return $this->extension;
    }

    private function getCompleteURL()
    {
        $complete_url = $this->server;
        $complete_url .= $this->images_path;
        $complete_url .= $this->image;

        if (strpos($this->image, "http") !== false) {
            return $this->image;
        }
        return $complete_url;

    }

    private function createImageTag($image, $legend, $width = 0, $height = 0, $class = null, $id, $style)
    {
        $this->image = $image;
        $image_source = $this->convertImageToBase64();
        $getWidth = $this->getImageWidth();
        $getHeight = $this->getImageHeight();
        if ($width <= 0) {
            $width = $getWidth;
        }
        if ($height <= 0) {
            $height = $getHeight;
        }
        if ($class !== null) {
            $class = "class=\"" . $class . "\"";
        }
        if ($id !== null) {
            $id = "id=\"" . $id . "\"";
        }
        if ($style !== null) {
            $style = "style=\"" . $style . "\"";
        }

        if (strtolower($width) == "noresize" || strtolower($height) == "noresize") {
            $width = "width=\"" . $width . "\"";
            $height = "height=\"" . $height . "\"";
        }

        $tag = "<img src=\"" . $image_source . "\" " . $width . " " . $height . "  alt=\"" . $legend . "\" " . $class . " " . $id . " " . $style . "/>";
        return $tag;
    }


    /**
     * @param $image_array
     *      source = URL of this image
     *      legend = "Alt attribute of this image
     *      width = custom width of this image
     *      height = custom height of this image
     */
    public function printImage($image_array)
    {
        try {

            $image = $legend = $width = $height = $class = $id = $style = null;

            if (array_key_exists("source", $image_array)) {
                $image = $image_array['source'];
            }
            if (array_key_exists("legend", $image_array)) {
                $legend = $image_array['legend'];
            }
            if (array_key_exists("width", $image_array)) {
                $width = $image_array['width'];
            }
            if (array_key_exists("height", $image_array)) {
                $height = $image_array['height'];
            }
            if (array_key_exists("class", $image_array)) {
                $class = $image_array['class'];
            }
            if (array_key_exists("id", $image_array)) {
                $id = $image_array['id'];
            }
            if (array_key_exists("style", $image_array)) {
                $style = $image_array['style'];
            }
            if ($image !== null && $legend !== null) {
                if ($width == null) {
                    $width = 0;
                }
                if ($height == null) {
                    $height = 0;
                }
                echo $this->createImageTag($image, $legend, $width, $height, $class, $id, $style);
            }

        } catch (Exception $exception) {

        }
    }

    private function getImageContents()
    {
        global $url;
        $image = $this->getCompleteURL();
        $url->setURL($image);
        if ($url->URLExists()) {
            return $url->getURLContents();
        }
        return null;
    }


    private function convertImageToBase64()
    {
        global $encoding;
        $content = $this->getImageContents();
        if ($content !== null) {
            $init = "data:image/{type};base64,{image_base64}";
            $init = str_replace("{type}", $this->getExtension(), $init);
            $init = str_replace("{image_base64}", $encoding->encode($content), $init);
            return $init;
        }
        return "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    }

    private function getImageWidth()
    {
        global $url;
        $url->setURL($this->getCompleteURL());
        if ($url->URLExists()) {
            list($width, $height) = getimagesize($this->getCompleteURL());
            return $width;
        }
        return 0;
    }

    private function getImageHeight()
    {
        global $url;
        $url->setURL($this->getCompleteURL());
        if ($url->URLExists()) {
            list($width, $height) = getimagesize($this->getCompleteURL());
            return $height;
        }
        return 0;
    }


    private function translateImageType($image_type)
    {

        $types = array(
            "1" => "gif",
            "2" => "jpeg",
            "3" => "png",
            "4" => "swf",
            "5" => "psd",
            "6" => "bmp",
            "7" => "tiff",
            "8" => "tiff",
            "9" => "jpc",
            "10" => "jp2",
            "11" => "jpx",
            "12" => "jb2",
            "13" => "swc",
            "14" => "iff",
            "15" => "wbmp",
            "16" => "xbm",
        );

        return $types[$image_type];

    }


}