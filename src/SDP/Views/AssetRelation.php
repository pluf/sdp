<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

/**
 * AssetRelation views
 *
 * @author hadi<mohammad.hadi.mansouri@dpq.co.ir>
 */
class SDP_Views_AssetRelation
{

    /**
     * Creates new instance of a asset relation.
     * If bidirectional param in request is true it create two asset relation.
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @param array $p
     * @return Pluf_HTTP_Response
     */
    public function create($request, $match, $p)
    {
        // check start
        $startAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $request->REQUEST['start']);
        // check end
        $endAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $request->REQUEST['end']);
        // create relation
        $plufService = new Pluf_Views();
        $exception = null;
        try {
            $resultObj = $plufService->createObject($request, $match, $p);
        } catch (Exception $e) {
            if ($e->getStatus() === 400 && strpos($e->getMessage(), 'Duplicate entry') === 0) {
                $exception = $e;
            } else {
                throw $e;
            }
        }
        // create reverse relation if relation should be bidirectional
        if (array_key_exists('bidirectional', $request->REQUEST) && $request->REQUEST['bidirectional'] == 'true') {
            // swap start and end
            $start = $request->REQUEST['start'];
            $request->REQUEST['start'] = $request->REQUEST['end'];
            $request->REQUEST['end'] = $start;
            // create reverse relation
            try {
                $plufService->createObject($request, $match, $p);
            } catch (Exception $e) {
                // do nothing
            }
        }
        if($exception == null)
            return new Pluf_HTTP_Response_Json($resultObj);
        throw $exception;
    }
}