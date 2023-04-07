<?php

namespace Jaysc\Prefix\XF\Template;

class Templater extends XFCP_Templater
{
    public const PREFIX_ID_EXTENDED = "prefix_id_extended";

    public function fnPageNav($templater, &$escape, array $config)
    {
        $params = &$config['params'];
        if ($params && array_key_exists(Templater::PREFIX_ID_EXTENDED, $params)) {
            $prefix_ids = $params[Templater::PREFIX_ID_EXTENDED];

            if (!empty($prefix_ids)){
                $prefix_string = implode(',', $prefix_ids);

                $params['prefix_id'] = $prefix_string;
                unset($params[Templater::PREFIX_ID_EXTENDED]);
            }
        }
;
        return Parent::fnPageNav($templater, $escape, $config);
    }
}