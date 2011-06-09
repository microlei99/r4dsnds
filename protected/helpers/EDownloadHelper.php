<?php
/**
 *
 * EDownloadHelper Class
 *
 * @author Antonio Ramirez
 * @link www.ramirezcobos.com
 *
 * Example of Usage:
 *
 * // Import library (in protected.extensions.helpers)
 * Yii::import('ext.helpers.EDownloadHelper');
 *
 * // assumming I have a folder docs under my webroot folder
 * EDownloadHelper::download(Yii::getPathOfAlias('webroot.docs').DS.'myhugefile.zip');
 *
 * Inspired from an AwesomePHP.com tutorial
 * @link www.AwesomePHP.com
 *
 * @copyright
 *
 * Copyright (c) 2011 Antonio Ramirez Cobos
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */
class EDownloadHelper{

	public static $stream_types = array(
		'mp3','m3u','m4a','mid','ogg','ra','ram','wm',
        'wav','wma','aac','3gp','avi','mov','mp4','mpeg',
        'mpg','swf','wmv','divx','asf','exe','rar','zip');
	/**
	 *
	 * Download a file with resume, stream and speed options
	 *
	 * @param string $filename path to file including filename
	 * @param integer $speed maximum download speed
	 * @param boolean $doStream if stream or not
	 */
	public static function download( $filepath, $maxSpeed = 100, $doStream = false ){
		if(connection_status()!=0) return false;

		if(!file_exists($filepath) && is_file($filepath))
			throw new CException(Yii::t('EDownloadHelper','Filepath does not exists on specified location or is not a regular file'));

		$mimeType = CFileHelper::getMimeType( $filepath );
		$extension = CFileHelper::getExtension( $filepath );

		header("Cache-Control: public");
		header("Conent-Transfer-Encoding: binary\n");
		header("Content-Type: $mimeType");

		$contentDisposition = 'attachment';

		if($doStream == true){
	        if(in_array( $extension,self::$stream_types )){
	            $contentDisposition = 'inline';
        	}
	    }

	    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
	        $fileName= preg_replace('/\./', '%2e', $filepath, substr_count($filepath, '.') - 1);
	        header("Content-Disposition: $contentDisposition; filename=\"$filepath\"");
	    } else {
	        header("Content-Disposition: $contentDisposition; filename=\"$filepath\"");
	    }

	    header("Accept-Ranges: bytes");

	    $range = 0;

	    $size = @filesize($filepath);

	    if(isset($_SERVER['HTTP_RANGE'])) {

	        list($a, $range)=explode("=",$_SERVER['HTTP_RANGE']);
	        str_replace($range, "-", $range);
	        $size2=$size-1;
	        $new_length=$size-$range;
	        header("HTTP/1.1 206 Partial Content");
	        header("Content-Length: $new_length");
	        header("Content-Range: bytes $range$size2/$size");

	    } else {
	        $size2=$size-1;
	        header("Content-Range: bytes 0-$size2/$size");
	        header("Content-Length: ".$size);
	    }

	    if ($size == 0 ) { die(Yii::t('EDownloadHelper','Zero byte file! Aborting download'));}

	    set_magic_quotes_runtime(0);

	    $fp=fopen("$filepath","rb");

	    fseek($fp,$range);

	    while(!feof($fp) and (connection_status()==0))
	    {
	        set_time_limit(0);
	        print(fread($fp,1024*$maxSpeed));
	        flush();
	        ob_flush();
	        sleep(1);
	    }
	    fclose($fp);

	    return((connection_status()==0) and !connection_aborted());
	}
}

/*function downloadFile($fileLocation,$fileName,$maxSpeed = 100,$doStream =
false){
    if (connection_status()!=0) return(false);
    $extension = strtolower(end(explode('.',$fileName)));

    $fileTypes['swf'] = 'application/x-shockwave-flash';
    $fileTypes['pdf'] = 'application/pdf';
    $fileTypes['exe'] = 'application/octet-stream';
    $fileTypes['zip'] = 'application/zip';
    $fileTypes['doc'] = 'application/msword';
    $fileTypes['xls'] = 'application/vnd.ms-excel';
    $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
    $fileTypes['gif'] = 'image/gif';
    $fileTypes['png'] = 'image/png';
    $fileTypes['jpeg'] = 'image/jpg';
    $fileTypes['jpg'] = 'image/jpg';
    $fileTypes['rar'] = 'application/rar';

    $fileTypes['ra'] = 'audio/x-pn-realaudio';
    $fileTypes['ram'] = 'audio/x-pn-realaudio';
    $fileTypes['ogg'] = 'audio/x-pn-realaudio';

    $fileTypes['wav'] = 'video/x-msvideo';
    $fileTypes['wmv'] = 'video/x-msvideo';
    $fileTypes['avi'] = 'video/x-msvideo';
    $fileTypes['asf'] = 'video/x-msvideo';
    $fileTypes['divx'] = 'video/x-msvideo';

    $fileTypes['mp3'] = 'audio/mpeg';
    $fileTypes['mp4'] = 'audio/mpeg';
    $fileTypes['mpeg'] = 'video/mpeg';
    $fileTypes['mpg'] = 'video/mpeg';
    $fileTypes['mpe'] = 'video/mpeg';
    $fileTypes['mov'] = 'video/quicktime';
    $fileTypes['swf'] = 'video/quicktime';
    $fileTypes['3gp'] = 'video/quicktime';
    $fileTypes['m4a'] = 'video/quicktime';
    $fileTypes['aac'] = 'video/quicktime';
    $fileTypes['m3u'] = 'video/quicktime';

    $contentType = $fileTypes[$extension];


    header("Cache-Control: public");
    header("Content-Transfer-Encoding: binary\n");
    header('Content-Type: $contentType');

    $contentDisposition = 'attachment';

    if($doStream == true){
        /* extensions to stream
        $array_listen = array('mp3','m3u','m4a','mid','ogg','ra','ram','wm',
        'wav','wma','aac','3gp','avi','mov','mp4','mpeg','mpg','swf','wmv','divx','asf');
        if(in_array($extension,$array_listen)){
            $contentDisposition = 'inline';
        }
    }

    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        $fileName= preg_replace('/\./', '%2e', $fileName, substr_count($fileName,
'.') - 1);
        header("Content-Disposition: $contentDisposition;
filename=\"$fileName\"");
    } else {
        header("Content-Disposition: $contentDisposition;
filename=\"$fileName\"");
    }

    header("Accept-Ranges: bytes");
    $range = 0;
    $size = filesize($fileLocation);

    if(isset($_SERVER['HTTP_RANGE'])) {
        list($a, $range)=explode("=",$_SERVER['HTTP_RANGE']);
        str_replace($range, "-", $range);
        $size2=$size-1;
        $new_length=$size-$range;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range$size2/$size");
    } else {
        $size2=$size-1;
        header("Content-Range: bytes 0-$size2/$size");
        header("Content-Length: ".$size);
    }

    if ($size == 0 ) { die('Zero byte file! Aborting download');}
    set_magic_quotes_runtime(0);
    $fp=fopen("$fileLocation","rb");

    fseek($fp,$range);

    while(!feof($fp) and (connection_status()==0))
    {
        set_time_limit(0);
        print(fread($fp,1024*$maxSpeed));
        flush();
        ob_flush();
        sleep(1);
    }
    fclose($fp);

    return((connection_status()==0) and !connection_aborted());
}
*/
/* Implementation */
//downloadFile('fileLocation','fileName.ext',900,false);