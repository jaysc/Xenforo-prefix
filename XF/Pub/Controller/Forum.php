<?php

namespace Jaysc\Prefix\XF\Pub\Controller;

class Forum extends XFCP_Forum
{
    public const PREFIX_ID_EXTENDED = "prefix_id_extended";

	protected function getForumFilterInput(\XF\Entity\Forum $forum)
    {
        $filters = parent::getForumFilterInput($forum);

        $input = $this->filter([
			'prefix_id' => 'str',
		]);

        $firstElement = reset($input);

        if ($firstElement) {
            $string_ids = explode(",", $firstElement);
            if (count($string_ids) > 1) {
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