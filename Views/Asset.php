<?php
Pluf::loadFunction('SDP_Shortcuts_GetAssetOr404');

class SDP_Views_Asset
{

    public static function create($request, $match)
    {
        // initial asset data
        $extra = array(
            // 'user' => $request->user,
            'tenant' => $request->tenant
        );
        
        if (! isset($request->REQUEST['name']) || strlen($request->REQUEST['name']) == 0) {
            if (isset($request->FILES['file'])) {
                $file = $request->FILES['file'];
                $request->REQUEST['name'] = basename($file['name']);
            } else {
                $request->REQUEST['name'] = "noname" . rand(0, 9999);
            }
        }
        
        // Create asset and get its ID
        $form = new SDP_Form_AssetCreate($request->REQUEST, $extra);
        $asset = $form->save();
        
        // Upload asset file and extract information about it (by updating asset)
        $extra['asset'] = $asset;
        $form = new SDP_Form_AssetUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        try {
            $asset = $form->update();
        } catch (Pluf_Exception $e) {
            $asset->delete();
            throw $e;
        }
        
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function find($request, $match)
    {
        $asset = new Pluf_Paginator(new SDP_Asset());
        $sql = new Pluf_SQL('tenant=%s', array(
            $request->tenant->id
        ));
        $asset->forced_where = $sql;
        $asset->list_filters = array(
            'id',
            'name',
            'size',
            'download',
            'driver_type',
            'driver_id',
            'creation_dtime',
            'modif_dtime',
            'type',
            'mime_type',
            'price',
            'parent'
        );
        $list_display = array(
            'name',
            'type',
            'size',
            'price',
            'download',
            'driver_type',
            'driver_id',
            'parent'
        );
        
        $search_fields = array(
            'name',
            'driver_type',
            'driver_id',
            'creation_dtime',
            'modif_dtime',
            'type',
            'description',
            'mime_type'
        );
        $sort_fields = array(
            'id',
            'name',
            'size',
            'download',
            'driver_type',
            'driver_id',
            'creation_date',
            'modif_dtime',
            'type',
            'mime_type',
            'price',
            'parent'
        );
        $asset->configure($list_display, $search_fields, $sort_fields);
        $asset->items_per_page = 10;
        $asset->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($asset->render_object());
    }

    public static function get($request, $match)
    {
        // تعیین داده‌ها
        $asset = SDP_Shortcuts_GetAssetOr404($match["id"]);
        // حق دسترسی
        // CMS_Precondition::userCanAccessContent($request, $content);
        // اجرای درخواست
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function update($request, $match)
    {
        // تعیین داده‌ها
        $asset = SDP_Shortcuts_GetAssetOr404($match["id"]);
        // حق دسترسی
        // CMS_Precondition::userCanUpdateContent($request, $content);
        // اجرای درخواست
        $extra = array(
            // 'user' => $request->user,
            'asset' => $asset,
            'tenant' => $request->tenant
        );
        
        $form = new SDP_Form_AssetUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        $asset = $form->update();
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function delete($request, $match)
    {
        // تعیین داده‌ها
        $asset = SDP_Shortcuts_GetAssetOr404($match["id"]);
        // دسترسی
        // CMS_Precondition::userCanDeleteContent($request, $content);
        // اجرا
        $asset_copy = SDP_Shortcuts_GetAssetOr404($asset->id);
        $asset_copy->path = "";
        
        $asset->delete();
        
        return new Pluf_HTTP_Response_Json($asset_copy);
    }

    public static function updateFile($request, $match)
    {
        // GET data
        $app = $request->tenant;
        $asset = SDP_Shortcuts_GetAssetOr404($match["id"]);
        // Check permission
        // SaaS_Precondition::userCanAccessApplication($request, $app);
        // SaaS_Precondition::userCanAccessResource($request, $content);
        
        if (array_key_exists('file', $request->FILES)) {
            $extra = array(
                // 'user' => $request->user,
                'asset' => $asset,
                'tenant' => $request->tenant
            );
            $form = new SDP_Form_ContentUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
            $asset = $form->update();
            // return new Pluf_HTTP_Response_Json($content);
        } else {
            
            // Do
            $myfile = fopen($asset->path . '/' . $asset->id, "w") or die("Unable to open file!");
            $entityBody = file_get_contents('php://input', 'r');
            fwrite($myfile, $entityBody);
            fclose($myfile);
            $asset->file_size = filesize($asset->path . '/' . $asset->id);
            $asset->update();
        }
        return new Pluf_HTTP_Response_Json($asset);
    }
}