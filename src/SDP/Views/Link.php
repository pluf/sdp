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

Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

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
        return $link;
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
        if ($max < 0) {
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
        return $link;
    }

    public static function find($request, $match)
    {
        // Restrict find to current user or user is owner of tenant
        $links = new Pluf_Paginator(new SDP_Link());
        if (! User_Precondition::isOwner($request)) {
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
        Pluf::loadFunction('SDP_Shortcuts_NormalizeItemPerPage');
        $links->items_per_page = SDP_Shortcuts_NormalizeItemPerPage($request);
        $links->setFromRequest($request);
        return $links;
    }

    public static function download($request, $match)
    {
        Pluf::loadFunction('SDP_Shortcuts_GetLinkBySecureIdOr404');
        $link = SDP_Shortcuts_GetLinkBySecureIdOr404($match['secure_link']);
        $asset = $link->get_asset();
        // Check that asset has price or not
        if ($asset->price != null && $asset->price > 0) {
            if (! $link->active)
                throw new SDP_Exception_ObjectNotFound("Link is not active.");
        }
        // Check link expiry
        if (date("Y-m-d H:i:s") > $link->expiry) {
            // Error: Link Expiry
            throw new SDP_Exception_ObjectNotFound("Link has been expired.");
        }

        $drive = $asset->get_drive();
        $driver = $drive->get_driver();
        $response = $driver->getDownloadResponse($link, $request);

        // Note: Hadi 1397-03-28: Increase download counter only if download request is not partial or contains first part of file
        $httpRange = isset($request->SERVER['HTTP_RANGE']) ? $request->SERVER['HTTP_RANGE'] : null;
        if (SDP_Views_Link::containsFirstPortion($httpRange, $asset->size)) {
            $link->download ++;
            $link->update();
            // Hadi, 1395-11-07: download counter of asset should be increased.
            $asset->download ++;
            $asset->update();
        }
        return $response;
    }

    private static function containsFirstPortion($httpRange, $totalSize)
    {
        if ($httpRange && $range = stristr(trim($httpRange), 'bytes=')) {
            $range = substr($range, 6);
            $ranges = explode(',', $range);
            $t = count($ranges);
            if ($t <= 0) {
                // request file completely in one part
                return true;
            }
            // $t > 0
            $start = $end = 0;
            foreach ($ranges as $range) {
                SDP_Views_Link::getRange($range, $start, $end, $totalSize);
                if ($start == 0) {
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
        $asset = $link->get_asset();

        // Check if link is payed
        if ($link->isPayed()) {
            throw new Pluf_Exception_PermissionDenied('Could not pay again for an already payed link');
        }

        // Check if currency of backend is compatible with currency of tenant
        $backend = Pluf_Shortcuts_GetObjectOr404('Bank_Backend', $request->REQUEST['backend']);
        $tenantCurrency = Tenant_Service::setting('local.currency');
        Pluf::loadFunction('Bank_Shortcuts_IsCurrenciesCompatible');
        if (! Bank_Shortcuts_IsCurrenciesCompatible($backend->currency, $tenantCurrency)) {
            throw new Pluf_Exception_BadRequest('Invalid payment. ' . //
            'Could not pay through a bank backend with different currency than the tenant currency ' . //
            '[tenant: ' . $tenantCurrency . ', backend: ' . $backend->currency);
        }

        // Check validity of price
        $price = $asset->price;
        if ($price <= 0) {
            throw new Pluf_Exception_BadRequest('Invalid amount: ' . $price);
        }
        Pluf::loadFunction('Bank_Shortcuts_ConvertCurrency');
        $price = Bank_Shortcuts_ConvertCurrency($price, $tenantCurrency, $backend->currency);

        // Check for discount
        if (isset($request->REQUEST['discount_code'])) {
            $discountCode = $request->REQUEST['discount_code'];
            $price = Discount_Service::getPrice($price, $discountCode, $request);
            $discount = Discount_Service::consumeDiscount($discountCode);
            $link->discount_code = $discountCode;
        }

        $url = $request->REQUEST['callback'];
        $receiptData = array(
            'amount' => $price,
            'title' => $asset->name,
            'description' => $asset->id . ' - ' . $asset->name,
            // 'email' => $user->email,
            // 'phone' => $user->phone,
            'email' => '',
            'phone' => '',
            'callbackURL' => $url,
            'backend_id' => $backend->id
        );

        $payment = Bank_Service::create($receiptData, 'sdp-link', $link->id);

        $link->payment_id = $payment;
        $link->update();
        return $payment;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public static function activate($request, $match)
    {
        // $link = Pluf_Shortcuts_GetObjectOr404('SDP_Link', $match['id']);
        // $link = SDP_Views_Link::updateActivationInfo($link);
        // return new Pluf_HTTP_Response_Json($link);
        return SDP_Views_Asset::get($request, $match);
    }

    /**
     * Checks
     *
     * @param SDP_Link $link
     * @return SDP_Link
     */
    private static function updateActivationInfo($link)
    {
        if ($link->active || ! $link->payment_id) {
            return $link;
        }
        $receipt = $link->get_payment();
        Bank_Service::update($receipt);
        if ($link->get_payment()->isPayed())
            $link->activate();
        return $link;
    }
}
