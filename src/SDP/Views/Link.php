<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('SDP_Shortcuts_Mime2Ext');

class SDP_Views_Link
{

    public static function create($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['asset_id']);
        
        // Check number free link
        if ($asset->price == null || $asset->price == 0) {
            SDP_Views_Link::increaseLinkCount($request);
        }
        
        // initial link data
        $extra = array(
            'user' => $request->user,
            'asset' => $asset
        );
        
        // Create link and get its ID
        $form = new SDP_Form_LinkCreate($request->REQUEST, $extra);
        $link = $form->save();
        // If asset is without price, created link will be activated automatically.
        if ($asset->price == null || $asset->price == 0) {
            $link->activate();
        }
        return new Pluf_HTTP_Response_Json($link);
    }

    /**
     * Checks number of created free links by current session and increases the number.
     * It throws exception if current session has received maximum daily count.
     *
     * @param Pluf_HTTP_Request $request
     * @throws Pluf_Exception_Forbidden
     */
    private static function increaseLinkCount($request)
    {
        $max = Tenant_Service::setting(SDP_Constants::SETTING_KEY_MAX_DAILY_FREE_LINK, - 1);
        if($max < 0){
            return;
        }
        $userSpaceData = $request->user_space->getData(SDP_Constants::USERSPACE_KEY_SDP_DATE, null);
        $linkCount = $request->user_space->getData(SDP_Constants::USERSPACE_KEY_SDP_LINK_COUNT, 0);
        $today = gmdate('Y-m-d');
        if ($userSpaceData === null || $userSpaceData !== $today) {
            $request->user_space->setData(SDP_Constants::USERSPACE_KEY_SDP_DATE, $today);
            $request->user_space->setData(SDP_Constants::USERSPACE_KEY_SDP_LINK_COUNT, 0);
            $linkCount = 0;
        }
        if ($max > 0 && $linkCount >= $max) {
            throw new Pluf_Exception_Forbidden('you are received maximum daily count free link');
        }
        $request->user_space->setData(SDP_Constants::USERSPACE_KEY_SDP_LINK_COUNT, $linkCount + 1);
    }

    public static function get($request, $match)
    {
        $link = Pluf_Shortcuts_GetObjectOr404('SDP_Link', $match['id']);
        // TODO: hadi: check if user is owner of tenant or owner of link
        $link = SDP_Views_Link::updateActivationInfo($link);
        return new Pluf_HTTP_Response_Json($link);
    }

    public static function find($request, $match)
    {
        // Restrict find to current user or user is owner of tenant
        $links = new Pluf_Paginator(new SDP_Link());
        if (!User_Precondition::isOwner($request)){
            $links->forced_where = new Pluf_SQL('`user`=%s', array(
                $request->user->id
            ));
        }
        $links->list_filters = array(
            'id',
            'secure_link',
            'expiry',
            'download',
            'active',
            'discount_code',
            'asset',
            'user'
        );
        $search_fields = array(
            'id',
            'secure_link',
            'expiry',
            'download',
            'asset'
        );
        $sort_fields = array(
            'id',
            'secure_link',
            'expiry',
            'download',
            'creation_dtime',
            'active',
            'discount_code',
            'asset',
            'user'
        );
        $links->configure(array(), $search_fields, $sort_fields);
        $links->items_per_page = SDP_Shortcuts_NormalizeItemPerPage($request);
        $links->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($links->render_object());
    }

    public static function download($request, $match)
    {
        $link = SDP_Shortcuts_GetLinkBySecureIdOr404($match['secure_link']);
        // Check that asset has price or not
        if ($link->get_asset()->price != null && $link->get_asset()->price > 0) {
            if (! $link->active)
                throw new SDP_Exception_ObjectNotFound("Link is not active.");
        }
        // Check link expiry
        if (date("Y-m-d H:i:s") > $link->expiry) {
            // Error: Link Expiry
            throw new SDP_Exception_ObjectNotFound("Link has been expired.");
        }
        
        $asset = $link->get_asset();
        // Mahdi: Added file extension
        // Do Download
        $filepath = $asset->path . '/' . $asset->id;
        $httpRange = isset($request->SERVER['HTTP_RANGE']) ? $request->SERVER['HTTP_RANGE'] : null;
        $response = new Pluf_HTTP_Response_ResumableFile(
            $filepath, 
            $httpRange, 
            $asset->name . '.' . SDP_Shortcuts_Mime2Ext($asset->mime_type), 
            $asset->mime_type);
        // TODO: do buz.
        // $size = $response->computeSize();
        // Note: Hadi 1397-03-28: Increase download counter only if download request is not partial or contains first part of file
        if(SDP_Views_Link::containsFirstPortion($httpRange, filesize($filepath))){            
            $link->download ++;
            $link->update();
            // Hadi, 1395-11-07: download counter of asset should be increased.
            $asset->download ++;
            $asset->update();
        }
        return $response;
    }

    private static function containsFirstPortion($httpRange, $totalSize){
        if ($httpRange && $range = stristr(trim($httpRange), 'bytes=')) {
            $range = substr($range, 6);
            $ranges = explode(',', $range);
            $t = count($ranges);
            if($t <= 0){
                // request file completely in one part
                return true;                
            }
            // $t > 0
            $start = $end = 0;
            foreach ($ranges as $range) {
                SDP_Views_Link::getRange($range, $start, $end, $totalSize);
                if($start == 0){
                    return true;
                }
            }
            return false;
        }
        // request file completely in one part
        return true;
    }
    
    private static function getRange($range, &$start, &$end, $fileSize)
    {
        list ($start, $end) = explode('-', $range);
        if ($start == '') {
            $tmp = $end;
            $end = $fileSize - 1;
            $start = $fileSize - $tmp;
            if ($start < 0)
                $start = 0;
        } else {
            if ($end == '' || $end > $fileSize - 1)
                $end = $fileSize - 1;
        }
        if ($start > $end) {
            // Requested range is not satisfiable
        }
        return array(
            $start,
            $end
        );
    }
    
    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public static function payment($request, $match)
    {
        $link = Pluf_Shortcuts_GetObjectOr404('SDP_Link', $match['linkId']);
        
        $user = $request->user;
        $url = $request->REQUEST['callback'];
        $backend = $request->REQUEST['backend'];
        $asset = $link->get_asset();
        $price = $asset->price;
        
        // check for discount
        if (isset($request->REQUEST['discount_code'])) {
            $discountCode = $request->REQUEST['discount_code'];
            $price = Discount_Service::getPrice($price, $discountCode, $request);
            $discount = Discount_Service::consumeDiscount($discountCode);
            $link->discount_code = $discountCode;
        }
        
        $receiptData = array(
            'amount' => $price, // مقدار پرداخت به تومان
            'title' => $asset->name,
            'description' => $asset->id . ' - ' . $asset->name,
            'email' => $user->email,
            // 'phone' => $user->phone,
            'phone' => '',
            'callbackURL' => $url,
            'backend' => $backend
        );
        
        $payment = Bank_Service::create($receiptData, 'sdp-link', $link->id);
        
        $link->payment = $payment;
        $link->update();
        return new Pluf_HTTP_Response_Json($payment);
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public static function activate($request, $match)
    {
        $link = Pluf_Shortcuts_GetObjectOr404('SDP_Link', $match['linkId']);
        $link = SDP_Views_Link::updateActivationInfo($link);
        return new Pluf_HTTP_Response_Json($link);
    }

    /**
     * Checks
     *
     * @param SDP_Link $link
     * @return SDP_Link
     */
    private static function updateActivationInfo($link)
    {
        if ($link->active || ! $link->payment) {
            return $link;
        }
        $receipt = $link->get_payment();
        Bank_Service::update($receipt);
        if ($link->get_payment()->isPayed())
            $link->activate();
        return $link;
    }
}
