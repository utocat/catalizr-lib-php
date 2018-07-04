<?php


namespace Catalizr\Lib;

/**
 * Description of CatalizrSteam
 *
 * @author codati
 */
class CatalizrSteam {
    private $position;
    private $data;
    private $dataLenght;
    private $file;

    function stream_open($path, $mode, $options, &$opened_path)
    {
        $url = parse_url($path);
        $params=array();
        parse_str($url['query'],$params);

        $this->data =$params['data'];
        $this->position = 0;
        $this->file = fopen($url['path'],'r');
        $this->dataLenght = strlen($this->data);
        return true;
    }

    function stream_read($count)
    {
        $ret = "";
        if($this->dataLenght <= $this->position)// tombe uniquement dans le fichier
        {
            $ret= fread($this->file, $count);
        }else if(( $count + $this->position) > $this->dataLenght){// tombe a cheval entre les data et le fichier => concat

            $ret = substr($this->data, $this->position) . fread($this->file, $count - ($this->dataLenght - $this->position));

        }else{// tombe uniquement dans les data( le texte)
            $ret = substr($this->data, $this->position,$count);
        }

        //$ret = "123456789";
        //var_dump($count);
//        var_dump($this->position);
        $this->position += strlen($ret);
        return $ret;
    }


//    function stream_tell()
//    {
//        return $this->position;
//    }
//
    function stream_eof()
    {
        return feof($this->file);
    }
    function stream_close() {
        return fclose($this->file);
    }
//
//    function stream_seek($offset, $whence)
//    {
//        switch ($whence) {
//            case SEEK_SET:
//                if ($offset < strlen($GLOBALS[$this->varname]) && $offset >= 0) {
//                     $this->position = $offset;
//                     return true;
//                } else {
//                     return false;
//                }
//                break;
//
//            case SEEK_CUR:
//                if ($offset >= 0) {
//                     $this->position += $offset;
//                     return true;
//                } else {
//                     return false;
//                }
//                break;
//
//            case SEEK_END:
//                if (strlen($GLOBALS[$this->varname]) + $offset >= 0) {
//                     $this->position = strlen($GLOBALS[$this->varname]) + $offset;
//                     return true;
//                } else {
//                     return false;
//                }
//                break;
//
//            default:
//                return false;
//        }
//    }
//
//    function stream_metadata($path, $option, $var)
//    {
//        if($option == STREAM_META_TOUCH) {
//         $url = parse_url($path);
//               $varname = $url["host"];
//         if(!isset($GLOBALS[$varname])) {
//                $GLOBALS[$varname] = '';
//         }
//         return true;
//        }
//        return false;
//    }

   }
