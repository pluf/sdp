<?php

/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Finds a driver
 *
 * @param string $type
 * @throws SDP_Exception_DriverNotFound
 * @return SDP_Driver
 */
function SDP_Shortcuts_GetDriverOr404($type)
{
    $items = SDP_Service::drivers();
    foreach ($items as $item) {
        if ($item->getType() === $type) {
            return $item;
        }
    }
    throw new SDP_Exception_DriverNotFound("Driver not found: " . $type);
}

function SDP_Shortcuts_GetLinkBySecureIdOr404 ($secure_id)
{
    $item = SDP_Link::getLinkBySecureId($secure_id);
    if ($item == null || $item->id <= 0) {
        throw new SDP_Exception_ObjectNotFound(
                "SDP link not found (link id:" . $secure_id . ")");
    }
    return $item;
}

function SDP_Shortcuts_GetTagByNameOr404 ($name)
{
    $q = new Pluf_SQL('name=%s', array(
            $name
    ));
    $item = new SDP_Tag();
    $item = $item->getList(array(
            'filter' => $q->gen()
    ));
    if (isset($item) && $item->count() == 1) {
        return $item[0];
    }
    if ($item->count() > 1) {
        Pluf_Log::error(
                sprintf('more than one tag exist with the name $s', $name));
        return $item[0];
    }
    throw new SDP_Exception_ObjectNotFound(
            "SDP tag not found (Tag name:" . $name . ")");
}

function SDP_Shortcuts_NormalizeItemPerPage ($request)
{
    $count = array_key_exists('_px_c', $request->REQUEST) ? intval($request->REQUEST['_px_c']) : 30;
    if($count > 30)
        $count = 30;
    return $count;
}

