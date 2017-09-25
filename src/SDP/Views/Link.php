<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('SDP_Shortcuts_Mime2Ext');

class SDP_Views_Link
{

    public static function create($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['asset_id']);
        
        // initial link data
        $extra = array(
            'user' => $request->user,
            'asset' => $asset
        );
        
        // Create link and get its ID
        $form = new SDP_Form_LinkCreate($request->REQUEST, $extra);
        $link = $form->save();
        // If asset is without price, created link will be activated automatically.
        if ($asset->price == null)
            $link->activate();
        return new Pluf_HTTP_Response_Json($link);
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
        // XXX: hadi: restrict find to current user or user is owner of tenant 
        $links = new Pluf_Paginator(new SDP_Link());
        $links->list_filters = array(
            'id',
            'secure_link',
            'expiry',
            'download',
            'asset'
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
            'asset'
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
        $httpRange = isset($request->SERVER['HTTP_RANGE']) ? $request->SERVER['HTTP_RANGE'] : null;
        $response = new Pluf_HTTP_Response_ResumableFile($asset->path . '/' . $asset->id, $httpRange, $asset->name . '.' . SDP_Shortcuts_Mime2Ext($asset->mime_type), $asset->mime_type);
        // TODO: do buz.
        // $size = $response->computeSize();
        $link->download ++;
        $link->update();
        // Hadi, 1395-11-07: download counter of asset should be increased.
        $asset->download ++;
        $asset->update();
        return $response;
        // throw new SDP_Exception_ObjectNotFound ( "SDP plan does not have enough priviledges." );
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
