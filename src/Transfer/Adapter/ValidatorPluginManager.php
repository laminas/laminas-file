<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\File\Transfer\Adapter;

use Laminas\Validator\ValidatorPluginManager as BaseManager;

class ValidatorPluginManager extends BaseManager
{
    protected $aliases = array(
        'count'            =>'filecount',
        'crc32'            =>'filecrc32',
        'excludeextension' =>'fileexcludeextension',
        'excludemimetype'  =>'fileexcludemimetype',
        'exists'           =>'fileexists',
        'extension'        =>'fileextension',
        'filessize'        =>'filefilessize',
        'hash'             =>'filehash',
        'imagesize'        =>'fileimagesize',
        'iscompressed'     =>'fileiscompressed',
        'isimage'          =>'fileisimage',
        'md5'              =>'filemd5',
        'mimetype'         =>'filemimetype',
        'notexists'        =>'filenotexists',
        'sha1'             =>'filesha1',
        'size'             =>'filesize',
        'upload'           =>'fileupload',
        'wordcount'        =>'filewordcount',
    );
}
