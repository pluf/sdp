<?php

class SDP_Views_AssetScreenshot extends Pluf_Views
{

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return SDP_AssetScreenshot
     */
    public function create($request, $match)
    {
        $screenshot = $this->createManyToOne($request, $match, array(
            'model' => 'SDP_AssetScreenshot',
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id'
        ));
        $path = Pluf_Tenant::storagePath() . '/sdp-asset-screenshot';
        if (! is_dir($path)) {
            if (false == @mkdir($path, 0777, true)) {
                throw new Pluf_Form_Invalid('An error occured when creating the upload path. Please try to send the file again.');
            }
        }
        $screenshot->file_path = $path . '/' . $screenshot->id;
        $extra = array(
            'model' => $screenshot
        );
        $form = new SDP_Form_AssetScreenshotUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        try {
            $screenshot = $form->save();
        } catch (\Pluf\Exception $e) {
            $screenshot->delete();
            throw $e;
        }
        return $screenshot;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_File
     */
    public function download($request, $match)
    {
        Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
        // Check asset
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['parentId']);
        // Check screenshot
        if (! array_key_exists('modelId', $match)) {
            throw new Pluf_Exception_BadRequest('screenshot id required');
        }
        $screenshot = Pluf_Shortcuts_GetObjectOr404('SDP_AssetScreenshot', $match['modelId']);
        if ($asset->id != $screenshot->get_asset()->id) {
            throw new Pluf_Exception_DoesNotExist('given screenshot is not blong to given asset');
        }
        $response = new Pluf_HTTP_Response_File($screenshot->getAbsloutPath(), $screenshot->mime_type);
        return $response;
    }

    /**
     * Upload a file as asset-screenshot
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return object
     */
    public function upload($request, $match)
    {
        Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['parentId']);
        $screenshot = Pluf_Shortcuts_GetObjectOr404('SDP_AssetScreenshot', $match['modelId']);
        if ($asset->id != $screenshot->get_asset()->id) {
            throw new Pluf_Exception_DoesNotExist('given screenshot is not blong to given asset');
        }
        // Update the content of the screenshot
        if (array_key_exists('file', $request->FILES)) {
            $extra = array(
                'model' => $screenshot
            );
            $form = new SDP_Form_AssetScreenshotUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
            $screenshot = $form->save();
        } else {
            $myfile = fopen($screenshot->getAbsloutPath(), "w") or die("Unable to open file!");
            $entityBody = file_get_contents('php://input', 'r');
            fwrite($myfile, $entityBody);
            fclose($myfile);
            $screenshot->update();
        }
        return $screenshot;
    }
}

