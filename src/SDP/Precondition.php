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
 * SDP system conditions.
 *
 * Some preconditions which are used in the view layer
 *
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 */
class SDP_Precondition extends User_Precondition
{

    /**
     * Check if the user is an asset provider.
     *
     * A user is provider if he/she has one of the following permissions:
     * <ul>
     * <li>tenant.owner</li>
     * <li>sdp.provider</li>
     * </ul>
     *
     * @param
     *            Pluf_HTTP_Request
     * @return boolean|Pluf_Exception_PermissionDenied
     */
    static public function providerRequired($request)
    {
        $res = User_Precondition::loginRequired($request);
        if (true !== $res) {
            return $res;
        }
        if ($request->user->hasPerm('tenant.owner') || //
        $request->user->hasPerm('sdp.provider')) {
            return true;
        }
        throw new Pluf_Exception_PermissionDenied();
    }

    /**
     * Check if the user is an asset provider.
     *
     * User is provider if he/she has one of the following permissions:
     * <ul>
     * <li>tenant.owner</li>
     * <li>sdp.provider</li>
     * </ul>
     *
     * @param
     *            Pluf_HTTP_Request
     * @return boolean
     */
    static public function isProvider($request)
    {
        if (! User_Precondition::isLogedIn($request)) {
            return false;
        }
        if ($request->user->hasPerm('tenant.owner') || //
        $request->user->hasPerm('sdp.provider')) {
            return true;
        }
        return false;
    }

    static public function canUpdateReview(User_Account $account, int $reviewId) : bool
    {
        return $account->hasPerm('tenant.owner') || $account->id == $reviewId;
    }
}

