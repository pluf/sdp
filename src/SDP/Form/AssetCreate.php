<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

/**
 * Creates a new asset
 *
 * Following fields could be determined to create a new asset:
 * - name: optional
 * - media_type: optional.
 * - description: optional.
 * - price: optional. default is 0.
 * - parent_id: optional.
 * - content_id: optional.
 * - cover: optional. link to an image as the cover of the asset
 * - drive_id: optional.
 *
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *        
 */
class SDP_Form_AssetCreate extends Pluf_Form
{

    private $userRequest = null;

    public function initFields($extra = array())
    {
        $this->userRequest = $extra['request'];

        $this->fields['name'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Name',
            'help_text' => 'Name of asset'
        ));
        $this->fields['media_type'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Media Type',
            'help_text' => 'Media type of asset'
        ));
        $this->fields['parent_id'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Folder',
            'help_text' => 'Folder of asset'
        ));
        $this->fields['description'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'Description',
            'help_text' => 'Description of asset'
        ));
        $this->fields['price'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Price',
            'help_text' => 'Price of asset'
        ));
        $this->fields['content_id'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Content',
            'help_text' => 'Content related to asset'
        ));
        $this->fields['cover'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Cover',
            'help_text' => 'Cover image of the asset'
        ));
        $this->fields['drive_id'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Drive',
            'help_text' => 'Drive to store asset'
        ));

    }

    function save($commit = true)
    {
        if (! $this->isValid()) {
            throw new \Pluf\Exception('cannot save the asset from an invalid form');
        }
        // Create the asset
        $asset = new SDP_Asset();
        $asset->setFromFormData($this->cleaned_data);
        if ($asset->isLocal()) {
            $asset->path = Pluf::f('upload_path') . '/' . Pluf_Tenant::current()->id . '/sdp';
            if (! is_dir($asset->path)) {
                if (false == @mkdir($asset->path, 0777, true)) {
                    throw new Pluf_Form_Invalid('An error occured when creating the upload path. Please try to send the file again.');
                }
            }
            if (array_key_exists('file', $_FILES)) {
                $asset->mime_type = $this->userRequest->FILES['file']['type'];
            }
        }
        if ($commit) {
            $asset->create();
        }
        return $asset;
    }

    public function clean_name()
    {
        $fullname = trim($this->cleaned_data['name']);
        if (! isset($fullname) || strlen($fullname) == 0) {
            if (isset($this->userRequest->FILES['file'])) {
                $file = $this->userRequest->FILES['file'];
                $fullname = basename($file['name']);
            } else {
                $fullname = "noname" . rand(0, 9999);
            }
        }
        return $fullname;
    }

    public function clean_drive_id()
    {
        $di = $this->cleaned_data['drive_id'];
        $di = isset($di) && strlen($di) > 0 ? $this->cleaned_data['drive_id'] : 0;
        if ($di > 0) {
            Pluf_Shortcuts_GetObjectOr404('SDP_Drive', $di);
        }
        return $di;
    }

    public function clean_parent_id()
    {
        // check parent and check if parent is folder and existed
        $parentId = $this->cleaned_data['parent_id'];
        if (isset($parentId) && $parentId != 0) {
            // Note: Hadi, 1395-09: It throw exception if asset dose not exist
            Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $parentId);
        }
        return $parentId;
    }
}
