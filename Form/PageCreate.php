<?php

/**
 * ایجاد یک صفحه جدید
 *
 * با استفاده از این فرم می‌توان یک صفحه جدید را ایجاد کرد.
 * 
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *
 */
class CMS_Form_PageCreate extends Pluf_Form
{

    public $tenant = null;
    // public $user = null;
    public function initFields($extra = array())
    {
        $this->tenant = $extra['tenant'];
        // $this->user = $extra['user'];
        
        $this->fields['name'] = new Pluf_Form_Field_Varchar(array(
            'required' => true,
            'label' => 'Name',
            'help_text' => 'Name of page'
        ));
        
        $this->fields['content'] = new Pluf_Form_Field_Integer(array(
            'required' => true,
            'label' => 'Content Id',
            'help_text' => 'Content id related to page'
        ));
    }

    function save($commit = true)
    {
        if (! $this->isValid()) {
            throw new Pluf_Exception('cannot save the page from an invalid form');
        }
        // Create the page
        $page = new CMS_Page();
        $page->setFromFormData($this->cleaned_data);
        $page->tenant = $this->tenant;
        if ($commit) {
            $page->create();
        }
        return $page;
    }

    public function clean_content()
    {
        $contentId = $this->cleaned_data['content'];
        $content = CMS_Shortcuts_GetContentOr404($contentId);
        // TODO: hadi 1395-01-26: بررسی صحت محتوا
        return $content->id;
    }
}
