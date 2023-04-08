<?php

namespace Jaysc\Prefix\XF\Pub\Controller;

use stdClass;
use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public const PREFIX_ID_EXTENDED = "prefix_id_extended";

	public function actionForum(ParameterBag $params)
    {
        /** @var \XF\Mvc\Reply\View $result */
        $result = Parent::actionForum($params);

        $filters = $result->getParams()['filters'];

        $view_prefix_id_extended = [];
        if ($filters) {
            $prefix_id_extended = $filters['prefix_id_extended'];

            if ($prefix_id_extended) {
                $view_prefix_id_extended['current'] = implode(',', $prefix_id_extended);

                foreach ($prefix_id_extended as $value) {
                    $view_prefix_id_extended[$value] = implode(',', array_diff($prefix_id_extended, [$value]));
                }
            }
        }

        $result->setParam('view_prefix_id_extended', $view_prefix_id_extended);
        
        return $result;
    }

	protected function getForumFilterInput(\XF\Entity\Forum $forum)
    {
        $filters = parent::getForumFilterInput($forum);

        $input = $this->filter([
			'prefix_id' => 'str',
		]);

        $firstElement = reset($input);

        if ($firstElement) {
            $string_ids = explode(",", $firstElement);
            if (count($string_ids) > 0) {
                $prefix_ids = array_map(function ($string) {
                    return is_numeric($string) ? intval($string, 10) : null;
                }, $string_ids);

                $prefix_ids = array_unique($prefix_ids);

                if (!empty($prefix_ids)){
                    $filters[FORUM::PREFIX_ID_EXTENDED] = $prefix_ids;
                }
            }
        }

        return $filters;
    }

	protected function applyForumFilters(
		\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters
	)
    {
        if (array_key_exists(FORUM::PREFIX_ID_EXTENDED, $filters)) {
            $prefix_ids = $filters[FORUM::PREFIX_ID_EXTENDED];

            if (!empty($prefix_ids)){
                $threadFinder->where('prefix_id', $prefix_ids);
            }

            $filters['prefix_id'] = null;
        }

        parent::applyForumFilters($forum, $threadFinder, $filters);
    }
}