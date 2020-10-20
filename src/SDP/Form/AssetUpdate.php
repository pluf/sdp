<?php

/**
 * Updates information of an asset
 * 
 * The following field could be updated for an asset:
 * - title: optional
 * - media_type: optional.
 * - description: optional.
 * - price: optional. default is 0.
 * - parent_id: optional.
 * - content_id: optional.
 * - cover: optional. A link to an image as the cover of the asset.
 * 
 * If asset is not local (drive_id is not 0) the following fields could be determined also:
 * - path: optional. empty means root ot drive.
 * - size
 * - file_name: name of file (contain its extension)
 *
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *
 */
class SDP_Form_AssetUpdate extends Pluf_Form
{

    public $asset = null;

    public function initFields($extra = array())
    {
        $this->asset = $extra['asset'];

        $this->fields['title'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Title of Asset',
            'initial' => $this->asset->title,
            'help_text' => 'Title of Asset'
        ));
        $this->fields['media_type'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Medial Type',
            'initial' => $this->asset->media_type,
            'help_text' => 'Media Type of Asset'
        ));
        $this->fields['description'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'description of Asset',
            'initial' => $this->asset->description,
            'help_text' => 'description of Asset'
        ));

        $this->fields['parent_id'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Parent',
            'initial' => $this->asset->parent_id,
            'help_text' => 'Parent of asset'
        ));
        $this->fields['price'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Price',
            'initial' => $this->asset->price,
            'help_text' => 'Price of asset'
        ));
//         $this->fields['content_id'] = new Pluf_Form_Field_Integer(array(
//             'required' => false,
//             'label' => 'content id of Asset',
//             'initial' => $this->asset->content_id,
//             'help_text' => 'content of Asset'
//         ));
        $this->fields['cover'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'cover of Asset',
            'initial' => $this->asset->cover,
            'help_text' => 'Cover of Asset'
        ));

        if ($this->asset->isLocal()) { // Asset is local
            $this->fields['file'] = new Pluf_Form_Field_File(array(
                'required' => false,
                'max_size' => Pluf::f('upload_max_size', 52428800), // default value: 50 MB
                'move_function_params' => array(
                    'upload_path' => Pluf::f('upload_path') . '/' . Pluf_Tenant::getCurrent()->id . '/sdp',
                    'file_name' => $this->asset->id,
                    'upload_path_create' => true,
                    'upload_overwrite' => true
                )
            ));
        } else { // Asset is not local
            $this->fields['path'] = new Pluf_Form_Field_Varchar(array(
                'required' => false,
                'label' => 'Path of Asset',
                'initial' => $this->asset->path,
                'help_text' => 'Path of Asset'
            ));
            $this->fields['size'] = new Pluf_Form_Field_Integer(array(
                'required' => false,
                'label' => 'Size of Asset',
                'initial' => $this->asset->size,
                'help_text' => 'Size of Asset'
            ));
            $this->fields['file_name'] = new Pluf_Form_Field_Varchar(array(
                'required' => false,
                'label' => 'File Name of Asset',
                'initial' => $this->asset->file_name,
                'help_text' => 'Name of the file of asset contain extension'
            ));
        }
    }

    function update($commit = true)
    {
        if (! $this->isValid()) {
            throw new \Pluf\Exception('cannot save the content from an invalid form');
        }
        // update the asset
        $this->asset->setFromFormData($this->cleaned_data);

        if ($this->asset->isLocal() && array_key_exists('file', $this->data)) {
            // Extract information of file
            $myFile = $this->data['file'];
            $this->asset->mime_type = $myFile['type'];
            $this->asset->file_name = $myFile['name'];
            // set mime type if not defined
            if(!array_key_exists('mime_type', $this->data)){
                $mimeType = Pluf_FileUtil::getMimeType($this->asset->file_name);
                if(is_array($mimeType)){
                    $mimeType = $mimeType[0];
                }
                $this->asset->mime_type = $mimeType;
            }
        }

        if (! $this->asset->isLocal() && strlen($this->asset->file_name) > 0) {
            // Extract MIME type from file name
            $fileInfo = Pluf_FileUtil::getMimeType($this->asset->file_name);
            $this->asset->mime_type = $fileInfo[0];
        }

        if ($commit) {
            $this->asset->update();
        }
        return $this->asset;
    }

    function clean_title()
    {
        $fileName = $this->cleaned_data['title'] ? $this->cleaned_data['title'] : $this->asset->title;
        if (! $fileName) {
            return array_key_exists('file', $this->data) ? $this->data['file']['name'] : $this->asset->title;
        }
        return $fileName;
    }
}
