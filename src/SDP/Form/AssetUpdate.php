<?php

/**
 * Updates information of an asset
 * 
 * The following field could be updated for an asset:
 * - name: optional
 * - type: optional. default is 'file'
 * - description: optional.
 * - price: optional. default is 0.
 * - parent: optional.
 * - content: optional.
 * - thumbnail: optional.
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

        $this->fields['name'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Name of Asset',
            'initial' => $this->asset->name,
            'help_text' => 'Name of Asset'
        ));
        $this->fields['type'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'type of Asset',
            'initial' => $this->asset->type,
            'help_text' => 'type of Asset'
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
        $this->fields['content_id'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'content id of Asset',
            'initial' => $this->asset->content_id,
            'help_text' => 'content of Asset'
        ));
        $this->fields['thumbnail'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'thumbnail of Asset',
            'initial' => $this->asset->thumbnail,
            'help_text' => 'thumbnail of Asset'
        ));

        if ($this->asset->isLocal()) { // Asset is local
            $this->fields['file'] = new Pluf_Form_Field_File(array(
                'required' => false,
                'max_size' => Pluf::f('upload_max_size', 52428800), // default value: 50 MB
                'move_function_params' => array(
                    'upload_path' => Pluf::f('upload_path') . '/' . Pluf_Tenant::current()->id . '/sdp',
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
            throw new Pluf_Exception('cannot save the content from an invalid form');
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

    function clean_name()
    {
        $fileName = $this->asset->name ? $this->asset->name : $this->cleaned_data['name'];
        if (! $fileName) {
            return array_key_exists('file', $this->data) ? $this->data['file']['name'] : $this->asset->name;
        }
        return $fileName;
    }
}