function SDP_Shortcuts_Mime2Ext ($mime_type)
{
    $Ext2Mime = array(
            'hqx' => array(
                    'application/mac-binhex40',
                    'application/mac-binhex',
                    'application/x-binhex40',
                    'application/x-mac-binhex40'
            ),
            'cpt' => 'application/mac-compactpro',
            'csv' => array(
                    'text/x-comma-separated-values',
                    'text/comma-separated-values',
                    'application/octet-stream',
                    'application/vnd.ms-excel',
                    'application/x-csv',
                    'text/x-csv',
                    'text/csv',
                    'application/csv',
                    'application/excel',
                    'application/vnd.msexcel',
                    'text/plain'
            ),
            'bin' => array(
                    'application/macbinary',
                    'application/mac-binary',
                    'application/octet-stream',
                    'application/x-binary',
                    'application/x-macbinary'
            ),
            'dms' => 'application/octet-stream',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'exe' => array(
                    'application/octet-stream',
                    'application/x-msdownload'
            ),
            'class' => 'application/octet-stream',
            'psd' => array(
                    'application/x-photoshop',
                    'image/vnd.adobe.photoshop'
            ),
            'so' => 'application/octet-stream',
            'sea' => 'application/octet-stream',
            'dll' => 'application/octet-stream',
            'oda' => 'application/oda',
            'pdf' => array(
                    'application/pdf',
                    'application/force-download',
                    'application/x-download',
                    'binary/octet-stream'
            ),
            'ai' => array(
                    'application/pdf',
                    'application/postscript'
            ),
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'mif' => 'application/vnd.mif',
            'xls' => array(
                    'application/vnd.ms-excel',
                    'application/msexcel',
                    'application/x-msexcel',
                    'application/x-ms-excel',
                    'application/x-excel',
                    'application/x-dos_ms_excel',
                    'application/xls',
                    'application/x-xls',
                    'application/excel',
                    'application/download',
                    'application/vnd.ms-office',
                    'application/msword'
            ),
            'ppt' => array(
                    'application/powerpoint',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.ms-office',
                    'application/msword'
            ),
            'pptx' => array(
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/x-zip',
                    'application/zip'
            ),
            'wbxml' => 'application/wbxml',
            'wmlc' => 'application/wmlc',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'dxr' => 'application/x-director',
            'dvi' => 'application/x-dvi',
            'gtar' => 'application/x-gtar',
            'gz' => 'application/x-gzip',
            'gzip' => 'application/x-gzip',
            'php' => array(
                    'application/x-httpd-php',
                    'application/php',
                    'application/x-php',
                    'text/php',
                    'text/x-php',
                    'application/x-httpd-php-source'
            ),
            'php4' => 'application/x-httpd-php',
            'php3' => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps' => 'application/x-httpd-php-source',
            'js' => array(
                    'application/x-javascript',
                    'text/plain'
            ),
            'swf' => 'application/x-shockwave-flash',
            'sit' => 'application/x-stuffit',
            'tar' => 'application/x-tar',
            'tgz' => array(
                    'application/x-tar',
                    'application/x-gzip-compressed'
            ),
            'z' => 'application/x-compress',
            'xhtml' => 'application/xhtml+xml',
            'xht' => 'application/xhtml+xml',
            'zip' => array(
                    'application/x-zip',
                    'application/zip',
                    'application/x-zip-compressed',
                    'application/s-compressed',
                    'multipart/x-zip'
            ),
            'rar' => array(
                    'application/x-rar',
                    'application/rar',
                    'application/x-rar-compressed'
            ),
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mpga' => 'audio/mpeg',
            'mp2' => 'audio/mpeg',
            'mp3' => array(
                    'audio/mpeg',
                    'audio/mpg',
                    'audio/mpeg3',
                    'audio/mp3'
            ),
            'aif' => array(
                    'audio/x-aiff',
                    'audio/aiff'
            ),
            'aiff' => array(
                    'audio/x-aiff',
                    'audio/aiff'
            ),
            'aifc' => 'audio/x-aiff',
            'ram' => 'audio/x-pn-realaudio',
            'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin',
            'ra' => 'audio/x-realaudio',
            'rv' => 'video/vnd.rn-realvideo',
            'wav' => array(
                    'audio/x-wav',
                    'audio/wave',
                    'audio/wav'
            ),
            'bmp' => array(
                    'image/bmp',
                    'image/x-bmp',
                    'image/x-bitmap',
                    'image/x-xbitmap',
                    'image/x-win-bitmap',
                    'image/x-windows-bmp',
                    'image/ms-bmp',
                    'image/x-ms-bmp',
                    'application/bmp',
                    'application/x-bmp',
                    'application/x-win-bitmap'
            ),
            'gif' => 'image/gif',
            'jpeg' => array(
                    'image/jpeg',
                    'image/pjpeg'
            ),
            'jpg' => array(
                    'image/jpeg',
                    'image/pjpeg'
            ),
            'jpe' => array(
                    'image/jpeg',
                    'image/pjpeg'
            ),
            'jp2' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'j2k' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'jpf' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'jpg2' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'jpx' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'jpm' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'mj2' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'mjp2' => array(
                    'image/jp2',
                    'video/mj2',
                    'image/jpx',
                    'image/jpm'
            ),
            'png' => array(
                    'image/png',
                    'image/x-png'
            ),
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'css' => array(
                    'text/css',
                    'text/plain'
            ),
            'html' => array(
                    'text/html',
                    'text/plain'
            ),
            'htm' => array(
                    'text/html',
                    'text/plain'
            ),
            'shtml' => array(
                    'text/html',
                    'text/plain'
            ),
            'txt' => 'text/plain',
            'text' => 'text/plain',
            'log' => array(
                    'text/plain',
                    'text/x-log'
            ),
            'rtx' => 'text/richtext',
            'rtf' => 'text/rtf',
            'xml' => array(
                    'application/xml',
                    'text/xml',
                    'text/plain'
            ),
            'xsl' => array(
                    'application/xml',
                    'text/xsl',
                    'text/xml'
            ),
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'avi' => array(
                    'video/x-msvideo',
                    'video/msvideo',
                    'video/avi',
                    'application/x-troff-msvideo'
            ),
            'movie' => 'video/x-sgi-movie',
            'doc' => array(
                    'application/msword',
                    'application/vnd.ms-office'
            ),
            'docx' => array(
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/zip',
                    'application/msword',
                    'application/x-zip'
            ),
            'dot' => array(
                    'application/msword',
                    'application/vnd.ms-office'
            ),
            'dotx' => array(
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/zip',
                    'application/msword'
            ),
            'xlsx' => array(
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/zip',
                    'application/vnd.ms-excel',
                    'application/msword',
                    'application/x-zip'
            ),
            'word' => array(
                    'application/msword',
                    'application/octet-stream'
            ),
            'xl' => 'application/excel',
            'eml' => 'message/rfc822',
            'json' => array(
                    'application/json',
                    'text/json'
            ),
            'pem' => array(
                    'application/x-x509-user-cert',
                    'application/x-pem-file',
                    'application/octet-stream'
            ),
            'p10' => array(
                    'application/x-pkcs10',
                    'application/pkcs10'
            ),
            'p12' => 'application/x-pkcs12',
            'p7a' => 'application/x-pkcs7-signature',
            'p7c' => array(
                    'application/pkcs7-mime',
                    'application/x-pkcs7-mime'
            ),
            'p7m' => array(
                    'application/pkcs7-mime',
                    'application/x-pkcs7-mime'
            ),
            'p7r' => 'application/x-pkcs7-certreqresp',
            'p7s' => 'application/pkcs7-signature',
            'crt' => array(
                    'application/x-x509-ca-cert',
                    'application/x-x509-user-cert',
                    'application/pkix-cert'
            ),
            'crl' => array(
                    'application/pkix-crl',
                    'application/pkcs-crl'
            ),
            'der' => 'application/x-x509-ca-cert',
            'kdb' => 'application/octet-stream',
            'pgp' => 'application/pgp',
            'gpg' => 'application/gpg-keys',
            'sst' => 'application/octet-stream',
            'csr' => 'application/octet-stream',
            'rsa' => 'application/x-pkcs7',
            'cer' => array(
                    'application/pkix-cert',
                    'application/x-x509-ca-cert'
            ),
            '3g2' => 'video/3gpp2',
            '3gp' => array(
                    'video/3gp',
                    'video/3gpp'
            ),
            'mp4' => 'video/mp4',
            'm4a' => 'audio/x-m4a',
            'f4v' => array(
                    'video/mp4',
                    'video/x-f4v'
            ),
            'flv' => 'video/x-flv',
            'webm' => 'video/webm',
            'aac' => 'audio/x-acc',
            'm4u' => 'application/vnd.mpegurl',
            'm3u' => 'text/plain',
            'xspf' => 'application/xspf+xml',
            'vlc' => 'application/videolan',
            'wmv' => array(
                    'video/x-ms-wmv',
                    'video/x-ms-asf'
            ),
            'au' => 'audio/x-au',
            'ac3' => 'audio/ac3',
            'flac' => 'audio/x-flac',
            'ogg' => array(
                    'audio/ogg',
                    'video/ogg',
                    'application/ogg'
            ),
            'kmz' => array(
                    'application/vnd.google-earth.kmz',
                    'application/zip',
                    'application/x-zip'
            ),
            'kml' => array(
                    'application/vnd.google-earth.kml+xml',
                    'application/xml',
                    'text/xml'
            ),
            'ics' => 'text/calendar',
            'ical' => 'text/calendar',
            'zsh' => 'text/x-scriptzsh',
            '7zip' => array(
                    'application/x-compressed',
                    'application/x-zip-compressed',
                    'application/zip',
                    'multipart/x-zip'
            ),
            'cdr' => array(
                    'application/cdr',
                    'application/coreldraw',
                    'application/x-cdr',
                    'application/x-coreldraw',
                    'image/cdr',
                    'image/x-cdr',
                    'zz-application/zz-winassoc-cdr'
            ),
            'wma' => array(
                    'audio/x-ms-wma',
                    'video/x-ms-asf'
            ),
            'jar' => array(
                    'application/java-archive',
                    'application/x-java-application',
                    'application/x-jar',
                    'application/x-compressed'
            ),
            'svg' => array(
                    'image/svg+xml',
                    'application/xml',
                    'text/xml'
            ),
            'vcf' => 'text/x-vcard',
            'srt' => array(
                    'text/srt',
                    'text/plain'
            ),
            'vtt' => array(
                    'text/vtt',
                    'text/plain'
            ),
            'ico' => array(
                    'image/x-icon',
                    'image/x-ico',
                    'image/vnd.microsoft.icon'
            ),
            'odc' => 'application/vnd.oasis.opendocument.chart',
            'otc' => 'application/vnd.oasis.opendocument.chart-template',
            'odf' => 'application/vnd.oasis.opendocument.formula',
            'otf' => 'application/vnd.oasis.opendocument.formula-template',
            'odg' => 'application/vnd.oasis.opendocument.graphics',
            'otg' => 'application/vnd.oasis.opendocument.graphics-template',
            'odi' => 'application/vnd.oasis.opendocument.image',
            'oti' => 'application/vnd.oasis.opendocument.image-template',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
            'otp' => 'application/vnd.oasis.opendocument.presentation-template',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'odm' => 'application/vnd.oasis.opendocument.text-master',
            'ott' => 'application/vnd.oasis.opendocument.text-template',
            'oth' => 'application/vnd.oasis.opendocument.text-web'
    );
    // TODO: mahdi: As you may notice the following variable must be completed
    // with
    // accordance to above variable.
    $Mime2Ext = array(
            'application/msword' => 'doc',
            'application/mac-compactpro' => 'cpt',
            'application/octet-stream' => 'csr',
            'application/oda' => 'oda',
            'application/postscript' => 'ps',
            'application/smil' => 'smil',
            'application/vnd.mif' => 'mif',
            'application/wbxml' => 'wbxml',
            'application/wmlc' => 'wmlc',
            'application/x-director' => 'dxr',
            'application/x-dvi' => 'dvi',
            'application/x-gtar' => 'gtar',
            'application/x-gzip' => 'gzip',
            'application/x-httpd-php' => 'phtml',
            'application/x-httpd-php-source' => 'phps',
            'application/x-shockwave-flash' => 'swf',
            'application/x-stuffit' => 'sit',
            'application/x-tar' => 'tar',
            'application/x-compress' => 'z',
            'application/xhtml+xml' => 'xht',
            'audio/midi' => 'midi',
            'audio/mpeg' => 'mp2',
            'audio/x-aiff' => 'aifc',
            'audio/x-pn-realaudio' => 'rm',
            'audio/x-pn-realaudio-plugin' => 'rpm',
            'audio/x-realaudio' => 'ra',
            'video/vnd.rn-realvideo' => 'rv',
            'image/gif' => 'gif',
            'image/tiff' => 'tif',
            'text/plain' => 'm3u',
            'text/richtext' => 'rtx',
            'text/rtf' => 'rtf',
            'video/mpeg' => 'mpe',
            'video/quicktime' => 'mov',
            'video/x-sgi-movie' => 'movie',
            'application/excel' => 'xl',
            'message/rfc822' => 'eml',
            'application/x-pkcs12' => 'p12',
            'application/x-pkcs7-signature' => 'p7a',
            'application/x-pkcs7-certreqresp' => 'p7r',
            'application/pkcs7-signature' => 'p7s',
            'application/x-x509-ca-cert' => 'der',
            'application/pgp' => 'pgp',
            'application/gpg-keys' => 'gpg',
            'application/x-pkcs7' => 'rsa',
            'video/3gpp2' => '3g2',
            'video/mp4' => 'mp4',
            'audio/x-m4a' => 'm4a',
            'video/x-flv' => 'flv',
            'video/webm' => 'webm',
            'audio/x-acc' => 'aac',
            'application/vnd.mpegurl' => 'm4u',
            'application/xspf+xml' => 'xspf',
            'application/videolan' => 'vlc',
            'audio/x-au' => 'au',
            'audio/ac3' => 'ac3',
            'audio/x-flac' => 'flac',
            'text/calendar' => 'ical',
            'text/x-scriptzsh' => 'zsh',
            'text/x-vcard' => 'vcf',
            'application/pdf' => 'pdf',
            'application/force-download' => 'pdf',
            'application/x-download' => 'pdf',
            'binary/octet-stream' => 'pdf',
            'application/vnd.oasis.opendocument.chart' => 'odc',
            'application/vnd.oasis.opendocument.chart-template' => 'otc',
            'application/vnd.oasis.opendocument.formula' => 'odf',
            'application/vnd.oasis.opendocument.formula-template' => 'otf',
            'application/vnd.oasis.opendocument.graphics' => 'odg',
            'application/vnd.oasis.opendocument.graphics-template' => 'otg',
            'application/vnd.oasis.opendocument.image' => 'odi',
            'application/vnd.oasis.opendocument.image-template' => 'oti',
            'application/vnd.oasis.opendocument.presentation' => 'odp',
            'application/vnd.oasis.opendocument.presentation-template' => 'otp',
            'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
            'application/vnd.oasis.opendocument.spreadsheet-template' => 'ots',
            'application/vnd.oasis.opendocument.text' => 'odt',
            'application/vnd.oasis.opendocument.text-master' => 'odm',
            'application/vnd.oasis.opendocument.text-template' => 'ott',
            'application/vnd.oasis.opendocument.text-web' => 'oth',
            'application/x-zip' => 'zip',
            'application/zip' => 'zip',
            'application/x-zip-compressed' => 'zip',
            'application/s-compressed' => 'zip',
            'multipart/x-zip' => 'zip',
            'image/jpeg' => 'jpeg',
            'image/pjpeg' => 'jpeg',
            'image/jpeg' => 'jpg',
            'image/pjpeg' => 'jpg'
    );
    if (! array_key_exists($mime_type, $Mime2Ext)) {
        return '';
    }
    return $Mime2Ext[$mime_type];
}